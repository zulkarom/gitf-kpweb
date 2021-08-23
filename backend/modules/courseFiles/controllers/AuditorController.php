<?php

namespace backend\modules\courseFiles\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\courseFiles\models\CoordinatorRubricsFile;
use backend\modules\teachingLoad\models\CourseOffered;
use backend\modules\teachingLoad\models\CourseLecture;
use backend\modules\courseFiles\models\Checklist;
use yii\filters\AccessControl;
use yii\db\Expression;
use yii\web\NotFoundHttpException;
use common\models\UploadFile;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\bootstrap\Modal;
use backend\models\SemesterForm;
use backend\models\Semester;
use backend\modules\courseFiles\models\AuditorSearch;
use backend\modules\esiap\models\CourseVersion;
use backend\modules\courseFiles\models\DateSetting;

/**
 * Default controller for the `course-files` module
 */
class AuditorController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
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

	
	public function actionIndex()
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

        $searchModel = new AuditorSearch();
        $searchModel->semester = $semester->semester_id;
        $searchModel->search_course = $semester->str_search;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		$dates = DateSetting::find()->where(['semester_id' => $semester->semester_id])->one();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'semester' => $semester,
			'dates' => $dates
        ]);
    }

    public function actionCourseFilesView($id)
    {
        $model = new Checklist();
        $modelOffer = $this->findModel($id);  
		$modelOffer->scenario = 'audit';
		
		if ($modelOffer->load(Yii::$app->request->post())) {
			$valid = true;
			if($modelOffer->option_review == 30 and $modelOffer->option_course == 1){
				Yii::$app->session->addFlash('error', "Input not valid");
			}else{
				if($modelOffer->auditor_file){
					
					$modelOffer->status = $modelOffer->option_review;
						if($modelOffer->status == 30){
							$modelOffer->reviewed_at = new Expression('NOW()');
						}
					//20 reupdate //30 complete
					if($modelOffer->option_course == 1){
						$version = CourseVersion::findOne($modelOffer->course_version);
						if($version){
							$version->status = 0;
							if($version->save()){
								$modelOffer->prg_crs_ver = 0.5;
							}else{
								$version->flashError();
							}
						}else{
							Yii::$app->session->addFlash('error', "Course version not found");
						}
						
					}
					$modelOffer->is_audited = 1;
					$modelOffer->reviewed_at = new Expression('NOW()');
					$modelOffer->save();
					Yii::$app->session->addFlash('success', "Audit Report Submitted");
					return $this->redirect(['index']);
					
				}else{
					Yii::$app->session->addFlash('error', "Please update auditor report");
				}
			}
			
		}
		
        return $this->render('course-files-view', [
            'model' => $model,
            'modelOffer' => $modelOffer,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = CourseOffered::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionUploadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $model->file_controller = 'auditor';
		
		$path = 'course-files/'.$model->semester_id.'/'.$model->course->course_code;

        return UploadFile::upload($model, $attr, 'updated_at', $path);

    }

	protected function clean($string){
    $allowed = ['auditor', 'verified'];
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
        $filename = 'AUDITOR_REVIEW_' . $model->course->course_code;
        
        
        
        UploadFile::download($model, $attr, $filename);
    }
	
	public function actionSubmitAuditorReview($id){
		//sepatutnya kena check progress dulu
		$offer = $this->findOffered($id);
		$course = $offer->course;
		if($offer->prg_overall == 1){
			$offer->status = 10;
			if($offer->save()){
				Yii::$app->session->addFlash('success', "The course file for ".$course->course_code ." ". $course->course_name ." has been successfully submitted.");
				return $this->redirect(['teaching-assignment']);
				
			}
		}else{
			Yii::$app->session->addFlash('error', "The progress of course file must be 100% in order to submit.");
			return $this->redirect(['coordinator-view', 'id' => $id]);
		}
		
	}


}
