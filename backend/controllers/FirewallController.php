<?php

namespace backend\controllers;

use common\models\UploadFileFirewall;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
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
        }
        throw new BadRequestHttpException('Make sure you supply enough parameters');
    }

	private function upload(){
		$post = Yii::$app->request->post();
        if(!Yii::$app->user->isGuest && $post){
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
