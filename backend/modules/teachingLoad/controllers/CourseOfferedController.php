<?php

namespace backend\modules\teachingLoad\controllers;

use Yii;
use backend\modules\teachingLoad\models\CourseOffered;
use backend\modules\teachingLoad\models\CourseOfferedSearch;
use backend\modules\teachingLoad\models\AddLectureForm;
use backend\modules\teachingLoad\models\AddTutorialForm;
use backend\modules\teachingLoad\models\TutorialLecture;
use backend\modules\teachingLoad\models\CourseLecture;
use backend\modules\teachingLoad\models\LecLecturer;
use backend\modules\teachingLoad\models\TutorialTutor;
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
        $semester->action = ['/teaching-load/course-offered/index'];

        if(Yii::$app->getRequest()->getQueryParam('SemesterForm')){
            $sem = Yii::$app->getRequest()->getQueryParam('SemesterForm');
            $semester->semester_id = $sem['semester_id'];
            $semester->str_search = $sem['str_search'];
        }else{
            $semester->semester_id = Semester::getCurrentSemester()->id;
        }

        $searchModel = new CourseOfferedSearch();
        $searchModel->semester = $semester->semester_id;
        $searchModel->search_course = $semester->str_search;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
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

            //Save Coordinator
            
            if(Yii::$app->request->post('coordinator')){
                

                $post_coordinator = Yii::$app->request->post('coordinator');
               
                
                $model->coordinator = $post_coordinator;
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
                    


                    foreach ($lec->tutorials as $tutor) {

                        $tutor->tutorial_name = $post_lectures[$lec->id]['tutorial'][$tutor->id]['tutorial_name'];
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
                    
                    if($lec->save()){
                        
                    }
                }
            }

          

            

           

                Yii::$app->session->addFlash('success', "Data Saved");
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
    private function saveTutorialLecturers($lec,$tutor,$tutoriallecturers)
    {
        if(Yii::$app->request->post('Lecture')){
            $post_lectures = Yii::$app->request->post('Lecture');
            $kira_post = count($tutoriallecturers);
                $kira_lama = count($tutor->lecturers);
                if($kira_post > $kira_lama){
                    $bil = $kira_post - $kira_lama;
                    for($i=1;$i<=$bil;$i++){
                        $insert = new TutorialTutor;
                        $insert->tutorial_id = $tutor->id;
                        $insert->save();
                    }
                }else if($kira_post < $kira_lama){
                $bil = $kira_lama - $kira_post;
                $deleted = TutorialTutor::find()
                ->where(['tutorial_id'=>$tutor->id])
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
                ->where(['tutorial_id'=>$tutor->id])
                ->all();
            
                $tag = $post_lectures[$lec->id]['tutorial'][$tutor->id]['tutoriallecturers'];
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

        return $this->render('session', [
            'model' => $model,
        ]);
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
        $this->findModel($id)->delete();

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
