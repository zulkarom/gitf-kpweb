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
	public function actionUpload(){
		$post = Yii::$app->request->post();
        if(!Yii::$app->user->isGuest && $post){
            $type= $post['type'];
            $attr= $post['attr'];
            $controller= $post['controller'];
            $id= $post['id'];
            $confurl = $post['confurl'];
            //submit paper 1
            //submit review
            //submit correction
            //payment
    
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
        }
	
        throw new BadRequestHttpException('Make sure you supply enough parameters');
    }

    public function actionEditor(){
        $post = Yii::$app->request->post();
        if(!Yii::$app->user->isGuest && $post){

        }
        throw new BadRequestHttpException('Make sure you supply enough parameters');
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
