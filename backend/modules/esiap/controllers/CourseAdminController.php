<?php

namespace backend\modules\esiap\controllers;

use Yii;
use backend\modules\esiap\models\Course;
use backend\modules\esiap\models\CourseProfile;
use backend\modules\esiap\models\CourseClo;
use backend\modules\esiap\models\CourseCloAssessment;
use backend\modules\esiap\models\CourseSearch;
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
        $searchModel = new CourseSearch();
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
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
	
	public function actionCourseReference($course){
		$model = $this->findDefaultVersion($course);
		$ref = $model->references;
		
		if(Yii::$app->request->post()){
			if(Yii::$app->request->validateCsrfToken()){
				$post_ref = Yii::$app->request->post('ref');
				foreach($post_ref as $key => $pref){
					$ref = CourseReference::findOne($key);
					if($ref){
						$ref->ref_author = $pref['author'];
						$ref->ref_year = $pref['year'];
						$ref->ref_title = $pref['title'];
						$ref->ref_others = $pref['others'];
						$ref->is_main = $pref['main'];
						$ref->is_classic = $pref['isclassic'];
						$ref->save();
					}
				}
				

			}
			return $this->redirect(['course-reference', 'course' => $course]);
		}
		
		return $this->render('reference', [
            'model' => $model,
			'ref' => $ref
        ]);
	}
	
	public function actionCourseReferenceAdd($course, $version){
		$ref = new CourseReference;
		$ref->crs_version_id = $version;
		$ref->ref_year = date('Y');
		if($ref->save()){
			//
		}
		//$version = CourseVersion::findOne($version);
		//$course = $version->course_id;
		return $this->redirect(['course-reference','course'=>$course]);
	}
	
	public function actionCourseReferenceDelete($course, $version){
		$ref = CourseReference::findOne(['crs_version_id' => $version]);
		$ref->delete();
		//$version = CourseVersion::findOne($version);
		//$course = $version->course_id;
		return $this->redirect(['course-reference','course'=>$course]);
	}
	
	public function actionCourseSyllabus($course){
		$model = $this->findDefaultVersion($course);
		$syllabus = $model->syllabus;
		$clos = $model->clos;
		if(!$syllabus){
			CourseSyllabus::createWeeks($model->id);
			return $this->redirect(['course-syllabus', 'course' => $course]);
		}
		
		if(Yii::$app->request->post()){
			/* echo '<pre>';
			print_r(Yii::$app->request->post());
			//echo Yii::$app->request->post('input-week-15');
			die(); */ 
			if(Yii::$app->request->validateCsrfToken()){
				for($i=1;$i<=14;$i++){
					if(Yii::$app->request->post('input-week-'.$i)){
						$week = CourseSyllabus::findOne(['crs_version_id' => $model->id, 'week_num' => $i]);
						$week->topics = Yii::$app->request->post('input-week-'.$i);
						
						if(Yii::$app->request->post($i . '-clo')){
							$clo = json_encode(Yii::$app->request->post($i . '-clo'));
							$week->clo = $clo;
						}
						
						
						$week->save();
					}
					
				}
			}
			return $this->redirect(['course-syllabus', 'course' => $course]);
			
			
			
		}
		
		return $this->render('syllabus', [
            'model' => $model,
			'syllabus' => $syllabus,
			'clos' => $clos
        ]);
	}
	
	public function actionCourseCloDelete($version, $clo){
		$clo = CourseClo::findOne(['id' => $clo, 'crs_version_id' => $version]);
		$clo->delete();
		$version = CourseVersion::findOne($version);
		$course = $version->course_id;
		return $this->redirect(['course-clo','course'=>$course]);
	}
	public function actionCourseCloAdd($version, $clo){
		$clo = new CourseClo;
		$clo->crs_version_id = $version;
		if($clo->save()){
			//
		}
		$version = CourseVersion::findOne($version);
		$course = $version->course_id;
		return $this->redirect(['course-clo','course'=>$course]);
	}
	
	public function actionCourseClo($course)
    {
		
        $model = $this->findDefaultVersion($course);
		$clos = $model->clos;
        
        if (Yii::$app->request->post()) {
			if(Yii::$app->request->validateCsrfToken()){
				
                $post_clo = Yii::$app->request->post('CourseClo');
				foreach($post_clo as $key => $pclo){
					$clo = CourseClo::findOne($key);
					if($clo){
						$clo->clo_text = $pclo['clo_text'];
						$clo->clo_text_bi = $pclo['clo_text_bi'];
						$clo->save();
					}
				}
            }
			return $this->redirect(['course-clo','course'=>$course]);
		}
	
		return $this->render('clo', [
				'model' => $model,
				'clos' => $clos
			]);
	
	
	
	}
	
	public function actionCloPlo($course){
		$model = $this->findDefaultVersion($course);
		$clos = $model->clos;
		if (Yii::$app->request->post() ) {
			if(Yii::$app->request->validateCsrfToken()){
                $clos = Yii::$app->request->post('plo');
				if($clos){
					foreach($clos as $key => $plos){
						$row = CourseClo::findOne($key);
						if($row){
							foreach($plos as $p=>$plo){
								$row->{$p} = $plo;
							}
							$row->save();
						}
					}
				}
            }
			return $this->redirect(['clo-plo', 'course' => $course]);
			
		}
	
		return $this->render('clo_plo', [
				'model' => $model,
				'clos' => $clos
			]);
	}
	
	public function actionCloTaxonomy($course){
		$model = $this->findDefaultVersion($course);
		$clos = $model->clos;
		if (Yii::$app->request->post()) {
			if(Yii::$app->request->validateCsrfToken()){
                $clos = Yii::$app->request->post('taxo');
				if($clos){
					foreach($clos as $key => $plos){
						$row = CourseClo::findOne($key);
						if($row){
							foreach($plos as $p=>$plo){
								$row->{$p} = $plo;
							}
							$row->save();
						}
					}
				}
            }
			return $this->redirect(['clo-taxonomy', 'course' => $course]);
			
		}
	
		return $this->render('clo_taxonomy', [
				'model' => $model,
				'clos' => $clos
			]);
	}
	
	public function actionCloDelivery($course){
		$model = $this->findDefaultVersion($course);
		$clos = $model->clos;
		
		if (Yii::$app->request->post()) {
			if(Yii::$app->request->validateCsrfToken()){
				
				
                $clos = Yii::$app->request->post('method');
				if($clos){
					foreach($clos as $key => $clo){
						if($clo){
							foreach($clo as $k=>$d){
								$clodv = CourseCloDelivery::findOne(['clo_id' => $key, 'delivery_id' => $k]);
								if($d == 1){
									if(!$clodv){
										$add = new CourseCloDelivery;
										$add->clo_id = $key;
										$add->delivery_id = $k;
										$add->save();
									}
								}else{
									if($clodv){
										$clodv->delete();
									}
								}
								
							
							}
						}
					}
				}
            }
			return $this->redirect(['clo-delivery', 'course' => $course]);
			
		}
	
		return $this->render('clo_delivery', [
				'model' => $model,
				'clos' => $clos
			]);
	}
	
	public function actionCloSoftskill($course){
		$model = $this->findDefaultVersion($course);
		$clos = $model->clos;
		if (Yii::$app->request->post()) {
			if(Yii::$app->request->validateCsrfToken()){
                $clos = Yii::$app->request->post('ss');
				if($clos){
					foreach($clos as $key => $plos){
						$row = CourseClo::findOne($key);
						if($row){
							foreach($plos as $p=>$plo){
								$row->{$p} = $plo;
							}
							$row->save();
						}
					}
				}
            }
			return $this->redirect(['clo-softskill', 'course' => $course]);
			
		}
	
		return $this->render('clo_softskill', [
				'model' => $model,
				'clos' => $clos
			]);
	}
	
	public function actionCloAssessment($course){
		$model = $this->findDefaultVersion($course);
		$items = $model->assessments;
		if($model->putOneCloAssessment()){
			return $this->redirect(['course-assessment', 'course' => $course]);
		}
		
		$clos = $model->clos;
		if ($model->load(Yii::$app->request->post())) {
			if(Yii::$app->request->validateCsrfToken()){
                $cloAs = Yii::$app->request->post('CourseCloAssessment');
				if($cloAs){
					foreach($cloAs as $ca){
						$row = CourseCloAssessment::findOne($ca['id']);
						$row->assess_id = $ca['assess_id'];
						$row->percentage = $ca['percentage'];
						$row->save();
					}
				}
            }
			return $this->redirect(['clo-assessment', 'course' => $course]);
			
		}
	
		return $this->render('clo_assessment', [
				'model' => $model,
				'clos' => $clos,
				'assess' => $items
			]);
	}
	
	public function actionCourseSlt($course){
		$model = $this->findDefaultVersion($course);
		$slt = $model->slt;
		$syll = $model->syllabus;
		if ($model->load(Yii::$app->request->post())) {
			
			if(Yii::$app->request->validateCsrfToken()){
				$post_slt = Yii::$app->request->post('slt');
				foreach($post_slt as $key => $val){
				$slt->{$key} = $val;
				}
				$slt->save();
				
				$post_assess = Yii::$app->request->post('assess');
				foreach($post_assess as $key => $val){
					$as = CourseAssessment::findOne($key);
					$as->scenario = 'update_slt';
					if($as){
						$as->assess_hour = $val;
						if(!$as->save()){
							$as->flashError();
						}
					}
				}
				
				$post_assess = Yii::$app->request->post('syll');
				foreach($post_assess as $key => $val){
					$syl = CourseSyllabus::findOne($key);
					$syl->scenario = 'slt';
					if($syl){
						
						foreach($val as $i => $v){
							$syl->{$i} = $v;
						}
						if(!$syl->save()){
							$syl->flashError();
						}
					}
				}
            }
			//die();
			return $this->redirect(['course-slt', 'course' => $course]);
			
		}

		return $this->render('slt', [
				'model' => $model,
				'slt' => $slt,
				'syll' => $syll
			]);
	}
	
	public function actionCourseAssessment($course)
    {
		
        $model = $this->findDefaultVersion($course);
		
		$items = $model->assessments;
		
		
		
		
        
        if ($model->load(Yii::$app->request->post())) {
			
            $oldItemIDs = ArrayHelper::map($items, 'id', 'id');
            
            $items = Model::createMultiple(CourseAssessment::classname());
            
            Model::loadMultiple($items, Yii::$app->request->post());
            
            $deletedItemIDs = array_diff($oldItemIDs, array_filter(ArrayHelper::map($items, 'id', 'id')));
            
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($items) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        
                        if (! empty($deletedItemIDs)) {
                            CourseAssessment::deleteAll(['id' => $deletedItemIDs]);
                        }
                        
                        foreach ($items as $indexItem => $item) {
                            
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $item->crs_version_id = $model->id;
							$item->created_at = new Expression('NOW()');
							$item->created_by = Yii::$app->user->identity->id;

                            if (!($flag = $item->save(false))) {
                                break;
                            }
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
                            Yii::$app->session->addFlash('success', "Data Updated");
                             return $this->redirect(['course-assessment', 'course' => $course]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }

		}
		
		
	
	
		return $this->render('assessment', [
				'model' => $model,
				'items' => (empty($items)) ? [new CourseAssessment] : $items,
			]);
	
	
	
	}
	
	public function actionAddAssessmentClo($course, $clo){
		$clo_as = new CourseCloAssessment;
		$clo_as->clo_id = $clo;
		$clo_as->save();
		$this->redirect(['clo-assessment', 'course' => $course]);
	}
	
	public function actionDeleteAssessmentClo($course, $id){
		$clo_as = CourseCloAssessment::findOne($id);
		$clo_as->delete();
		$this->redirect(['clo-assessment', 'course' => $course]);
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
