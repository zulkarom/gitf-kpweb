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
    /**
     * {@inheritdoc}
     */
	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

	public function actionUpload(){
		$post = Yii::$app->request->post();
        if($post){
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

    public function actionEditor()
    {
        $post = Yii::$app->request->post();
        if($post){
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
