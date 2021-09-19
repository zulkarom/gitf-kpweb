<?php

namespace backend\modules\teachingLoad\controllers;

use Yii;
use yii\db\Expression;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\models\Semester;
use backend\models\SemesterForm;
use yii\filters\AccessControl;
use backend\modules\teachingLoad\models\CourseOffered;
use backend\modules\teachingLoad\models\StaffInvolved;
use backend\modules\teachingLoad\models\StaffInvolvedSearch;
use backend\modules\teachingLoad\models\AppointmentLetter;
use backend\modules\teachingLoad\models\AppointmentLetterFile;
use backend\modules\teachingLoad\models\AppointmentLetterSearch;
use backend\modules\teachingLoad\models\GenerateReferenceForm  ;
use common\models\UploadFile;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;


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
        
        $searchModel = new StaffInvolvedSearch();
        $searchModel->semester = $semester->semester_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if(Yii::$app->request->post()){
            
            $action = Yii::$app->request->post('btn-action');
            if($action == 2){

               if($this->staffInvolved($semester->semester_id)){
				   Yii::$app->session->addFlash('success', "Run Staff Invoved Success");
				   return $this->refresh();
			   }
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
    	 ->select('distinct(staff_id) as staff_id, count(lec_name) as lec_name')
    	  ->joinWith('courseLectures.lecturers')
         ->where(['semester_id' => $semester])
		 ->groupBy('staff_id')
         ->all();

         $staff_tut = CourseOffered::find()
    	 ->select('distinct(staff_id) as staff_id, count(tutorial_name) as tutorial_name, count(lec_name) as lec_name')
    	->joinWith('courseLectures.lecTutorials.tutors')
         ->where(['semester_id' => $semester])
		  ->groupBy('staff_id')
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
			
			$to_del = StaffInvolved::find()->where(['staff_check' => 0, 'semester_id' => $semester])->all();
			$arr = ArrayHelper::map($to_del, 'id' , 'id');
			AppointmentLetter::deleteAll(['inv_id' => $arr]);
         	StaffInvolved::deleteAll(['staff_check' => 0, 'semester_id' => $semester]);
         }
    	
    	
    	return true;
    }

    public function appointLetter($s,$inv_id,$semester){
		
         AppointmentLetter::updateAll(['appoint_check' => 0], ['inv_id' => $inv_id]);
		 
         $staff_lec = CourseOffered::find()
         ->select('distinct(offered_id)')
         ->joinWith('courseLectures.lecturers')
         ->where(['semester_id' => $semester, 'staff_id' => $s])
		 ->groupBy('offered_id')
         ->all();

         $staff_tut = CourseOffered::find()
         ->select('distinct(offered_id)')
         ->joinWith('courseLectures.lecTutorials.tutors')
		 ->groupBy('offered_id')
         ->where(['semester_id' => $semester, 'staff_id' => $s])
         ->all();


         $staff_lec = ArrayHelper::map($staff_lec,'offered_id','offered_id');
         $staff_tut = ArrayHelper::map($staff_tut,'offered_id','offered_id');

         $staff = array_merge($staff_lec,$staff_tut);
		

        //run separately for lecture & tutorial
        
         if($staff_lec){
            foreach ($staff as $offer) {
                $appoint = AppointmentLetter::findOne(['offered_id' => $offer, 'inv_id' => $inv_id]);
                if($appoint === null){
                    $new =  new AppointmentLetter();
                    $new->offered_id = $offer;
                    $new->inv_id = $inv_id;
                    $new->appoint_check = 1;     
                    if(!$new->save()){
                       $new->flashError(); 
                    }
                     
                }else{
					$appoint->appoint_check = 1;
					$appoint->save();
				}
            }
         }
         
         if($staff_tut){
             foreach ($staff as $offer) {
                 if(!in_array($offer, $staff_lec)){
                     $appoint = AppointmentLetter::findOne(['offered_id' => $offer, 'inv_id' => $inv_id]);
                     if($appoint === null){
                         $new =  new AppointmentLetter();
                         $new->offered_id = $offer;
                         $new->inv_id = $inv_id;
                         $new->tutorial_only = 1;
                         $new->appoint_check = 1;
                         if(!$new->save()){
                             $new->flashError();
                         }
                         
                     }else{
                         $appoint->appoint_check = 1;
                         $appoint->tutorial_only = 1;
                         $appoint->save();
                     }
                 }
                 
             }
         }
         
         
         
		AppointmentLetter::deleteAll(['inv_id' => $inv_id, 'appoint_check' => 0]);
    }

    public function actionGenerateReference()
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
    
    public function actionDownloadAll($sem){
        $archive_file_name='APPOINTMENT_LETTER.zip';
        $zip = new \ZipArchive();
        if ($zip->open($archive_file_name, \ZIPARCHIVE::CREATE )!==TRUE) {
            exit("cannot open <$archive_file_name>\n");
        }
        $file_path = Yii::getAlias('@upload/temp/');
        
        $list = AppointmentLetter::find()
        ->joinWith('staffInvolved.staff.user')
        ->where(['semester_id' => $sem])->orderBy('user.fullname ASC')->all();
        
        if($list){
            foreach($list as $s){
                $pdf = new AppointmentLetterFile;
                $pdf->model = $s;
                $pdf->store = true;
                $file_name = $pdf->generatePdf();
                $zip->addFile($file_path.$file_name,$file_name);
            }
        }


        
        $zip->close();
        //then send the headers to force download the zip file
        header("Content-type: application/zip");
        header("Content-Disposition: attachment; filename=$archive_file_name");
        header("Pragma: no-cache");
        header("Expires: 0");
        readfile("$archive_file_name");
        exit;

    }

    public function actionApproveLetter()
    {
		$dean = \backend\modules\staff\models\StaffMainPosition::findOne(1)->staff_id;
		if(Yii::$app->user->identity->staff->id == $dean){
			
		
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

        $searchModel = new AppointmentLetterSearch();
        $searchModel->semester = $semester->semester_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        if(Yii::$app->request->post()){
            $post = Yii::$app->request->post();

            if(isset($post['selection'])){
                $selection = $post['selection'];
               
               
                foreach($selection as $select){

                    $app = AppointmentLetter::findOne($select);
                    if($post['actiontype'] == 'approve'){
                        $app->status = 10;
                    }
                    else if($post['actiontype'] == 'draft'){
                        $app->status = 1;
                    }
                    $app->save();
                }
				
				
                Yii::$app->session->addFlash('success', "Status Updated");
				return $this->refresh();
            }
        }

        return $this->render('approve-letter',[
            'semester' => $semester,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
        ]);
        
		}else{
			return $this->render('forbidden');
		}
    }
	
	public function actionUploadFile($attr, $id){
		die();
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $model->file_controller = 'staff';
		
		$path = 'course-files/'.$model->semester_id.'/'.$model->staff->staff_no ;

        return UploadFile::upload($model, $attr, 'updated_at', $path);

    }
	
	protected function findModel($id)
    {
        if (($model = StaffInvolved::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

	protected function clean($string){
		$allowed = ['timetable'];
        if(in_array($string,$allowed)){
            return $string;
        }
        throw new NotFoundHttpException('Invalid Attribute');
    }

	public function actionDeleteFile($attr, $id)
    {
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $attr_db = $attr . '_file';
        
        $file = Yii::getAlias('@upload/' . $model->{$attr_db});
        
        $model->scenario = $attr . '_delete';
        $model->{$attr_db} = '';
        $model->updated_at = new Expression('NOW()');
        if($model->save()){
            if (is_file($file)) {
                unlink($file);
                
            }
            
            return Json::encode([
                        'good' => 1,
                    ]);
        }else{
            return Json::encode([
                        'errors' => $model->getErrors(),
                    ]);
        }
        


    }

	public function actionDownloadFile($attr, $id, $identity = true){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $filename = strtoupper($attr) . ' ' . Yii::$app->user->identity->fullname;
        
        
        
        UploadFile::download($model, $attr, $filename);
    }



    
}
