<?php

namespace backend\controllers;

use common\models\UploadFileFirewall;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;
use yii\web\Response;

/**
 * PaperController implements the CRUD actions for ConfPaper model.
 */
class FirewallController extends Controller
{
    public function actionIndex(){
        $post = Yii::$app->request->post();
        if(!Yii::$app->user->isGuest && $post){
            $request_type = $post['request_type'] ?? null;
            if($request_type == 'upload'){
                return $this->upload($post);
            }
            if($request_type == 'editor'){
                return $this->editor($post);
            }
            if($request_type == 'postgrad_status_csv'){
                return $this->postgradStatusCsv();
            }
            if($request_type == 'postgrad_student_csv'){
                return $this->postgradStudentCsv();
            }
            if($request_type == 'postgrad_student_reg_csv'){
                return $this->postgradStudentRegCsv();
            }
            if($request_type == 'postgrad_exam_committee_csv'){
                return $this->postgradExamCommitteeCsv();
            }
            if($request_type == 'postgrad_thesis_title_csv'){
                return $this->postgradThesisTitleCsv();
            }
        }
        throw new BadRequestHttpException('Make sure you supply enough parameters');
    }

	private function upload(){
		$post = Yii::$app->request->post();
        if(!Yii::$app->user->isGuest && $post){
            if (($post['mode'] ?? null) === 'test') {
                $file = UploadedFile::getInstanceByName('file');
                if (!$file) {
                    throw new BadRequestHttpException('Make sure you supply enough parameters');
                }

                $username = Yii::$app->user->identity->username;
                $directory = Yii::getAlias('@upload/test/' . $username . '/');
                if (!is_dir($directory)) {
                    FileHelper::createDirectory($directory);
                }

                $token = bin2hex(random_bytes(8));
                $safeExt = preg_replace('/[^a-zA-Z0-9]/', '', (string)$file->extension);
                $fileName = 'upload-test-' . $token . ($safeExt ? '.' . strtolower($safeExt) : '');
                $filePath = $directory . $fileName;

                if (!$file->saveAs($filePath)) {
                    return $this->renderContent('<div class="alert alert-danger">Upload failed: unable to save file</div>');
                }

                $rel = 'test/' . $username . '/' . $fileName;
                $html = '<div class="alert alert-success">Upload OK</div>'
                    . '<div><strong>Original name:</strong> ' . htmlspecialchars($file->name, ENT_QUOTES, 'UTF-8') . '</div>'
                    . '<div><strong>Saved as:</strong> ' . htmlspecialchars($rel, ENT_QUOTES, 'UTF-8') . '</div>'
                    . '<div><strong>Size:</strong> ' . (int)$file->size . '</div>';
                return $this->renderContent($html);
            }

            $id= $post['id'];
            $class = urldecode($post['class']);
            $controller = $post['controller'];
            $attr = $post['attr'];
            if($class && $attr && $controller && $id){
                $model = $this->findModel($class, $id);
                $model->file_controller = $controller;
                return UploadFileFirewall::upload($model, $attr, 'updated_at');
            }
        }
		
		throw new BadRequestHttpException('Make sure you supply enough parameters');
    }

    private function postgradStatusCsv()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $file = UploadedFile::getInstanceByName('file');
        if (!$file) {
            throw new BadRequestHttpException('Make sure you supply enough parameters');
        }

        $ext = strtolower((string)$file->extension);
        if ($ext !== 'csv') {
            return ['error' => 'Invalid file type, allowed only csv'];
        }

        $maxSize = 10 * 1024 * 1024;
        if ($file->size > $maxSize) {
            return ['error' => 'The file size (' . $file->size . ') exceed allowed maximum size of (' . $maxSize . ')'];
        }

        $token = bin2hex(random_bytes(16));

