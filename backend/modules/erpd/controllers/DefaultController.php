<?php

namespace backend\modules\erpd\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
/**
 * Default controller for the `erpd` module
 */
class DefaultController extends Controller
{
	
	

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

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
	
	public function actionChangeResearch(){
		$res = \backend\modules\erpd\models\Research::find()->all();
		foreach($res as $r){
			$old = $r->res_file;
			if($old){
				$r->res_file = '2019/erpd/research/'. $old;
				$r->save();
			}
		}
		echo 'good research';
		
	}
	
	public function actionChangePublication(){
		$res = \backend\modules\erpd\models\Publication::find()->all();
		foreach($res as $r){
			$old = $r->pubupload_file;
			if($old){
				$r->pubupload_file = '2019/erpd/publication/'. $old;
				$r->save();
			}
		}
		echo 'good publication';
		
	}
	
	public function actionChangeAward(){
		$res = \backend\modules\erpd\models\Award::find()->all();
		foreach($res as $r){
			$old = $r->awd_file;
			if($old){
				$r->awd_file = '2019/erpd/award/'. $old;
				$r->save();
			}
		}
		echo 'good award';
		
	}
	
	public function actionChangeMembership(){
		$res = \backend\modules\erpd\models\Membership::find()->all();
		foreach($res as $r){
			$old = $r->msp_file;
			if($old){
				$r->msp_file = '2019/erpd/membership/'. $old;
				$r->save();
			}
		}
		echo 'good membership';
		
	}
	
	public function actionChangeConsultation(){
		$res = \backend\modules\erpd\models\Consultation::find()->all();
		foreach($res as $r){
			$old = $r->csl_file;
			if($old){
				$r->csl_file = '2019/erpd/consultation/'. $old;
				$r->save();
			}
		}
		echo 'good consultation';
		
	}
	
	public function actionChangeKtp(){
		$res = \backend\modules\erpd\models\KnowledgeTransfer::find()->all();
		foreach($res as $r){
			$old = $r->ktp_file;
			if($old){
				$r->ktp_file = '2019/erpd/knowledge_transfer/'. $old;
				$r->save();
			}
		}
		echo 'good ktp';
		
	}
}
