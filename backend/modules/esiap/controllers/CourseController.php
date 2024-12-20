<?php

namespace backend\modules\esiap\controllers;

use Yii;
use backend\models\Semester;
use backend\modules\esiap\models\Course;
use backend\modules\esiap\models\CourseProfile;
use backend\modules\esiap\models\CourseClo;
use backend\modules\esiap\models\CourseCloAssessment;
use backend\modules\esiap\models\CourseVersion;
use backend\modules\esiap\models\CourseSyllabus;
use backend\modules\esiap\models\CourseAssessment;
use backend\modules\esiap\models\CourseReference;
use backend\modules\esiap\models\CourseCloDelivery;
use backend\modules\esiap\models\CourseTransferable;
use backend\modules\esiap\models\CourseStaff;
use backend\modules\esiap\models\Fk1;
use backend\modules\esiap\models\Fk2;
use backend\modules\esiap\models\Fk3;
use backend\modules\esiap\models\Tbl4;
use backend\modules\esiap\models\Tbl4Pdf;
use backend\modules\esiap\models\Tbl4Excel2;
use backend\modules\esiap\models\Tbl4Excel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\db\Exception;
use yii\db\Expression;
use common\models\Model;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use common\models\UploadFile;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use backend\modules\esiap\models\CourseVersionClone;
use backend\modules\teachingLoad\models\CourseOffered;
use backend\modules\esiap\models\Fk3Word;
use backend\models\SemesterForm;
use backend\modules\courseFiles\models\Checklist;
use backend\modules\esiap\models\Fk1Word;

/**
 * CourseController implements the CRUD actions for Course model.
 */
