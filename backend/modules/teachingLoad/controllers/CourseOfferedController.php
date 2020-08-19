<?php

namespace backend\modules\teachingLoad\controllers;

use Yii;
use backend\modules\teachingLoad\models\CourseOffered;
use backend\modules\teachingLoad\models\CourseOfferedSearch;
use backend\modules\teachingLoad\models\AddLectureForm;
use backend\modules\teachingLoad\models\CourseLecture;
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
				foreach($model->courses as $course){
					if($this->offeredNotExist($model->semester_id, $course)){
						$this->addNew($model->semester_id, $course);
					}
					
				}
				Yii::$app->session->addFlash('success', "Courses Offered Added");
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
			Yii::$app->session->addFlash('error', $course);
			return false;
		}
		return true;
	}
	
	public function actionAssign($id){
		
		$model = $this->findModel($id);
		$lectures = CourseLecture::find(['offered_id' => $id])->all();
		$addLecure = new AddLectureForm;
		
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
					return $this->refresh();
				}
			}
		}
		
		
		return $this->render('assign', [
           'model' => $model, 
		   'addLecure' => $addLecure,
		   'lectures' => $lectures
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
}
