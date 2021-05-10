<?php

namespace backend\modules\teachingLoad\controllers;

use Yii;
use backend\modules\teachingLoad\models\CourseOffered;
use backend\modules\teachingLoad\models\CourseOfferedSearch;
use backend\modules\teachingLoad\models\CourseOfferedCoorSearch;
use backend\modules\teachingLoad\models\AddLectureForm;
use backend\modules\teachingLoad\models\AddTutorialForm;
use backend\modules\teachingLoad\models\TutorialLecture;
use backend\modules\teachingLoad\models\CourseLecture;
use backend\modules\teachingLoad\models\Course;
use backend\modules\teachingLoad\models\LecLecturer;
use backend\modules\teachingLoad\models\TutorialTutor;
use backend\modules\teachingLoad\models\BulkSessionExcel;
use backend\models\SemesterForm;
use backend\models\Semester;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * CourseOfferedController implements the CRUD actions for CourseOffered model.
 */
class CourseOfferedController extends Controller
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


    /**
     * Lists all CourseOffered models.
     * @return mixed
     */
    public function actionIndex()
    {
        $semester = new SemesterForm;
		$session = Yii::$app->session;
        if(Yii::$app->getRequest()->getQueryParam('SemesterForm')){
            $sem = Yii::$app->getRequest()->getQueryParam('SemesterForm');
            $semester->semester_id = $sem['semester_id'];
            $semester->str_search = $sem['str_search'];
			$semester->program_search = $sem['program_search'];
			$session->set('semester', $sem['semester_id']);
        }else if($session->has('semester')){
			$semester->semester_id = $session->get('semester');
		}else{
            $semester->semester_id = Semester::getCurrentSemester()->id;
        }

        $searchModel = new CourseOfferedSearch();
        $searchModel->semester = $semester->semester_id;
        $searchModel->search_course = $semester->str_search;
		$searchModel->search_program = $semester->program_search;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'semester' => $semester
        ]);
    }
	
	public function actionProgramCoor()
    {
        $semester = new SemesterForm;
		$session = Yii::$app->session;
        if(Yii::$app->getRequest()->getQueryParam('SemesterForm')){
            $sem = Yii::$app->getRequest()->getQueryParam('SemesterForm');
            $semester->semester_id = $sem['semester_id'];
            $semester->str_search = $sem['str_search'];
			$session->set('semester', $sem['semester_id']);
        }else if($session->has('semester')){
			$semester->semester_id = $session->get('semester');
		}else{
            $semester->semester_id = Semester::getCurrentSemester()->id;
        }

        $searchModel = new CourseOfferedCoorSearch();
        $searchModel->semester = $semester->semester_id;
        $searchModel->search_course = $semester->str_search;
		$searchModel->search_program = $semester->program_search;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('program-coordinator', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'semester' => $semester
        ]);
    }

    /**
     * Displays a single CourseOffered model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CourseOffered model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CourseOffered();

        if ($model->load(Yii::$app->request->post())) {
			if($model->courses){
				$flag = true;
				foreach($model->courses as $course){
					if($this->offeredNotExist($model->semester_id, $course)){
						if(!$this->addNew($model->semester_id, $course)){
							$flag = false;
							exit;
						}
					}
					
				}
				if($flag){
					Yii::$app->session->addFlash('success', "Courses Offered Added");
				}
				
				return $this->redirect(['index']);
			}

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
	
	protected function offeredNotExist($semester, $course){
		$model = CourseOffered::findOne(['semester_id' => $semester, 'course_id' => $course]);
		
		if ($model) {
            return false;
        }else{
			return true;
		}
		
	}
	
	protected function addNew($semester, $course){
		$new = new CourseOffered();
		$new->course_id = $course;
		$new->semester_id = $semester;
		$new->created_at = new Expression('NOW()');
		$new->created_by = Yii::$app->user->identity->id;
		
		if(!$new->save()){
			$new->flashError();
			//Yii::$app->session->addFlash('error', $course);
			return false;
		}
		return true;
	}
	
	public function actionAssign($id){

		$model = $this->findModel($id);
        
		$lectures = $model->lectures;

		$addLecure = new AddLectureForm;

        //tutorial
        $addTutorial = new AddTutorialForm;

        $modelLecture = new CourseLecture;

        
		
		if(Yii::$app->request->post()){

            if ($model->load(Yii::$app->request->post())) {
				$model->updated_at = new Expression('NOW()');
                $model->save();

            }

			if(Yii::$app->request->post('AddLectureForm')){
				$add = Yii::$app->request->post('AddLectureForm');
				$num = $add['lecture_number'];
				if(is_numeric($num) and $num > 0){
					for($i = 1; $i<= $num; $i++){
						$new = new CourseLecture;
						$new->offered_id = $id;
						$new->created_at = new Expression('NOW()');
						$new->updated_at = new Expression('NOW()');
						if(!$new->save()){
							$new->flashError();
						}
					}
					
				}
                Yii::$app->session->addFlash('success', "Data Saved");
            }


            if(Yii::$app->request->post('AddTutorialForm')){
                $add = Yii::$app->request->post('AddTutorialForm');
                $num = $add['tutorial_number'];

                $lec_id = $add['lecture_json'];
                $lec_array = json_decode($lec_id);
               
                if($lec_array){
                    foreach ($lec_array as $lec) {
                        if(is_numeric($num) and $num > 0){
                            for($i = 1; $i<= $num; $i++){
                            $new = new TutorialLecture;
                            $new->lecture_id = $lec;
                            $new->created_at = new Expression('NOW()');
                            $new->updated_at = new Expression('NOW()');
                                if(!$new->save()){
                                    $new->flashError();
                                }
                            }   
                        }
                    }
                     Yii::$app->session->addFlash('success', "Data Saved");
                }
                else
                {   
                     Yii::$app->session->addFlash('danger', "Please tick checkbox first to add tutorial");
                }
                
            }


            if(Yii::$app->request->post('Lecture')){
                $post_lectures = Yii::$app->request->post('Lecture');
                foreach ($lectures as $lec) {
                    $lec->lec_name = $post_lectures[$lec->id]['lec_name'];
                    $lec->student_num = $post_lectures[$lec->id]['student_num'];

                    if(array_key_exists('lecturers',$post_lectures[$lec->id])){
                        $lecturers = $post_lectures[$lec->id]['lecturers'];
                            if($lecturers)
                            {
                               $this->saveLecturers($lec,$lecturers);
                            }
                    }else{
                        $this->saveLecturers($lec,[]);
                    }
                    
                    $lec->save();


                    foreach ($lec->tutorials as $tutor) {

                        $tutor->tutorial_name = $post_lectures[$lec->id]['tutorial'][$tutor->id]['tutorial_name'];
						$tutor->lec_prefix = $post_lectures[$lec->id]['tutorial'][$tutor->id]['lec_prefix'];
                        $tutor->student_num = $post_lectures[$lec->id]['tutorial'][$tutor->id]['student_num'];

                        if(array_key_exists('tutoriallecturers', $post_lectures[$lec->id]['tutorial'][$tutor->id])){
                            $tutoriallecturers = $post_lectures[$lec->id]['tutorial'][$tutor->id]['tutoriallecturers'];
                            if ($tutoriallecturers) {
                                $this->saveTutorialLecturers($lec,$tutor,$tutoriallecturers);
                            }
                        }else{
                            $this->saveTutorialLecturers($lec,$tutor,[]);
                        }
                        $tutor->save();
                    }
                    
                    
                }
                 
                 Yii::$app->session->addFlash('success', "Data Saved");
            }


        return $this->refresh();

		}

		
		
		return $this->render('assign', [
           'model' => $model, 
		   'addLecure' => $addLecure,
		   'lectures' => $lectures,
           'addTutorial' => $addTutorial,
           'modelLecture' => $modelLecture,
           
        ]);
	}

    //Save lecturers for lecture
    private function saveLecturers($lec,$lecturers){
    if(Yii::$app->request->post('Lecture')){
    $post_lectures = Yii::$app->request->post('Lecture');
        $kira_post = count($lecturers);
        $kira_lama = count($lec->lecturers);
        if($kira_post > $kira_lama){
            $bil = $kira_post - $kira_lama;
            for($i=1;$i<=$bil;$i++){
                $insert = new LecLecturer;
                $insert->lecture_id = $lec->id;
                $insert->save();
            }
        }else if($kira_post < $kira_lama){
            $bil = $kira_lama - $kira_post;
            $deleted = LecLecturer::find()
                ->where(['lecture_id'=>$lec->id])
                ->limit($bil)
                ->all();
                if($deleted){
                    foreach($deleted as $del){
                            $del->delete();
                    }
                }
                     
        }

        if($lecturers){
        $update_tag = LecLecturer::find()
        ->where(['lecture_id'=>$lec->id])
        ->all();
        
        $tag = $post_lectures[$lec->id]['lecturers'];
        if($update_tag){
            $i=0;
            foreach($update_tag as $ut){
                $ut->staff_id = $tag[$i];
                $ut->save();
                $i++;
            }
        }
    }
    }
}

    //Save lecturers for tutorial
    private function saveTutorialLecturers($lec,$tutorial,$tutoriallecturers)
    {
        if(Yii::$app->request->post('Lecture')){
            $post_lectures = Yii::$app->request->post('Lecture');
            $kira_post = count($tutoriallecturers);
                $kira_lama = count($tutorial->tutors);
                if($kira_post > $kira_lama){
                    $bil = $kira_post - $kira_lama;
                    for($i=1;$i<=$bil;$i++){
                        $insert = new TutorialTutor;
                        $insert->tutorial_id = $tutorial->id;
                        $insert->save();
                    }
                }else if($kira_post < $kira_lama){
                $bil = $kira_lama - $kira_post;
                $deleted = TutorialTutor::find()
                ->where(['tutorial_id'=>$tutorial->id])
                ->limit($bil)
                ->all();
                    if($deleted){
                        foreach($deleted as $del){
                                $del->delete();
                        }
                    }
                }

                if($tutoriallecturers){
                $update_tag = TutorialTutor::find()
                ->where(['tutorial_id'=>$tutorial->id])
                ->all();
            
                $tag = $post_lectures[$lec->id]['tutorial'][$tutorial->id]['tutoriallecturers'];
                if($update_tag){
                    $i=0;
                    foreach($update_tag as $ut){
                        $ut->staff_id = $tag[$i];
                        $ut->save();
                        $i++;
                    }
                }
            }
        }
    }

   


    public function actionSession()
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

        $model = new Course();
        
        $model->semester = $semester->semester_id; 


        if(Yii::$app->request->post('Course')){
            $post_session = Yii::$app->request->post('Course');

            $action = Yii::$app->request->post('btn-action');
            if($action == 0){
               $this->saveSession($model,$post_session);
               Yii::$app->session->addFlash('success', "Bulk Session Saved");
                return $this->refresh();
            }
            if($action == 1){
                 $this->runBulkSession($model,$post_session);
                 Yii::$app->session->addFlash('success', "Run Bulk Session Success");    
                  return $this->refresh();
            }
            if($action == 2)
            {
                $this->deleteBulkSession($semester);

            }
            if($action == 3)
            {
                $this->exportExcel($model,$post_session);

            }

        }

        return $this->render('session', [
            'model' => $model,
            'semester' => $semester
        ]);
    }

    public function saveSession($model,$post_session)
    {
        foreach ($model->course as $course) {
                           
            $course->total_students  = $post_session[$course->id]['total_student'];
            $course->max_lec = $post_session[$course->id]['max_lecture'];
            $course->prefix_lec = $post_session[$course->id]['prefix_lecture'];
            $course->max_tut = $post_session[$course->id]['max_tutorial'];
            $course->prefix_tut = $post_session[$course->id]['prefix_tutorial'];
            $course->save(); 
        }                            
    }

    public function runBulkSession($model,$post_session)
    {
     

      $this->saveSession($model,$post_session);

        foreach ($post_session as $key => $offered) {
            $offered_id = $key;
            $offer = $this->findModel($offered_id);

            $transaction = Yii::$app->db->beginTransaction();

            try {
             $total_student  = $offered['total_student'];
            if($total_student > 0){
                $max_lecture = $offered['max_lecture'];
                
                $prefix = $offered['prefix_lecture'];

                if($max_lecture > $total_student){
                    Yii::$app->session->addFlash('error', 'Maximum lecture is more than total student for '.$offer->course->course_name);
                    $transaction->rollBack();
                    continue;
                }

                if($max_lecture > 0){
                    $numLec = (int)floor($total_student/$max_lecture);
                    $bal = $total_student % $max_lecture;

                    $max_tutorial = $offered['max_tutorial'];
                    $prefix_tutorial = $offered['prefix_tutorial'];

                    for ($i=1; $i <=$numLec ; $i++) {       
                        if(!$this->insertLecture($offered_id,$max_lecture,$prefix,$i,$max_tutorial,$prefix_tutorial)){
                            Yii::$app->session->addFlash('error', 'Problem creating lecture for '.$offer->course->course_name);
                            $transaction->rollBack();
                            continue 2;
                        }            
                    }       
                    if($bal > 0){
                        $j = $i;
                        if(!$this->insertLecture($offered_id,$bal,$prefix,$j,$max_tutorial,$prefix_tutorial)){
                            Yii::$app->session->addFlash('error', 'Problem creating lecture (balance) for '.$offer->course->course_name);
                            $transaction->rollBack();
                            continue;
                        }
                        
                    }

                 
                    
                }                         
            }   
            $offer->total_students  = '0';
            $offer->max_lec = '0';
            $offer->prefix_lec = 'L';
            $offer->max_tut = '0';
            $offer->prefix_tut = 'T';
            if(!$offer->save())
            {
                Yii::$app->session->addFlash('error', 'Problem saving setting for '.$offer->course->course_name);
                            $transaction->rollBack();
                            continue;
            }
             

            $transaction->commit();
            
            }
            catch (Exception $e) 
            {
                $transaction->rollBack();
                Yii::$app->session->addFlash('error', $e->getMessage());
            }
            
        }    
                      
    }

        

    public function deleteBulkSession($semester)
    {
        $tutorial_tutor = TutorialTutor::find()
        ->select('tld_tutorial_tutor.id')
        ->joinWith(['tutorialLec.lecture.courseOffered'])
        ->where(['semester_id' => $semester])
        ->all();
        if($tutorial_tutor){
            TutorialTutor::deleteAll(['in', 'id', ArrayHelper::map($tutorial_tutor, 'id', 'id')]);
        }

        $tutorials = TutorialLecture::find()
        ->select('tld_tutorial_lec.id')
        ->joinWith(['lecture.courseOffered'])
        ->where(['semester_id' => $semester])
        ->all();
        if($tutorials){
            TutorialLecture::deleteAll(['id' =>$tutorials]);
        }

        $lecturers = LecLecturer::find()
        ->select('tld_lec_lecturer.id')
        ->joinWith(['courseLecture.courseOffered'])
        ->where(['semester_id' => $semester])
        ->all();
        if($lecturers){
            LecLecturer::deleteAll(['in', 'id', ArrayHelper::map($lecturers, 'id', 'id') ]);
        }

        $lectures = CourseLecture::find()
        ->select('tld_course_lec.id')
        ->joinWith(['courseOffered'])
        ->where(['semester_id' => $semester])
        ->all();
        if($lectures){
            CourseLecture::deleteAll(['id' =>$lectures]);
        }

        $coordinator = CourseOffered::find()
        ->where(['semester_id' => $semester])
        ->all();
        if($coordinator){
            foreach ($coordinator as $coor) {
                $coor->coordinator = null;
                $coor->save();
            }
        }
         Yii::$app->session->addFlash('success', "All Bulk Session Have Been Delete");
                
    }

    public function exportExcel($model,$post_session){
        $this->saveSession($model,$post_session);
                $pdf = new BulkSessionExcel;
                $pdf->model = $model;
                $pdf->generateExcel();
    }     

    private function insertLecture($offered_id,$max_lecture,$prefix,$i,$max_tutorial,$prefix_tutorial)
    {
        $insert = new CourseLecture;
        $insert->offered_id = $offered_id ;
        $insert->student_num = $max_lecture;
        $insert->lec_name = $prefix.$i;
        $insert->created_at = new Expression('NOW()');
        $insert->updated_at = new Expression('NOW()');
        if(!$insert->save()){
            return false;
        }
        

      

        if($max_tutorial > 0){
            if($max_tutorial > $max_lecture)
            {
                return false;
            }

            $numTutorial = (int)floor($max_lecture/$max_tutorial);
            $bal = $max_lecture % $max_tutorial;

            for ($i=1; $i <=$numTutorial ; $i++) { 
                    
                if(!$this->insertTutorial($insert,$max_tutorial,$prefix_tutorial,$i))
                {
                    return false;
                }
               
            }
                    
            if($bal > 0){
                $j = $i;
                if(!$this->insertTutorial($insert,$bal,$prefix_tutorial,$j)){
                    return false;
                }
            }
        }
        return true;
    }

    private function insertTutorial($insert,$max_tutorial,$prefix_tutorial,$i)
    {
        $insertTutorial = new TutorialLecture;
        $insertTutorial->lecture_id = $insert->id;
        $insertTutorial->student_num = $max_tutorial;
        $insertTutorial->tutorial_name = $prefix_tutorial.$i;
        $insertTutorial->created_at = new Expression('NOW()');
        $insertTutorial->updated_at = new Expression('NOW()');

        if(!$insertTutorial->save()){
            return false;
        }
        else{
            return true;
        }
        
    }

    /**
     * Updates an existing CourseOffered model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CourseOffered model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $lectures = $model->lectures;
        if($lectures)
        {
            $ids = ArrayHelper::map($lectures,'id','id');
            LecLecturer::deleteAll(['lecture_id' =>$ids]);

                foreach ($lectures as $lec) {
                    $tutorials = $lec->tutorials;
                    if($tutorials){
                        $idt = ArrayHelper::map($tutorials,'id','id');
                         TutorialTutor::deleteAll(['tutorial_id' => $idt]);
                    }
                }
                
            TutorialLecture::deleteAll(['lecture_id' => $ids]);
        }
        CourseLecture::deleteAll(['offered_id' => $id]);

        if($model->delete()){
            
            Yii::$app->session->addFlash('success', "Data Updated");
        }

        return $this->redirect(['index']);
    }

     public function actionDeleteLecture($id)
    {
        $model = $this->findLecture($id);
        $tutorial = $model->tutorials;
        if($tutorial)
        {
            $ids = ArrayHelper::map($tutorial,'id','id');
            TutorialTutor::deleteAll(['tutorial_id' =>$ids]);
        }
        

        TutorialLecture::deleteAll(['lecture_id' => $id]);
        LecLecturer::deleteAll(['lecture_id' => $id]);
        


        if($model->delete()){
            
            Yii::$app->session->addFlash('success', "Data Updated");
        }

        return $this->redirect(['assign','id'=> $model->offered_id]);
    }

    public function actionDeleteTutorial($id,$offered)
    {
        
        $model = $this->findTutorialModel($id);
        
        TutorialTutor::deleteAll(['tutorial_id' => $id]);

        if($model->delete()){
            Yii::$app->session->addFlash('success', "Data Updated");
        }

        return $this->redirect(['assign','id'=> $offered]);
    }


    /**
     * Finds the CourseOffered model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CourseOffered the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CourseOffered::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findLecture($id)
    {
        if (($model = CourseLecture::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findTutorialModel($id)
    {
        if (($model = TutorialLecture::findOne($id)) !== null ) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