class CourseController extends Controller
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
		
        /* $searchModel = new CourseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]); */
    }
    
    public function actionResources($id)
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
        
        $model = new Checklist();
        $offer = $this->findOfferBySemester($id, $semester->semester_id);
        
         
         return $this->render('resources', [
            'semester' => $semester,
             'model' => $model,
             'offer' => $offer,
         ]); 
    }
    
    public function actionManageVersion($course)
    {
        $courseModel = $this->findModel($course);
        
        $dataProvider = new ActiveDataProvider([
            'query' => CourseVersion::find()->where(['course_id' => $course])->orderBy('is_developed DESC, is_published DESC, status ASC, created_at DESC'),
        ]);
         
         return $this->render('manage-version', [
         'dataProvider' => $dataProvider,
             'course' => $courseModel
         ]); 
    }
    
    public function actionCreateVersion($course){
        $course = $this->findModel($course);
        $model = new CourseVersion();
        $model->scenario = 'create_coor';
        
        if ($model->load(Yii::$app->request->post())) {
            //$model->version_type_id = 2;
			//$model->is_developed = 1;
            
            
            $transaction = Yii::$app->db->beginTransaction();
            try {
                
                $model->course_id = $course->id;
                $model->created_by = Yii::$app->user->identity->id;
                $model->created_at = new Expression('NOW()');
                if($model->is_developed == 1){
                    CourseVersion::updateAll(['is_developed' => 0], ['course_id' => $course->id]);
                }
                $flag = true;
                if($model->save()){
                    $clone = new CourseVersionClone;
                    $clone->ori_version = $model->duplicated_from;
                    $clone->copy_version = $model->id;
                    if($flag = $clone->cloneVersion()){
                        Yii::$app->session->addFlash('success', "Version creation with duplication is successful");
                    }else{
                        Yii::$app->session->addFlash('error', "Duplication failed!");
                    }
                    
                }
                
                
                
                if ($flag) {
                    $transaction->commit();
                    return $this->redirect(['manage-version', 'course' => $course->id, 'version' => $model->id]);
                } else {
                    $transaction->rollBack();
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                
            }
            
        }
        
        
        return $this->render('course-new-version', [
            'model' => $model,
            'course' => $course,
        ]);
        
    }
    
    public function actionUpdateVersion($course, $version){
        $course = $this->findModel($course);
        $model = $this->findVersion($version);
        $model->scenario = 'create_coor';
        
        if ($model->load(Yii::$app->request->post())) {
            
            $model->updated_at = new Expression('NOW()');
            
            $valid = true;
            
            if($model->is_developed == 1){
                CourseVersion::updateAll(['is_developed' => 0], ['course_id' => $model->course_id]);
            }
            
            if($model->is_published == 1){
                if($model->status == 20){ //verified
                    if($model->is_developed ==1){
                        $valid = false;
                        Yii::$app->session->addFlash('error', "You can not publish and develop at the same time");
                    }
                    CourseVersion::updateAll(['is_published' => 0], ['course_id' => $model->course_id]);
                }else{
                    $valid = false;
                    Yii::$app->session->addFlash('error', "The status must be verified before publishing");
                };
            }
            
            if($valid && $model->save()){
                Yii::$app->session->addFlash('success', "Course Version Updated");
                return $this->redirect(['manage-version', 'course' => $course->id]);
            }
            
            
            
        }
        
        
        return $this->render('course-new-version-update', [
            'model' => $model,
            'course' => $course,
        ]);
        
    }
    
    
	public function actionDeleteVersion($id, $course){
		$course = $this->findModel($course);
        $model = $this->findVersion($id);
		if($model->deleteVersion()){
			Yii::$app->session->addFlash('success', "Course Version Deleted");
			return $this->redirect(['manage-version', 'course' => $course->id]);
		}else{
			return $this->redirect(['update-version', 'version' => $id, 'course' => $course->id]);
		}
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
    
	
	 public function actionReport($course)
    {
        $model = $this->findModel($course);
		$version = $model->developmentVersion;

        if ($version->load(Yii::$app->request->post())) {
			if($version->progress == 100){
				$version->prepared_at = new Expression('NOW()');
				$version->status = 10;
				if($version->save()){
					return $this->redirect(['course/report','course' => $course]);
				}
			}else{
				Yii::$app->session->addFlash('error', "The progress should be 100%");
			}
			
            
        }

        return $this->render('report', [
            'model' => $model,
			'version' => $version
        ]);
    }
	
	public function actionCoordinator($course)
    {
        $model = $this->findModel($course);
		$model->scenario = 'coor';
        if ($model->load(Yii::$app->request->post())) {
			if($model->save()){
				return $this->redirect(['/course/list']);
			}else{
				$model->flashError();
			}
            
        }

        return $this->render('coordinator', [
            'model' => $model,
        ]);
    }
	
	public function actionUpdate($course, $version)
    {
        $model = $this->findModel($course);
        if($version){
            $model->version_id = $version;
            $version = $this->findVersion($version);
            
        }else{
            $version = $model->developmentVersion;
        }
        
        
		$model->scenario = 'update2';
		$status = $version->status;
		
		if($status == 0 or $status == 13){
			
			if ($model->load(Yii::$app->request->post())) {
				$model->course_code = str_replace(' ','', $model->course_code);
				if($model->save()){
					$version->scenario = 'pgrs_info';
					if(Yii::$app->request->post('complete') == 1){
						$version->pgrs_info = 2;
					}else{
						$version->pgrs_info = 1;
					}
					if (!$version->save()) {
						$version->flashError();
					}
				}
			}
			
			
        $profile = $this->findProfile($version);
		$profile->scenario = 'update';
		$transferables = $profile->transferables;
		$staffs = $profile->academicStaff;

        if ($profile->load(Yii::$app->request->post())) {
            
            $profile->updated_at = new Expression('NOW()');    
			
			
             $oldIDs = ArrayHelper::map($transferables, 'id', 'id');
			$staff_oldIDs = ArrayHelper::map($staffs, 'id', 'id');
            
            $transferables = Model::createMultiple(CourseTransferable::classname(), $transferables);
			
			$staffs = Model::createMultiple(CourseStaff::classname(), $staffs);
            
            Model::loadMultiple($transferables, Yii::$app->request->post());
			Model::loadMultiple($staffs, Yii::$app->request->post());
            
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($transferables, 'id', 'id')));
			$staff_deletedIDs = array_diff($staff_oldIDs, array_filter(ArrayHelper::map($staffs, 'id', 'id')));
			
			
            
			foreach ($transferables as $i => $t) {
                $t->transfer_order = $i;
            }
			foreach ($staffs as $i => $s) {
                $s->staff_order = $i;
            }

			
			
            $valid = $profile->validate();
            $valid = Model::validateMultiple($transferables) && $valid;
			$valid = Model::validateMultiple($staffs) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
					
                    if ($flag = $profile->save(false)) {
						
                        if (! empty($deletedIDs)) {
                            CourseTransferable::deleteAll(['id' => $deletedIDs]);
                        }
						//print_r($staff_deletedIDs);die();
						if (! empty($staff_deletedIDs)) {
                            CourseStaff::deleteAll(['id' => $staff_deletedIDs]);
                        }
                        foreach ($transferables as $i => $transfer) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $transfer->crs_version_id = $profile->crs_version_id;

                            if (!($flag = $transfer->save(false))) {
                                break;
                            }
                        }
						foreach ($staffs as $i => $staff) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $staff->crs_version_id = $profile->crs_version_id;

                            if (!($flag = $staff->save(false))) {
                                break;
                            }
                        }

                    }else{
						$profile->flashError();
					}

                    if ($flag) {
                        $transaction->commit();
                            Yii::$app->session->addFlash('success', "Course Information updated");
                            if(Yii::$app->request->post('complete') == 1){
                                return $this->redirect(['view-course','course'=>$course, 'version' => $version->id]);
                            }else{
                                return $this->redirect(['update', 'course' => $course, 'version' => $version->id]);
                            }
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
				'version' => $version,
				'profile' => $profile,
				'transferables' => (empty($transferables)) ? [new CourseTransferable] : $transferables,
				'staffs' => (empty($staffs)) ? [new CourseStaff] : $staffs
			]);
			
		}else{
			
			return $this->redirect(['report', 'course' => $course]);
			
		}
		
    }
	
	public function actionHtmlView($course, $version){
		$version = $this->findCourseVersion($course, $version);
		$model = $this->findModel($course);
		
		$this->layout = '//main_html';
		return $this->render('html-view', [
				'model' => $model,
				'version' => $version,
				'current' => false
			]);
	}
	
