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
use backend\modules\esiap\models\CourseVersionClone;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use common\models\Model;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\modules\esiap\models\CoursePic;
use backend\modules\esiap\models\CourseAccess;
use yii\helpers\Json;

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
		$model->scenario = 'create';
		$course_model = $this->findModel($course);

        if ($model->load(Yii::$app->request->post())) {
			
			$transaction = Yii::$app->db->beginTransaction();
			try {
				
				$model->course_id = $course;
				$model->created_by = Yii::$app->user->identity->id;
				$model->created_at = new Expression('NOW()');
				if($model->is_developed == 1){
					CourseVersion::updateAll(['is_developed' => 0], ['course_id' => $course]);
				}
					
				if($model->save()){
					if($model->duplicate == 1){
						if($model->dup_version > 0){
							$clone = new CourseVersionClone;
							$clone->ori_version = $model->dup_version;
							$clone->copy_version = $model->id;
							if($flag = $clone->cloneVersion()){
								Yii::$app->session->addFlash('success', "Version creation with duplication is successful");
							}
						}else{
							Yii::$app->session->addFlash('error', "No existing version selected!");
						}
						
					}else{
						Yii::$app->session->addFlash('success', "Empty course version creation is successful");
					}
					
				}
				
				

				if ($flag) {
					$transaction->commit();
					return $this->redirect(['course-version', 'course' => $course]);
				} else {
					$transaction->rollBack();
				}
			} catch (Exception $e) {
				$transaction->rollBack();
				
			}
			
        }

        return $this->render('../course-version/create', [
            'model' => $model,
			'course' => $course_model
        ]);
    }
	
	public function actionListVersionByCourse($course){
		
		$version = CourseVersion::find()->select('id, version_name')->where(['course_id' => $course])->orderBy('created_at DESC')->all();

		
		if($version){
			return Json::encode($version);
		}
		
	}
	
	public function actionVerifyVersion($id){
		 $model = CourseVersion::findOne($id);
		 $model->scenario = 'verify';
		 $model->status = 20;
		 $model->verified_by = Yii::$app->user->identity->id;
		 $model->verified_at = new Expression('NOW()');
		 if($model->save()){
			 Yii::$app->session->addFlash('success', "Successfully Verified");
			 return $this->redirect(['update', 'course' => $model->course_id]);
		 }
		 
	}
	
	public function actionVersionBackDraft($id){
		 $model = CourseVersion::findOne($id);
		 $model->scenario = 'status';
		 $model->status = 0;
		 if($model->save()){
			 Yii::$app->session->addFlash('success', "Data Updated");
			 return $this->redirect(['update', 'course' => $model->course_id]);
		 }
		 
	}
	
	public function actionCourseVersionUpdate($id)
    {
        $model = CourseVersion::findOne($id);
		$model->scenario = 'update';

        if ($model->load(Yii::$app->request->post())) {
			
			$model->updated_at = new Expression('NOW()');
			
			if($model->is_developed == 1){
				CourseVersion::updateAll(['is_developed' => 0], ['course_id' => $model->course_id]);
			}
			
			if($model->is_published == 1){
				if($model->status == 20){
					if($model->is_developed ==1){
						Yii::$app->session->addFlash('error', "You can not publish and develop at the same time");
						return $this->redirect(['course-version-update', 'id' => $id]);
					}
					CourseVersion::updateAll(['is_published' => 0], ['course_id' => $model->course_id]);
				}else{
					Yii::$app->session->addFlash('error', "The status must be verified before publishing");
					return $this->redirect(['course-version-update', 'id' => $id]);
				}
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
		
		$accesses = $model->courseAccesses;
       
        if ($model->load(Yii::$app->request->post())) {
            
            $model->updated_at = new Expression('NOW()');    
            
            $oldIDs = ArrayHelper::map($pics, 'id', 'id');
            $pics = Model::createMultiple(CoursePic::classname(), $pics);
            Model::loadMultiple($pics, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($pics, 'id', 'id')));
            foreach ($pics as $i => $pic) {
                $pic->pic_order = $i;
            }
			
			$oldAcIDs = ArrayHelper::map($accesses, 'id', 'id');
            $accesses = Model::createMultiple(CourseAccess::classname(), $accesses);
            Model::loadMultiple($accesses, Yii::$app->request->post());
            $deletedAcIDs = array_diff($oldAcIDs, array_filter(ArrayHelper::map($accesses, 'id', 'id')));
            foreach ($accesses as $i => $access) {
                $access->acc_order = $i;
            }
            
            $valid = $model->validate();
            $valid = Model::validateMultiple($pics) && $valid;
			$valid = Model::validateMultiple($accesses) && $valid;

			
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            CoursePic::deleteAll(['id' => $deletedIDs]);
                        }
						if (! empty($deletedAcIDs)) {
                            CourseAccess::deleteAll(['id' => $deletedAcIDs]);
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
						
						foreach ($accesses as $i => $access) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $access->course_id = $model->id;
							$access->updated_at = new Expression('NOW()');

                            if (!($flag = $access->save(false))) {
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
				'pics' => (empty($pics)) ? [new CoursePic] : $pics,
				'accesses' => (empty($accesses)) ? [new CourseAccess] : $accesses
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
		$default = CourseVersion::findOne(['course_id' => $id, 'is_developed' => 1]);
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
