<?php

namespace confsite\controllers;

use backend\modules\conference\models\ConfPaper;
use backend\modules\conference\models\ConfRegistration;
use backend\modules\conference\models\PaperReviewer;
use Yii;
use yii\web\Controller;
use confsite\models\UploadPaperFile;
use confsite\models\UploadPaymentFile;
use confsite\models\UploadReviewerFile;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;

/**
 * PaperController implements the CRUD actions for ConfPaper model.
 */
class FirewallController extends Controller
{
    public function actionIndex(){
        $post = Yii::$app->request->post();
        if(!Yii::$app->user->isGuest && $post){
            $request_type = $post['request_type'];
            if($request_type == 'upload'){
                return $this->upload($post);
            }
            if($request_type == 'editor'){
                return $this->editor($post);
            }
            if($request_type == 'form'){
                return $this->form($post);
            }
        }
        throw new BadRequestHttpException('Make sure you supply enough parameters');
    }

	private function upload($post){
            $type= $post['type'];
            $attr= $post['attr'];
            $controller= $post['controller'];
            $id= $post['id'];

            if($type && $id && $attr && $controller){
                if($type == "paper"){ //attr paper/repaper
                    /* return Yii::$app->runAction('member/upload-file', ['attr' => 'paper', 'id' => $id, 'confurl' => $confurl]); */
                    $model = $this->findPaper($id);
                    $model->file_controller = $controller;
                    return UploadPaperFile::upload($model, $attr, 'updated_at');
                }
                if($type == "review"){
                    $model = $this->findReviewer($id);
                    $model->file_controller = $controller;
                    return UploadReviewerFile::upload($model, $attr);
                }
                if($type == "payment"){ 
                    $model = $this->findRegistration($id);
                    $model->file_controller = $controller;
                    return UploadPaymentFile::upload($model, $attr, 'updated_at');
                }
            }
        throw new BadRequestHttpException('Make sure you supply enough parameters');
    }

    private function editor($post){
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

    private function form($post){
        $post = Yii::$app->request->post();

        if(!Yii::$app->user->isGuest && $post){
            $scenario = $post['scenario'];
            $confurl = $post['confurl'];
            
            if($scenario && $confurl){
                if($scenario == 'abstract_create'){

                    return Yii::$app->runAction('member/create', ['confurl' => $confurl]);

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

	protected function findPaper($id)
    {
        if (($model = ConfPaper::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findReviewer($id)
    {
        if (($model = PaperReviewer::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findRegistration($id)
    {
        if (($model = ConfRegistration::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
}