/* 	private function updateAcademicStaff(){
		
			$flag = true;
            $staff_pic_arr = Yii::$app->request->post('staff_pic');
			
			if($staff_pic_arr){
				
				$kira_post = count($staff_pic_arr);
				$kira_lama = count($model->coursePics);
				if($kira_post > $kira_lama){
					
					$bil = $kira_post - $kira_lama;
					for($i=1;$i<=$bil;$i++){
						$insert = new CoursePic;
						$insert->course_id = $model->id;
						if(!$insert->save()){
							$flag = false;
						}
					}
				}else if($kira_post < $kira_lama){

					$bil = $kira_lama - $kira_post;
					$deleted = CoursePic::find()
					  ->where(['course_id'=>$model->id])
					  ->limit($bil)
					  ->all();
					if($deleted){
						foreach($deleted as $del){
							$del->delete();
						}
					}
				}
				
				$update_pic = CoursePic::find()
				->where(['course_id' => $model->id])
				->all();
				//echo count($staff_pic_arr);
				//echo count($update_pic);die();

				if($update_pic){
					$i=0;
					foreach($update_pic as $ut){
						$ut->staff_id = $staff_pic_arr[$i];
						$ut->save();
						$i++;
					}
				}
	}
	
	} */
	

	
	public function actionCourseReference($course, $version){
	    if($version){
	        $model = $this->findVersion($version);
	        
	    }else{
	        $model = $this->findDevelopmentVersion($course);
	    }
	    
		$ref = $model->references;
		
		if($ref){
			foreach($ref as $r){
				$r->scenario = 'saveall';
			}
		}
		
		if(Yii::$app->request->post()){
			if(Yii::$app->request->validateCsrfToken()){
				$flag = true;
				$post_ref = Yii::$app->request->post('CourseReference');
				foreach($post_ref as $key => $pref){
					$ref = CourseReference::findOne($pref['id']);
					if($ref){
						$ref->ref_full = $pref['ref_full'];
						$ref->ref_year = $pref['ref_year'];
						$ref->is_main = $pref['is_main'];
						$ref->is_classic = $pref['is_classic'];
						if(!$ref->save()){
							$flag = false;
						}
					}
				}
				
				if($flag){
					//update progress
					$model->scenario = 'pgrs_ref';
					if(Yii::$app->request->post('complete') == 1){
						$model->pgrs_ref = 2;
					}else{
						$model->pgrs_ref = 1;
					}
					if (!$model->save()) {
						$model->flashError();
					}
					Yii::$app->session->addFlash('success', "The references has been updated");
				}

			}
			
			
			if(Yii::$app->request->post('complete') == 1){
			    return $this->redirect(['view-course','course'=>$course, 'version' => $model->id]);
			}else{
			    return $this->redirect(['course-reference', 'course' => $course, 'version' => $model->id]);
			}
			
		}
		
		return $this->render('reference', [
            'model' => $model,
			'ref' => $ref
        ]);
	}
	
	public function actionCourseReferenceAdd($course, $version){
		$ref = new CourseReference;
		$ref->scenario = 'add';
		$ref->crs_version_id = $version;
		if($ref->save()){
			//
		}
		//$version = CourseVersion::findOne($version);
		//$course = $version->course_id;
		return $this->redirect(['course-reference','course'=>$course, 'version' => $version]);
	}
	
	public function actionCourseReferenceDelete($course, $version, $id){
		$ref = CourseReference::findOne(['crs_version_id' => $version, 'id' => $id]);
		$ref->delete();
		//$version = CourseVersion::findOne($version);
		//$course = $version->course_id;
		return $this->redirect(['course-reference','course'=>$course, 'version' => $version]);
	}
	
	protected function courseSyllabusAdd($version){
		$last_week = CourseSyllabus::find()->select('MAX(syl_order) as last_order')->where(['crs_version_id' => $version])->one();
		
		$syl = new CourseSyllabus;
		$syl->syl_order = $last_week->last_order + 1;
		$syl->scenario = 'addweek';
		
		$syl->crs_version_id = $version;
		if($syl->save()){
			return true;
		}else{
			$syl->flashError();
			return false;
		}
	}
	
	protected function courseSyllabusDelete($version, $id){
		$syl = CourseSyllabus::findOne(['crs_version_id' => $version, 'id' => $id]);
		if($syl->delete()){
			return true;
		}
	}
	
	public function actionCourseSyllabus($course, $version){
		//print_r(Yii::$app->request->post());die();
	    if($version){
	        $model = $this->findVersion($version);
	        
	    }else{
	        $model = $this->findDevelopmentVersion($course);
	    }
	    
		$syllabus = $model->syllabus;
		
		$kira = count($syllabus);
		$clos = $model->clos;
		if(!$syllabus){
			$new = new CourseSyllabus;
			CourseSyllabus::createWeeks($model->id);
			return $this->redirect(['course-syllabus', 'course' => $course, 'version' => $model->id]);
		}
		
		if(Yii::$app->request->post()){
			$verify_clo = true;
			$verify_content = true;
			if(Yii::$app->request->validateCsrfToken()){
				$i = 1;
				$dur = 0;
				foreach($syllabus as $syl){
					if(Yii::$app->request->post('input-week-'.$i)){
						$syl->scenario = 'saveall';
						$topic_json = Yii::$app->request->post('input-week-'.$i);
						$syl->topics = $topic_json;
						$topic = json_decode($topic_json);
							if($topic){
								if(array_key_exists(0, $topic)){
									$con = $topic[0];
									if(!empty($con->top_bm) && !empty($con->top_bi)){
										$verify_content = $verify_content == false ? false : true;
									}else{
										$verify_content = false;
									}
								}else{
									$verify_content = false;
								}
							}else{
								$verify_content = false;
							}
						$duration = Yii::$app->request->post('week-duration-'.$i);
						$syl->duration = $duration;
						$dur += $duration;
						$syl->updated_at = new Expression('NOW()');
						$syl->week_num = '#1';
						if(Yii::$app->request->post($i . '-clo')){
							$verify_clo = $verify_clo == false ? false : true;
							$post_clo = Yii::$app->request->post($i . '-clo');
							$clo = json_encode($post_clo);
							$syl->clo = $clo;
						}else{
							$verify_clo = false;
						}
						if(!$syl->save()){
							$syl->flashError();
						}
					}
				$i++;
				}
				
				if(Yii::$app->request->post('sem_break')){
					$model->syllabus_break = json_encode(Yii::$app->request->post('sem_break'));
				}else{
					$model->syllabus_break = json_encode([7]);
				}
				
				$model->save();
				
				//check additional action
				if(Yii::$app->request->post('btn-submit') == 'add-week'){
					if($this->courseSyllabusAdd($model->id)){
						Yii::$app->session->addFlash('success', "Adding new week successful");
					}
				}else if(Yii::$app->request->post('btn-submit') == 'delete-week'){
					$id = Yii::$app->request->post('delete-week-id');
					if($this->courseSyllabusDelete($model->id, $id)){
						Yii::$app->session->addFlash('success', "Deleting the week successful");
					}
				}else{
					Yii::$app->session->addFlash('success', "Syllabus Updated");
				}
				
				//update progress
				$model->scenario = 'pgrs_syll';
				if(Yii::$app->request->post('complete') == 1){
					//verify content smua ada
					//verify clo smua at least 1 setiap week
					if($this->verifySyllabus($verify_clo, $dur, $verify_content)){
						$model->pgrs_syll = 2;
					}else{
						$model->pgrs_syll = 1;
						
					}
					
				}else{
					$model->pgrs_syll = 1;
				}
				if (!$model->save()) {
					$model->flashError();
				}
				
				
			}
			
			if(Yii::$app->request->post('complete') == 1 && $verify_content && $verify_clo){
			    return $this->redirect(['view-course','course'=>$course, 'version' => $model->id]);
			}else{
			    return $this->redirect(['course-syllabus', 'course' => $course, 'version' => $model->id]);
			}
			
			
			
			
		}
		
		return $this->render('syllabus', [
            'model' => $model,
			'syllabus' => $syllabus,
			'clos' => $clos
        ]);
	}
	
	private function verifySyllabus($clo, $duration, $content){
		$value = true;
		if(!$clo){
			$value = false;
			Yii::$app->session->addFlash('error', "Cannot mark as complete, make sure at least one clo for each week");
		}
		if($duration < 14){
			$value = false;
			Yii::$app->session->addFlash('error', "Cannot mark as complete, make sure at least 14 weeks is added");
		}
		if(!$content){
			$value = false;
			Yii::$app->session->addFlash('error', "Cannot mark as complete, make sure at least one topic for each week in Bahasa and English is available.");
		}
		return $value;
	}
	
	public function actionCourseSyllabusReorder($id, $version){
	
	    if($version){
	        $model = $this->findVersion($version);
	        
	    }else{
	        $model = $this->findDevelopmentVersion($course);
	    }
		$syllabus = $model->syllabus;
		if(array_key_exists('or',Yii::$app->request->queryParams)){
			$reorder = Yii::$app->request->queryParams['or'];
		//print_r(reorder);die();
		if($syllabus){
			foreach($syllabus as $s){
				if (array_key_exists($s->id,$reorder)){
					$s->syl_order = $reorder[$s->id];
					$s->save();
				}
				
			}
		}
		}else{
			Yii::$app->session->addFlash('error', "No sorting data supplied!");
		}
		
		return $this->redirect(['course-syllabus', 'course' => $id, 'version' => $model->id]);
	}
	
	public function actionCourseCloDelete($version, $clo){
	    $transaction = Yii::$app->db->beginTransaction();
	    try {
	        $clo = CourseClo::findOne(['id' => $clo, 'crs_version_id' => $version]);
	        $clo->delete();
	        $assess = CourseCloAssessment::deleteAll(['clo_id' => $clo]);
	        $transaction->commit();
	        
	    }
	    catch (Exception $e)
	    {
	        $transaction->rollBack();
	        Yii::$app->session->addFlash('error', $e->getMessage());
	    }
	    
	    
		
		$version = CourseVersion::findOne($version);
		$course = $version->course_id;
		return $this->redirect(['course-clo','course'=>$course, 'version' => $version->id]);
	}
	
	public function actionCourseCloAdd($version){
		$clo = new CourseClo;
		$clo->crs_version_id = $version;
		if($clo->save()){
			// //
		}
		$version = CourseVersion::findOne($version);
		$version->pgrs_clo = 1;
		$version->save();
		$course = $version->course_id;
		return $this->redirect(['course-clo','course'=>$course, 'version' => $version->id]);
	}
	
	public function actionCourseClo($course, $version)
    {
        $model = $this->findModel($course);
        if($version){
            $model->version_id = $version;
            $version = $this->findVersion($version);
            
        }else{
            $version = $model->developmentVersion;
        }
        
        $model = $version;
		$clos = $model->clos;
		/* if($clos){
			foreach($clos as $clo){
				$clo->scenario = 'clo';
			}
		} */
        
        if (Yii::$app->request->post()) {
			if(Yii::$app->request->validateCsrfToken()){
				
				$flag = true;
                $post_clo = Yii::$app->request->post('CourseClo');
				$boo = true;
				foreach($post_clo as $key => $pclo){
					if(!$flag){
						break;
					}
					$clo = CourseClo::findOne($key);
					if($clo){
						if(!empty($pclo['clo_text']) and !empty($pclo['clo_text_bi'])){
							$boo = $boo == false ? false : true;
						}else{
							$boo = false;
						}
						$clo->clo_text = $pclo['clo_text'];
						$clo->clo_text_bi = $pclo['clo_text_bi'];
						if(!$clo->save()){
							$flag = false;
						}
					}
				}
            }
			if($flag){
				//update progress
				$model->scenario = 'pgrs_clo';
				if(Yii::$app->request->post('complete') == 1){
					//validate complete
					if($boo){
						$model->pgrs_clo = 2;
					}else{
						$model->pgrs_clo = 1;
						Yii::$app->session->addFlash('error', "Cannot mark as complete, make sure all CLO text are filled");
					}
					
					
				}else{
					$model->pgrs_clo = 1;
				}
				if (!$model->save()) {
					$model->flashError();
				}
				
				Yii::$app->session->addFlash('success', "Data Updated");
				if(Yii::$app->request->post('complete') == 1 && $boo){
				    return $this->redirect(['view-course','course'=>$course, 'version' => $model->id]);
				}else{
				    return $this->redirect(['course-clo','course'=>$course, 'version' => $version->id]);
				}
				
				
				
				
			}
			
		}
	
		return $this->render('clo', [
				'model' => $model,
				'clos' => $clos
			]);
	
	
	
	}
	
	public function actionCloPlo($course, $version){
	    if($version){
	        $model = $this->findVersion($version);
	        
	    }else{
	        $model = $this->findDevelopmentVersion($course);
	    }
		$clos = $model->clos;
		if (Yii::$app->request->post() ) {
			$flag = true;
			if(Yii::$app->request->validateCsrfToken()){
				
                $clos = Yii::$app->request->post('plo');
				if($clos){
					foreach($clos as $key => $plos){
						$row = CourseClo::findOne($key);
						if($row){
							foreach($plos as $p=>$plo){
								$row->{$p} = $plo;
							}
							if(!$row->save()){
								$flag = false;
								break;
							}
						}
					}
					
				}
				
            }
			if($flag){
				
				//update progress
				$model->scenario = 'pgrs_plo';
				if(Yii::$app->request->post('complete') == 1){
					$model->pgrs_plo = 2;
				}else{
					$model->pgrs_plo = 1;
				}
				if (!$model->save()) {
					$model->flashError();
				}
				
				Yii::$app->session->addFlash('success', "Data Updated");
				
				
				if(Yii::$app->request->post('complete') == 1){
				    return $this->redirect(['view-course','course'=>$course, 'version' => $model->id]);
				}else{
				    return $this->redirect(['clo-plo', 'course' => $course, 'version' => $model->id]);
				}
				
				
				
			}
			
			
		}
	
		return $this->render('clo_plo', [
				'model' => $model,
				'clos' => $clos
			]);
	}
	
	public function actionCloTaxonomy($course, $version){
	    if($version){
	        $model = $this->findVersion($version);
	        
	    }else{
	        $model = $this->findDevelopmentVersion($course);
	    }
	    
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
				
				//update progress
				$model->scenario = 'pgrs_tax';
				if(Yii::$app->request->post('complete') == 1){
					$model->pgrs_tax = 2;
				}else{
					$model->pgrs_tax = 1;
				}
				if (!$model->save()) {
					$model->flashError();
				}
            }
            
            Yii::$app->session->addFlash('success', "Data Updated");
            if(Yii::$app->request->post('complete') == 1){
                return $this->redirect(['view-course','course'=>$course, 'version' => $model->id]);
            }else{
                return $this->redirect(['clo-taxonomy', 'course' => $course, 'version' => $model->id]);
            }
            
            
			
			
		}
	
		

		return $this->render('clo_taxonomy', [
				'model' => $model,
				'clos' => $clos
			]);
	}
	
	public function actionCloDelivery($course, $version){
	    if($version){
	        $model = $this->findVersion($version);
	        
	    }else{
	        $model = $this->findDevelopmentVersion($course);
	    }
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
				
				//update progress
				$model->scenario = 'pgrs_delivery';
				if(Yii::$app->request->post('complete') == 1){
					$model->pgrs_delivery = 2;
				}else{
					$model->pgrs_delivery = 1;
				}
				if (!$model->save()) {
					$model->flashError();
				}
				
				
            }
			
			
			
			Yii::$app->session->addFlash('success', "Data Updated");
			if(Yii::$app->request->post('complete') == 1){
			    return $this->redirect(['view-course','course'=>$course, 'version' => $model->id]);
			}else{
			    return $this->redirect(['clo-delivery', 'course' => $course, 'version' => $model->id]);
			}
			
			
		}
	
		return $this->render('clo_delivery', [
				'model' => $model,
				'clos' => $clos
			]);
	}
	
	public function actionCloSoftskill($course, $version){
	    if($version){
	        $model = $this->findVersion($version);
	        
	    }else{
	        $model = $this->findDevelopmentVersion($course);
	    }
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
				//update progress
				$model->scenario = 'pgrs_soft';
				if(Yii::$app->request->post('complete') == 1){
					$model->pgrs_soft = 2;
				}else{
					$model->pgrs_soft = 1;
				}
				if (!$model->save()) {
					$model->flashError();
				}
            }
            
            
            
            Yii::$app->session->addFlash('success', "Data Updated");

            if(Yii::$app->request->post('complete') == 1){
                return $this->redirect(['view-course','course'=>$course, 'version' => $model->id]);
            }else{
                return $this->redirect(['clo-softskill', 'course' => $course, 'version' => $model->id]);
            }
            
            
		}
		return $this->render('clo_softskill', [
				'model' => $model,
				'clos' => $clos
			]);
	}
	
	public function actionViewCourse($course, $version = false){
		$model = $this->findModel($course);
		if($version){
		    $model->version_id = $version;
		    $version = $this->findVersion($version);
		    
		}else{
		    $version = $model->developmentVersion;
		}
		
		if(!$version){
		    Yii::$app->session->addFlash('error', 'There is no development version for this course.');
		    return $this->redirect(['manage-version', 'course' => $model->id]);
		}
		
		if ($version->load(Yii::$app->request->post())) {
			 
			$action = Yii::$app->request->post('wfaction');
			
			if($action == 'btn-submit'){
				if($version->progress == 100){
					if($version->preparedsign_file){
						$version->prepared_at = new Expression('NOW()');
						$version->updated_at = new Expression('NOW()');
						if($version->status == 0){
							$version->status = 10;
						}else if($version->status == 13){
							$version->status = 17;
						}
						
						if($version->save()){
						    $version->checkProgressCourseFile();
						    Yii::$app->session->addFlash('success', "The Course Information has been successfully submitted");
							return $this->redirect(['course/view-course','course' => $course]);
						}
					}else{
						Yii::$app->session->addFlash('error', "Upload your signature first");
					}
					
				}else{
					Yii::$app->session->addFlash('error', "In order to submit, the progress should be 100%");
				}
			}else{
				$version->updated_at = new Expression('NOW()');
				if($version->save()){
					//echo $action;die();
					Yii::$app->session->addFlash('success', "Signiture updated");
					return $this->refresh();
				}else{
					$version->flashError();
				}
			}

        }
		
		return $this->render('view-course', [
				'model' => $model,
				'version' => $version,
				'current' => true
			]);
	}
	
	
	public function actionCloAssessment($course, $version){
	    if($version){
	        $model = $this->findVersion($version);
	        
	    }else{
	        $model = $this->findDevelopmentVersion($course);
	    }
	    
		$items = $model->assessments;
		if($model->putOneCloAssessment()){
			return $this->redirect(['clo-assessment', 'course' => $course, 'version' => $model->id]);
		}
		
		$clos = $model->clos;
		$arr_valid = [];
		$valid_one = true;
		if ($model->load(Yii::$app->request->post())) {
			$total = 0;
			$one_clo = true;
			if(Yii::$app->request->validateCsrfToken()){
			$flag = true;
                $cloAs = Yii::$app->request->post('CourseCloAssessment');
				if($cloAs){
					foreach($cloAs as $ca){
						$row = CourseCloAssessment::findOne($ca['id']);
						$ass_id = $ca['assess_id'];
						if(in_array($ass_id, $arr_valid)){
							$valid_one = false;
						}else{
							$valid_one = $valid_one == false ? false : true;
						}
						$arr_valid[] = $ass_id;
						/* if(is_null($row->assess_id)){
							Yii::$app->session->addFlash('error', "Please select the assessment.");
							$flag = false;
							break;
						} */
						$row->assess_id = $ass_id;
						
						$clo = $row->clo_id;
						
						$row->percentage = $ca['percentage'];
						$total += $ca['percentage'];
						if(!$row->save()){
							$flag = false;
						}
					}
					
				}
				
				//print_r($clo127);die('anda jutawan');
				
				if($flag){
					Yii::$app->session->addFlash('success', "Assessment percentage has been updated");
					//update progress
					$model->scenario = 'pgrs_assess_per';
					if(Yii::$app->request->post('complete') == 1){
						if($total==100){
							if($valid_one){
								$model->pgrs_assess_per = 2;
							}else{
								$model->pgrs_assess_per = 1;
								Yii::$app->session->addFlash('error', "Make sure an assessment is only mapped to one clo.");
							}
							
						}else{
							$model->pgrs_assess_per = 1;
							Yii::$app->session->addFlash('error', "Cannot mark as complete as the percentage is not equal to 100");
						}
						
					}else{
						$model->pgrs_assess_per = 1;
					}
					
					$model->updated_at = new Expression('NOW()');
					if (!$model->save()) {
						$model->flashError();
					}
				}
				
				
            }
			
            if(Yii::$app->request->post('complete') == 1){
                return $this->redirect(['view-course','course'=>$course, 'version' => $model->id]);
            }else{
                return $this->redirect(['clo-assessment', 'course' => $course, 'version' => $model->id]);
            }
						
            
			
		}
	
		return $this->render('clo_assessment', [
				'model' => $model,
				'clos' => $clos,
				'assess' => $items
			]);
	}
	
	public function actionCourseSlt($course, $version){
	    if($version){
	        $model = $this->findVersion($version);
	        
	    }else{
	        $model = $this->findDevelopmentVersion($course);
	    }
	    
		$slt = $model->slt;
		$syll = $model->syllabus;
		
		if ($model->load(Yii::$app->request->post())) {
	
			if(Yii::$app->request->validateCsrfToken()){
				$flag = true;
				//print_r(Yii::$app->request->post('slt'));die();
				$post_slt = Yii::$app->request->post('slt');
				/* foreach($post_slt as $key => $val){
				$slt->{$key} = $val;
				} */
				$slt->is_practical = Yii::$app->request->post('is_practical');
				if(!$slt->save()){
					$flag = false;
				}
				
				$post_assess = Yii::$app->request->post('assess');
				if($post_assess){
					foreach($post_assess as $key => $val){
					$as = CourseAssessment::findOne($key);
					$as->scenario = 'update_slt';
					if($as){
						$val = empty($val) ? 0 : $val;
						$as->assess_f2f = $val;
						if(!$as->save()){
							$flag = false;
							$as->flashError();
						}
					}
				}
				}
				
				$post_assess = Yii::$app->request->post('assess2');
				if($post_assess){
					foreach($post_assess as $key => $val){
					$as = CourseAssessment::findOne($key);
					$as->scenario = 'update_slt2';
					if($as){
						$val = empty($val) ? 0 : $val;
						$as->assess_nf2f = $val;
						if(!$as->save()){
							$flag = false;
							$as->flashError();
						}
					}
				}
				}
				
				
				$post_assess = Yii::$app->request->post('assess_tech');
				//print_r($post_assess);die();
				if($post_assess){
					foreach($post_assess as $key => $val){
					$as = CourseAssessment::findOne($key);
					$as->scenario = 'update_slt_tech';
					if($as){
						$val = is_null($val) ? 0 : $val;
						$val = empty($val) ? 0 : $val;
						$as->assess_f2f_tech = $val;
						if(!$as->save()){
							$flag = false;
							$as->flashError();
						}
					}
				}
				}
				
				
				$post_assess = Yii::$app->request->post('syll');
				foreach($post_assess as $key => $val){
					$syl = CourseSyllabus::findOne($key);
					$syl->scenario = 'slt';
					if($syl){
						foreach($val as $i => $v){
							$v = is_null($v) ? 0 : $v;
							$v = empty($v) ? 0 : $v;
							$syl->{$i} = $v;
						}
						if(!$syl->save()){
							$flag = false;
							$syl->flashError();
						}
					}
				}
            }
			//die();
			if($flag){
				//update progress
				$model->scenario = 'pgrs_slt';
				if(Yii::$app->request->post('complete') == 1){
					$model->pgrs_slt = 2;
				}else{
					$model->pgrs_slt = 1;
				}
				$model->updated_at = new Expression('NOW()');
				if (!$model->save()) {
					$model->flashError();
				}
				Yii::$app->session->addFlash('success', "Student Learning Time has been successfully updated");
			}
			
			if(Yii::$app->request->post('complete') == 1){
			    return $this->redirect(['view-course','course'=>$course, 'version' => $model->id]);
			}else{
			    return $this->redirect(['course-slt', 'course' => $course, 'version' => $model->id]);
			}
			
			
		}

		return $this->render('slt', [
				'model' => $model,
				'slt' => $slt,
				'syll' => $syll
			]);
	}
	
	public function actionCourseAssessment($course, $version)
    {
        $model = $this->findModel($course);
        if($version){
            $model->version_id = $version;
            $version = $this->findVersion($version);
            
        }else{
            $version = $model->developmentVersion;
        }
        
        
        $model = $version;
		$items = $model->assessments;
		if($items){
			foreach($items as $item){
				$item->scenario = 'saveall';
			}
		}

		
        if (Yii::$app->request->post()) {
			if(Yii::$app->request->validateCsrfToken()){
				
                $assess = Yii::$app->request->post('CourseAssessment');
				if($assess){
				//print_r($assess);die();
				$final = 0;
				$flag = true;
				$transaction = Yii::$app->db->beginTransaction();
				$boo = true;
				foreach($assess as $key => $as){
					if(!$flag ){
						break;
					}
					//Yii::$app->session->addFlash('info', $as['id']);
					$assesment = CourseAssessment::findOne($as['id']);
					if($assesment){
					    
					    if(!empty($as['assess_name']) and !empty($as['assess_name_bi']) and !empty($as['assess_cat'])){
					        $boo = $boo == false ? false : true;
					    }else{
					        $boo = false;
					    }
					    
					    
						$assesment->assess_name = $as['assess_name'];
						$assesment->assess_name_bi = $as['assess_name_bi'];
						$assesment->assess_cat = $as['assess_cat'];
						
						//update progress
						$model->scenario = 'pgrs_assess';
						if(Yii::$app->request->post('complete') == 1){
						    
						    
						    if($boo){
						        $model->pgrs_assess = 2;
						    }else{
						        $model->pgrs_assess = 1;
						        Yii::$app->session->addFlash('error', "Cannot mark as complete, make sure all assessments are filled");
						    }
						    

						}else{
							$model->pgrs_assess = 1;
						}
						if (!$model->save()) {
							$model->flashError();
						}
						
						if(!$assesment->save()){
							$flag = false;
							break;
						}
					}
				}
				if($flag){
					$transaction->commit();
					Yii::$app->session->addFlash('success', "Data Updated");
					if(Yii::$app->request->post('complete') == 1 && $boo){
    					    return $this->redirect(['view-course','course'=>$course, 'version' => $model->id]);
    					}else{
    					    return $this->redirect(['course-assessment','course'=>$course, 'version' => $model->id]);
    					}
					
					
				}else{
					$transaction->rollBack();
					return $this->redirect(['course-assessment','course'=>$course, 'version' => $model->id]);
				}
				
				}
				
            }
			
		}
		
	
	
	/* foreach($items as $item){
		$item->scenario = 'saveall';
	} */
	
		return $this->render('assessment', [
				'model' => $model,
				'items' => (empty($items)) ? [] : $items,
			]);
	}
	
	public function actionCourseAssessmentAdd($version){
		$as = new CourseAssessment;
		$as->scenario = 'add';
		$as->crs_version_id = $version;
/* 		$as->assess_cat = 1;
		$as->assess_name = 'assesment name';
		$as->assess_name_bi = 'assesment name - en'; */
		if($as->save()){
			$version = CourseVersion::findOne($version);
			$version->pgrs_assess = 1;
			$version->save();
			$course = $version->course_id;
			$this->redirect(['course-assessment', 'course' => $course, 'version' => $version->id]);
		}else{
			$as->flashError();
		}
	}
	
	public function actionCourseAssessmentDelete($version, $id){
		$as = CourseAssessment::findOne(['crs_version_id' => $version, 'id' => $id]);
		$as->delete();
		$version = CourseVersion::findOne($version);
		$course = $version->course_id;
		return $this->redirect(['course-assessment','course'=>$course, 'version' => $version->id]);
	}
	
	public function actionAddAssessmentClo($course, $clo, $v){
		$clo_as = new CourseCloAssessment;
		$clo_as->clo_id = $clo;
		$clo_as->save();
		$this->redirect(['clo-assessment', 'course' => $course, 'version' => $v]);
	}
	
	public function actionDeleteAssessmentClo($course, $id, $v){
		$clo_as = CourseCloAssessment::findOne($id);
		$clo_as->delete();
		$this->redirect(['clo-assessment', 'course' => $course, 'version' => $v]);
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
    
    protected function findOffer($id)
    {
        if (($model = CourseOffered::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findOfferBySemester($course, $semester)
    {
        if (($model = CourseOffered::findOne(['course_id' => $course, 'semester_id' => $semester])) !== null) {
            return $model;
        }
        
       // throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	
	protected function findProfile($version)
    {
		$model = CourseProfile::findOne(['crs_version_id' => $version->id]);
		if($model){
			return $model;
		}else{
			$profile = new CourseProfile;
			$profile->scenario = 'fresh';
			$profile->crs_version_id = $version->id;
			if($profile->save()){
				return $profile;
			}else{
				throw new NotFoundHttpException('There is problem creating course profile!');
			}
		}
    }
	
	protected function findDevelopmentVersion($id){
		$default = CourseVersion::findOne(['course_id' => $id, 'is_developed' => 1]);
		if($default){
			return $default;
		}else{
			throw new NotFoundHttpException('Please create development version for this course!');
		}
	}
	
	protected function findVersion($id){
		$default = CourseVersion::findOne($id);
		if($default){
			return $default;
		}else{
			throw new NotFoundHttpException('Page not found!');
		}
	}
	
	protected function findCourseVersion($course, $version){
		$default = CourseVersion::findOne(['course_id' => $course, 'id' => $version]);
		if($default){
			return $default;
		}else{
			throw new NotFoundHttpException('Page not found!');
		}
	}
	
	protected function findPublishedVersion($id){
		$default = CourseVersion::findOne(['course_id' => $id, 'is_published' => 1]);
		if($default){
			return $default;
		}else{
			throw new NotFoundHttpException('Please create published version for this course!');
		}
	}
	
	protected function findCourseClo($id)
    {
		$default = $this->findDevelopmentVersion($id);
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
	
	public function actionFk1($course, $dev = false, $version = false){		
			$pdf = new Fk1;
			$pdf->model = $this->decideVersion($course, $dev, $version);
			$pdf->generatePdf();
			exit;
	}
	
	public function actionFk2($course, $dev = false, $version = false, $offer=false){
			$pdf = new Fk2;
			$pdf->model = $this->decideVersion($course, $dev, $version);
			if($offer){
			    $pdf->offer = $this->findOffer($offer);
			}
			$pdf->generatePdf();
			exit;
	}
	
	private function decideVersion($course, $dev, $version){
		if($version){
			//control access
			$model = $this->findVersion($version);
		}else if($dev){
			$model = $this->findDevelopmentVersion($course);
		}else{
			$published =CourseVersion::findOne(['course_id' => $course, 'is_published' => 1]);
			$developed =CourseVersion::findOne(['course_id' => $course, 'is_developed' => 1]);
			if($published){
				$model = $published;
			}else if($developed){
				$model = $developed;
			}else{
				die('Neither published nor development version exist!');
			}
		}
		return $model;
	}
	
	//---------TABLE 4 start--------------------
	//version 1.0 pdf
	public function actionTbl4($course, $dev = false, $version = false, $team = false){
			$pdf = new Tbl4;
			$pdf->model = $this->decideVersion($course, $dev, $version);
			if($team){
			    $pdf->offer = $this->findOffer($team);
			}
			$pdf->generatePdf();
			exit;
	}
	
	//version 1.0 excel
	public function actionTbl4Excel($course, $dev = false, $version = false){
	    $pdf = new Tbl4Excel;
	    $pdf->model = $this->decideVersion($course, $dev, $version);
	    $pdf->generateExcel();
		exit;
	}
	
	//version 2.0 pdf
	public function actionTbl4Pdf($course, $dev = false, $version = false, $team = false, $offer = false){
			$pdf = new Tbl4Pdf;
			$pdf->model = $this->decideVersion($course, $dev, $version);
			if($team){
			    $pdf->offer = $this->findOffer($team);
			}
			$pdf->generatePdf();
			exit;
	}
	
	//version 2.0 excel
	public function actionTbl4Excel2($course, $dev = false, $version = false){
			$pdf = new Tbl4Excel2;
			$pdf->model = $this->decideVersion($course, $dev, $version);
			$pdf->generateExcel();
			exit;
	}
	
	//---------TABLE 4 end--------------------
	
	public function actionFk3($course, $dev = false, $version = false, $offer = false, $cqi = false, $xana = false, $group = false){
			
		$pdf = new Fk3;
		$pdf->model = $this->decideVersion($course, $dev, $version);
		if($offer){
			$pdf->offer = $this->findCourseOffered($offer);
			if($cqi == 1){
			   $pdf->cqi = true; 
			}
			if($xana == 1){
			    $pdf->xana = true;
			}
			if($group == 1){
			    $pdf->group = 1;
			}else if($group == 2){
			    $pdf->group = 2;
			}
		}
		$pdf->generatePdf();
		exit;
			
	}

	public function actionFk1WordX($course, $dev = false, $version = false){		
		$doc = new Fk1Word;
		$doc->model = $this->decideVersion($course, $dev, $version);
		$doc->generate();
	    exit;
	}

	public function actionFk3Word($course, $dev = false, $version = false, $offer = false, $cqi = false, $xana = false, $group = false){
	    
	    $doc = new Fk3Word();
	    $doc->model = $this->decideVersion($course, $dev, $version);
	    if($offer){
	        $doc->offer = $this->findCourseOffered($offer);
	        if($cqi == 1){
	            $doc->cqi = true;
	        }
	        if($xana == 1){
	            $doc->xana = true;
	        }
	        if($group == 1){
	            $doc->group = 1;
	        }else if($group == 2){
	            $doc->group = 2;
	        }
	    }
	    $doc->generate();
	    exit;
	    
	}
	
	protected function findCourseOffered($id){
		$default = \backend\modules\teachingLoad\models\CourseOffered::findOne($id);
		if($default){
			return $default;
		}else{
			throw new NotFoundHttpException('Page not found!');
		}
	}
	
	
	
	public function actionDuplicate(){
		/* $clone = new CourseVersionClone;
		$clone->ori_version = 2;
		$clone->copy_version = 999;
		if($clone->cloneVersion()){
			echo 'good';
		} */
		
	}
	
	public function actionUploadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findVersion($id);
        $model->file_controller = 'course';
		$path = 'course-mgt/signiture/' . Yii::$app->user->identity->staff->staff_no ;
        return UploadFile::upload($model, $attr, 'updated_at', $path);

    }

	protected function clean($string){
		$allowed = ['preparedsign', 'verifiedsign'];
		if(in_array($string,$allowed)){
			return $string;
		}
		throw new NotFoundHttpException('Invalid Attribute');
	}

	public function actionDeleteFile($attr, $id){
		$attr = $this->clean($attr);
		$model = $this->findVersion($id);
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
		$model = $this->findVersion($id);
		$filename = strtoupper($attr) . ' ' . Yii::$app->user->identity->fullname;
		
		
		
		UploadFile::download($model, $attr, $filename);
	}
	
	
	
}