        $directory = Yii::getAlias('@runtime/postgrad-status-upload/');
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }

        $fileName = 'student-status-' . $token . '.csv';
        $filePath = $directory . $fileName;
        if (!$file->saveAs($filePath)) {
            return ['error' => 'Unable to save uploaded CSV file'];
        }

        $session = Yii::$app->session;
        $map = $session->get('postgrad_status_csv_tokens', []);
        $map[$token] = $filePath;
        $session->set('postgrad_status_csv_tokens', $map);

        return [
            'token' => $token,
            'name' => $file->name,
            'size' => $file->size,
        ];
    }

    private function postgradThesisTitleCsv()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $file = UploadedFile::getInstanceByName('file');
        if (!$file) {
            throw new BadRequestHttpException('Make sure you supply enough parameters');
        }

        $ext = strtolower((string)$file->extension);
        if ($ext !== 'csv') {
            return ['error' => 'Invalid file type, allowed only csv'];
        }

        $maxSize = 10 * 1024 * 1024;
        if ($file->size > $maxSize) {
            return ['error' => 'The file size (' . $file->size . ') exceed allowed maximum size of (' . $maxSize . ')'];
        }

        $token = bin2hex(random_bytes(16));

        $directory = Yii::getAlias('@runtime/postgrad-thesis-title-upload/');
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }

        $fileName = 'thesis-title-' . $token . '.csv';
        $filePath = $directory . $fileName;
        if (!$file->saveAs($filePath)) {
            return ['error' => 'Unable to save uploaded CSV file'];
        }

        $session = Yii::$app->session;
        $map = $session->get('postgrad_thesis_title_csv_tokens', []);
        $map[$token] = $filePath;
        $session->set('postgrad_thesis_title_csv_tokens', $map);

        return [
            'token' => $token,
            'name' => $file->name,
            'size' => $file->size,
        ];
    }

    private function postgradStudentRegCsv()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $file = UploadedFile::getInstanceByName('file');
        if (!$file) {
            throw new BadRequestHttpException('Make sure you supply enough parameters');
        }

        $ext = strtolower((string)$file->extension);
        if ($ext !== 'csv') {
            return ['error' => 'Invalid file type, allowed only csv'];
        }

        $maxSize = 10 * 1024 * 1024;
        if ($file->size > $maxSize) {
            return ['error' => 'The file size (' . $file->size . ') exceed allowed maximum size of (' . $maxSize . ')'];
        }

        $token = bin2hex(random_bytes(16));

        $directory = Yii::getAlias('@runtime/postgrad-student-reg-upload/');
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }

        $fileName = 'student-reg-import-' . $token . '.csv';
        $filePath = $directory . $fileName;
        if (!$file->saveAs($filePath)) {
            return ['error' => 'Unable to save uploaded CSV file'];
        }

        $session = Yii::$app->session;
        $map = $session->get('postgrad_student_reg_csv_tokens', []);
        $map[$token] = $filePath;
        $session->set('postgrad_student_reg_csv_tokens', $map);

        return [
            'token' => $token,
            'name' => $file->name,
            'size' => $file->size,
        ];
    }

    private function postgradExamCommitteeCsv()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $file = UploadedFile::getInstanceByName('file');
        if (!$file) {
            throw new BadRequestHttpException('Make sure you supply enough parameters');
        }

        $ext = strtolower((string)$file->extension);
        if ($ext !== 'csv') {
            return ['error' => 'Invalid file type, allowed only csv'];
        }

        $maxSize = 10 * 1024 * 1024;
        if ($file->size > $maxSize) {
            return ['error' => 'The file size (' . $file->size . ') exceed allowed maximum size of (' . $maxSize . ')'];
        }

        $token = bin2hex(random_bytes(16));

        $directory = Yii::getAlias('@runtime/postgrad-exam-committee-upload/');
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }

        $fileName = 'exam-committee-' . $token . '.csv';
        $filePath = $directory . $fileName;
        if (!$file->saveAs($filePath)) {
            return ['error' => 'Unable to save uploaded CSV file'];
        }

        $session = Yii::$app->session;
        $map = $session->get('postgrad_exam_committee_csv_tokens', []);
        $map[$token] = $filePath;
        $session->set('postgrad_exam_committee_csv_tokens', $map);

        return [
            'token' => $token,
            'name' => $file->name,
            'size' => $file->size,
        ];
    }

    private function postgradStudentCsv()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $file = UploadedFile::getInstanceByName('file');
        if (!$file) {
            throw new BadRequestHttpException('Make sure you supply enough parameters');
        }

        $ext = strtolower((string)$file->extension);
        if ($ext !== 'csv') {
            return ['error' => 'Invalid file type, allowed only csv'];
        }

        $maxSize = 10 * 1024 * 1024;
        if ($file->size > $maxSize) {
            return ['error' => 'The file size (' . $file->size . ') exceed allowed maximum size of (' . $maxSize . ')'];
        }

        $token = bin2hex(random_bytes(16));

        $directory = Yii::getAlias('@runtime/postgrad-student-import-upload/');
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }

        $fileName = 'student-import-' . $token . '.csv';
        $filePath = $directory . $fileName;
        if (!$file->saveAs($filePath)) {
            return ['error' => 'Unable to save uploaded CSV file'];
        }

        $session = Yii::$app->session;
        $map = $session->get('postgrad_student_csv_tokens', []);
        $map[$token] = $filePath;
        $session->set('postgrad_student_csv_tokens', $map);

        return [
            'token' => $token,
            'name' => $file->name,
            'size' => $file->size,
        ];
    }

    private function editor()
    {
        $post = Yii::$app->request->post();
        if(!Yii::$app->user->isGuest && $post){
            $class = urldecode($post['editor_class']);
            $id = $post['editor_class_id'];
            $method = urldecode($post['editor_method']);
            $redirect = $post['editor_redirect'];
    
            if($class && $id & $method){
                $model = $this->findModel($class,$id);
                if ($model->load(Yii::$app->request->post())) {
                    if(method_exists($model, $method)){
                        if($model->$method()){
                            Yii::$app->session->addFlash('success', "Data Updated");
                            return $this->redirect($redirect);
                        }
                    }  
                }
            }
        }
        
        throw new BadRequestHttpException('Make sure you supply enough parameters');
    }

	protected function findModel($class, $id)
    {
        if (($model = $class::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
}
