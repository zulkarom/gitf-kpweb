<?php

namespace backend\modules\postgrad\controllers;

use backend\models\Semester;
use backend\models\SemesterForm;
use backend\modules\courseFiles\models\DateSetting;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Default controller for the `postgrad` module
 */
class SettingController extends Controller
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
        
		$semester = new SemesterForm();
		$session = Yii::$app->session;
        if(Yii::$app->getRequest()->getQueryParam('SemesterForm')){
            $sem = Yii::$app->getRequest()->getQueryParam('SemesterForm');
            $semester->semester_id = $sem['semester_id'];
			$session->set('semester', $sem['semester_id']);
        }else if($session->has('semester')){
			$semester->semester_id = $session->get('semester');
		}else{
            $semester->semester_id = Semester::getCurrentSemester()->id;
        }
		
		$dates = DateSetting::find()->where(['semester_id' => $semester->semester_id])->one();
		if($dates === null){
			$dates = new DateSetting;
			$dates->semester_id = $semester->semester_id;
			$dates->save();
		}
		
		if ($dates->load(Yii::$app->request->post())) {
			if($dates->save()){
				Yii::$app->session->addFlash('success', "Data Updated");
				return $this->refresh();
			}
		}

		
		return $this->render('index', [
			'dates' => $dates,
			'semester' => $semester,
        ]);
    }
    
    
}
