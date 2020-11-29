<?php

namespace backend\modules\teachingLoad\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Expression;
use yii\filters\AccessControl;
use backend\models\SemesterForm;
use backend\models\Semester;
use backend\modules\teachingLoad\models\AutoLoad;
use backend\modules\teachingLoad\models\TutorialTutor;
use backend\modules\teachingLoad\models\LecLecturer;
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
		$semester->semester_id = Semester::getCurrentSemester()->id;
		$result = '';
		
		
		
		if($semester->load(Yii::$app->request->post())){
			//print_r(Yii::$app->request->post());die();
			$action = Yii::$app->request->post('btn-action');
			if($action == 0){
				$result = $this->deleteAllLoading();
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
	
	public function deleteAllLoading(){
		TutorialTutor::deleteAll();
		LecLecturer::deleteAll();
		TemAutoload::deleteAll();
		//Yii::$app->session->addFlash('success', "Loading Deleted");
		return ['Deleting all teaching loads successful'];
	}
}
