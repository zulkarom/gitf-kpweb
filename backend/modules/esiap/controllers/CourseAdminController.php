<?php

namespace backend\modules\esiap\controllers;

use Yii;
use backend\modules\esiap\models\CourseAdminSearch;
use backend\modules\esiap\models\Course;
use backend\modules\esiap\models\CourseProfile;
use backend\modules\esiap\models\CourseClo;
use backend\modules\esiap\models\CourseCloAssessment;

use backend\modules\esiap\models\CourseVersion;
use backend\modules\esiap\models\CourseSyllabus;
use backend\modules\esiap\models\CourseSltAs;
use backend\modules\esiap\models\CourseAssessment;
use backend\modules\esiap\models\CourseVersionSearch;
use backend\modules\esiap\models\CourseReference;
use backend\modules\esiap\models\CourseCloDelivery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use common\models\Model;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\modules\esiap\models\CoursePic;


/**
 * CourseController implements the CRUD actions for Course model.
 */
class CourseAdminController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Course models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CourseAdminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	 /**
     * Lists all CourseVersion models.
     * @return mixed
     */
    public function actionCourseVersion($course)
    {
        $searchModel = new CourseVersionSearch();
        $dataProvider = $searchModel->search($course, Yii::$app->request->queryParams);
		
		$courseModel = $this->findModel($course);

        return $this->render('../course-version/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'course' => $courseModel
        ]);
    }
	
	/**
     * Creates a new CourseVersion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCourseVersionCreate($course)
    {
        $model = new CourseVersion();

        if ($model->load(Yii::$app->request->post())) {
			
			$model->course_id = $course;
			$model->created_by = Yii::$app->user->identity->id;
			$model->created_at = new Expression('NOW()');
			
			if($model->save()){
				return $this->redirect(['course-version', 'course' => $course]);
			}
            
        }

        return $this->render('../course-version/create', [
            'model' => $model,
        ]);
    }
	
	public function actionCourseVersionUpdate($id)
    {
        $model = CourseVersion::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
			
			if($model->is_active == 1){
				CourseVersion::updateAll(['is_active' => 0], ['course_id' => $model->course_id]);
			}
			
			if($model->save()){
				Yii::$app->session->addFlash('success', "Data Updated");
				return $this->redirect(['course-version', 'course' => $model->course->id]);
			}
            
        }

        return $this->render('../course-version/update', [
            'model' => $model,
        ]);
    }


    /**
     * Creates a new Course model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Course();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Course model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($course)
    {
        $model = $this->findModel($course);
		$model->scenario = 'update';
        $pics = $model->coursePics;
       
        if ($model->load(Yii::$app->request->post())) {
            
            $model->updated_at = new Expression('NOW()');    
            
            $oldIDs = ArrayHelper::map($pics, 'id', 'id');
            
            $pics = Model::createMultiple(CoursePic::classname(), $pics);
            
            Model::loadMultiple($pics, Yii::$app->request->post());
            
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($pics, 'id', 'id')));
            
            foreach ($pics as $i => $pic) {
                $pic->pic_order = $i;
            }
            
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($pics) && $valid;

			
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            CoursePic::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($pics as $i => $pic) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $pic->course_id = $model->id;
							$pic->updated_at = new Expression('NOW()');

                            if (!($flag = $pic->save(false))) {
                                break;
                            }
                        }

                    }else{
						$model->flashError();
					}

                    if ($flag) {
                        $transaction->commit();
                            Yii::$app->session->addFlash('success', "Dates updated");
                            return $this->redirect(['update','course' => $model->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }

        
        
       

    }
    
		 return $this->render('update', [
				'model' => $model,
				'pics' => (empty($pics)) ? [new CoursePic] : $pics
			]);
    }
	
	public function actionProfile($course)
    {
        $model = $this->findProfile($course);
		$model->scenario = 'update';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->session->addFlash('success', "Data Updated");
            return $this->redirect(['profile', 'course' => $course]);
        }

        return $this->render('profile', [
            'model' => $model,
        ]);
    }
	
	
	
    /**
     * Deletes an existing Course model.
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
     * Finds the Course model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Course the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Course::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	
	protected function findProfile($id)
    {
		$default = $this->findDefaultVersion($id);
		$model = CourseProfile::findOne(['crs_version_id' => $default->id]);
		if($model){
			return $model;
		}else{
			$profile = new CourseProfile;
			$profile->scenario = 'fresh';
			$profile->crs_version_id = $default->id;
			if($profile->save()){
				return $profile;
			}else{
				throw new NotFoundHttpException('There is problem creating course profile!');
			}
		}
    }
	
	protected function findDefaultVersion($id){
		$default = CourseVersion::findOne(['course_id' => $id, 'is_active' => 1]);
		if($default){
			return $default;
		}else{
			throw new NotFoundHttpException('Please create default active version for this course!');
		}
	}
	
	protected function findCourseClo($id)
    {
		$default = $this->findDefaultVersion($id);
		$model = CourseProfile::findOne(['crs_version_id' => $default->id]);
		if($model){
			return $model;
		}else{
			$model = new CourseClo;
			$model->scenario = 'fresh';
			$model->crs_version_id = $default->id;
			if($model->save()){
				return $model;
			}else{
				throw new NotFoundHttpException('There is problem creating this sub function course!');
			}
		}
    }
}
