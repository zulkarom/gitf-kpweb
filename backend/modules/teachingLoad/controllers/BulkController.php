<?php

namespace backend\modules\teachingLoad\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\filters\AccessControl;
use backend\models\SemesterForm;
use backend\models\Semester;
use backend\modules\teachingLoad\models\AutoLoad;
use backend\modules\teachingLoad\models\TutorialTutor;
use backend\modules\teachingLoad\models\LecLecturer;
use backend\modules\teachingLoad\models\CourseLecture;
use backend\modules\teachingLoad\models\TemAutoload;
/**
 * Default controller for the `teaching-load` module
 */
class BulkController extends Controller
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
		$semester = new SemesterForm;
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

		$result = [];
		if($semester->load(Yii::$app->request->post())){
			//print_r(Yii::$app->request->post());die();
			$action = Yii::$app->request->post('btn-action');
			if($action == 0){
				$result = $this->deleteAllLoading($semester->semester_id);
			}
			if($action == 1){
				$auto = new AutoLoad;
				$auto->semester = $semester->semester_id;
				$result = $auto->runLoading();
			}
		}
		
        return $this->render('index',[
			'semester' => $semester,
			'result' => $result,
		]);
    }
	
	public function deleteAllLoading($semester){
		
		$tutorials = TutorialTutor::find()
		->select('tld_tutorial_tutor.id')
		->joinWith(['tutorialLec.lecture.courseOffered'])
		->where(['semester_id' => $semester])
		->all();
		if($tutorials){
			TutorialTutor::deleteAll(['in', 'id', ArrayHelper::map($tutorials, 'id', 'id')]);
		} 
		
		
		$lectures = LecLecturer::find()
		->select('tld_lec_lecturer.id')
		->joinWith(['courseLecture.courseOffered'])
		->where(['semester_id' => $semester])
		->all();
		if($lectures){
			LecLecturer::deleteAll(['in', 'id', ArrayHelper::map($lectures, 'id', 'id') ]);
		}

		TemAutoload::deleteAll();

		return ['Deleting all teaching loads successful for semester ' . $semester];
	}
}
