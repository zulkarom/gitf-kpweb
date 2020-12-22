<?php

namespace backend\modules\teachingLoad\controllers;

use Yii;
use yii\db\Expression;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use backend\models\Semester;
use backend\models\SemesterForm;
use yii\filters\AccessControl;
use backend\modules\teachingLoad\models\CourseOffered;
use backend\modules\teachingLoad\models\StaffInvolved;
use backend\modules\teachingLoad\models\StaffInvolvedSearch;
use backend\modules\teachingLoad\models\AppointmentLetter;
use backend\modules\teachingLoad\models\AppointmentLetterSearch;
use backend\modules\teachingLoad\models\GenerateReferenceForm  ;



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
        $searchModel = new StaffInvolvedSearch();
        $searchModel->semester = $semester->semester_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if(Yii::$app->request->post()){
            
            $action = Yii::$app->request->post('btn-action');
            if($action == 2){

                $this->staffInvolved($semester->semester_id);
            }
        }

        return $this->render('index',[
			'semester' => $semester,
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
    }

    public function staffInvolved($semester){

    	 StaffInvolved::updateAll(['staff_check' => 0], ['semester_id' => $semester]);

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
                if(!empty($s)){
         		$inv = StaffInvolved::findOne(['staff_id' => $s, 'semester_id' => $semester]);
         		if($inv === null){
         			$new =  new StaffInvolved();
         			$new->staff_id = $s;
         			$new->semester_id = $semester;
         			$new->staff_check = 1;
         			if(!$new->save())
         			{
         				print_r($new->getErrors());	
         			}
                     $inv_id = $new->id;
         		}
         		else
         		{
         			$inv->staff_check = 1;
         			$inv->save();
                    $inv_id = $inv->id;
		
         		}

               $this->appointLetter($s,$inv_id,$semester); 
           }
         	
         	}
         	StaffInvolved::deleteAll(['staff_check' => 0, 'semester_id' => $semester]);
         }
    	
    	Yii::$app->session->addFlash('success', "Run Staff Invoved Success");
    	
    }

    public function appointLetter($s,$inv_id,$semester){
        
         $staff_lec = CourseOffered::find()
         ->select('distinct(offered_id)')
         ->joinWith('lectures.lecturers')
         ->where(['semester_id' => $semester, 'staff_id' => $s])
         ->all();

         $staff_tut = CourseOffered::find()
         ->select('distinct(offered_id)')
         ->joinWith('lectures.tutorials.tutors')
         ->where(['semester_id' => $semester, 'staff_id' => $s])
         ->all();


         $staff_lec = ArrayHelper::map($staff_lec,'offered_id','offered_id');
         $staff_tut = ArrayHelper::map($staff_tut,'offered_id','offered_id');

         $staff = array_merge($staff_lec,$staff_tut);



         if($staff)
         {
            foreach ($staff as $offer) {
               // if(empty($inv_id)){
               //  echo $s;
               //  die();
               // }
                $appoint = AppointmentLetter::findOne(['offered_id' => $offer, 'inv_id' => $inv_id]);
                if($appoint === null){
             

                    $new =  new AppointmentLetter();
                    $new->offered_id = $offer;
                    $new->inv_id = $inv_id;
                           
                    if(!$new->save())
                    {
                        print_r($new->getErrors()); 
                    }
                     
                }
            }
         }

    }

    public function actionGenerateReference()
    {
         $semester = new SemesterForm;
        if(Yii::$app->getRequest()->getQueryParam('SemesterForm')){
            $sem = Yii::$app->getRequest()->getQueryParam('SemesterForm');
            $semester->semester_id = $sem['semester_id'];

        }else{
            $semester->semester_id = Semester::getCurrentSemester()->id;
        }

        $searchModel = new AppointmentLetterSearch();
        $searchModel->semester = $semester->semester_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // $appointModel = new AppointmentLetter();


        $model = new GenerateReferenceForm;
        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();

            if(isset($post['selection'])){
                $selection = $post['selection'];
                $form = $post['GenerateReferenceForm'];
                $start = $form['start_number'] + 0;
                foreach($selection as $select){
                    $app = AppointmentLetter::findOne($select);
                    if($post['actiontype'] == 'generate'){
                        $ref = $form['ref_letter'];
                        $date = $form['date'];
                        $app->ref_no = $ref . '('.$start.')';
                        $app->date_appoint = $date;
                    }
                    $app->save();
                    
                $start++;
                    
                }
            }
            

        }


        return $this->render('generate',[
            'semester' => $semester,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    
}