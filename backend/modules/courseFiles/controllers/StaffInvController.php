<?php

namespace backend\modules\courseFiles\controllers;

use Yii;
use yii\web\Controller;
use backend\models\SemesterForm;
use backend\models\Semester;
use yii\db\Expression;
use yii\filters\AccessControl;
use backend\modules\teachingLoad\models\CourseOffered;
use backend\modules\courseFiles\models\StaffInvolved;
use yii\helpers\ArrayHelper;

class StaffInvController extends Controller
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

        if(Yii::$app->getRequest()->getQueryParam('SemesterForm')){
            $sem = Yii::$app->getRequest()->getQueryParam('SemesterForm');
            $semester->semester_id = $sem['semester_id'];

        }else{
            $semester->semester_id = Semester::getCurrentSemester()->id;
        }

		if($semester->load(Yii::$app->request->post())){	
			$action = Yii::$app->request->post('btn-action');
			if($action == 0){

				$this->staffInvolved($semester->semester_id);
			}
			if($action == 1){
					
			}
		}
        return $this->render('index',[
			'semester' => $semester,
			
		]);
    }

    public function staffInvolved($semester){

    	 $staff = CourseOffered::find()
    	 ->select('distinct(staff_id)')
    	 ->joinWith('lectures.lecturers')
         ->where(['semester_id' => $semester])
         ->all();

         $staff_tut = CourseOffered::find()
    	 ->select('distinct(staff_id)')
    	 ->joinWith('lectures.tutorials.tutors')
         ->where(['semester_id' => $semester])
         ->all();

         $staff = ArrayHelper::map($staff,'staff_id','staff_id');
         $staff_tut = ArrayHelper::map($staff_tut,'staff_id','staff_id');

         $staff = array_merge($staff,$staff_tut);
         
         if($staff)
         {
         	foreach ($staff as $s) {
         		$inv = StaffInvolved::findOne(['staff_id' => $s, 'semester_id' => $semester]);
         		if($inv === null){
         			$new =  new StaffInvolved();
         			$new->staff_id = $s;
         			$new->semester_id = $semester;
         			if(!$new->save())
         			{
         				print_r($new->getErrors());	
         			}
         		}
         	}
         }
    	
    	Yii::$app->session->addFlash('success', "Run Staff Invoved Success");
    	
    }
}