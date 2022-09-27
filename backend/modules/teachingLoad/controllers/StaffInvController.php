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
use backend\modules\teachingLoad\models\AssignmentService;
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
               if(AssignmentService::processStaffInvolve($semester->semester_id)){
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
        if(class_exists('\ZipArchive')){
            $archive_file_name='APPOINTMENT_LETTER2.zip';
            $zip = new \ZipArchive();
            if ($zip->open($archive_file_name, \ZIPARCHIVE::CREATE )!==TRUE) {
                exit("cannot open <$archive_file_name>\n");
            }
            $file_path = Yii::getAlias('@upload/temp/');
            
            $list = AppointmentLetter::find()->alias('a')
            ->joinWith('staffInvolved.staff.user')
            ->where(['a.status' => 10, 'semester_id' => $sem])->orderBy('user.fullname ASC')->all();
            
            if($list){
                foreach($list as $s){
                    if($s->manual_file){
                        $file_name = $s->staffInvolved->staff->user->fullname . '-' . $s->courseOffered->course->course_code . '.pdf';
                        
                        $attr_db = 'manual_file';
                        $file = Yii::getAlias('@upload/' . $s->{$attr_db});
                        if($s->{$attr_db}){
                            if (file_exists($file)) {
                                $zip->addFile($file,$file_name);
                            }
                        }
                        
                    }else{
                        $pdf = new AppointmentLetterFile;
                        $pdf->model = $s;
                        $pdf->store = true;
                        $file_name = $pdf->generatePdf();
                        $zip->addFile($file_path.$file_name,$file_name);
                    }
                    
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
        }else{
            echo 'dalam proses utk enable ZipArchive class';
            die();
            exit;
        }
        

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
