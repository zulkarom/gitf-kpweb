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
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Expression;

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
        $searchModel = new CourseOfferedSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
                    $lecturers = $post_lectures[$lec->id]['lecturers'];
                    if($lecturers)
                    {
                       $this->saveLecturers($lec,$lecturers);
                    }


                    foreach ($lec->tutorials as $tutor) {

                        $tutor->tutorial_name = $post_lectures[$lec->id]['tutorial'][$tutor->id]['tutorial_name'];
                        $tutor->student_num = $post_lectures[$lec->id]['tutorial'][$tutor->id]['student_num'];
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
           'modelLecture' => $modelLecture
        ]);
	}

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

        TutorialLecture::deleteAll(['lecture_id' => $id]);

        if($model->delete()){
            
            Yii::$app->session->addFlash('success', "Data Updated");
        }

        return $this->redirect(['assign','id'=> $model->offered_id]);
    }

    public function actionDeleteTutorial($id,$offered)
    {
        
        $model = $this->findTutorialModel($id);
        

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
        if (($model = TutorialLecture::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



}
