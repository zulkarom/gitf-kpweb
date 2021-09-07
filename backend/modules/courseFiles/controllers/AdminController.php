<?php

namespace backend\modules\courseFiles\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\courseFiles\models\ProgramCoordinatorSearch;
use backend\modules\teachingLoad\models\CourseOffered;
use backend\modules\courseFiles\models\Checklist;
use backend\modules\esiap\models\CourseVersion;
use yii\filters\AccessControl;
use yii\db\Expression;
use yii\web\NotFoundHttpException;
use backend\models\SemesterForm;
use backend\models\Semester;
use backend\modules\courseFiles\models\CourseFilesSearch;
use backend\modules\courseFiles\models\AssignAuditorForm;
use backend\modules\courseFiles\models\DateSetting;
use backend\modules\esiap\models\CoursePic;
use backend\modules\esiap\models\Program;

/**
 * Default controller for the `course-files` module
 */
class AdminController extends Controller
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
	
	public function actionSummary(){
		 return $this->render('summary', [
        ]);
	}
	
	public function actionIndex()
    {
        $semester = new SemesterForm;
		$audit = new AssignAuditorForm;

        if(Yii::$app->getRequest()->getQueryParam('SemesterForm')){
            $sem = Yii::$app->getRequest()->getQueryParam('SemesterForm');
            $semester->semester_id = $sem['semester_id'];
            $semester->str_search = $sem['str_search'];
        }else{
            $semester->semester_id = Semester::getCurrentSemester()->id;
        }
		
		if ($audit->load(Yii::$app->request->post())) {
			$selection = Yii::$app->request->post('selection');
			if($selection){
				if($audit->staff_id){
					foreach($selection as $offer_id){
						$offer = CourseOffered::findOne($offer_id);
						if($offer){
							$offer->auditor_staff_id = $audit->staff_id;
							$offer->save();
						}
					}
					Yii::$app->session->addFlash('success', "Assigning successful");
					return $this->refresh();
				}
			}else{
				Yii::$app->session->addFlash('error', "Please select courses to assign");
			}
			
		}


        $searchModel = new CourseFilesSearch();
        $searchModel->semester = $semester->semester_id;
        $searchModel->search_course = $semester->str_search;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'semester' => $semester,
			'audit' => $audit
        ]);
    }
    
    public function actionProgramCoordinator()
    {
        //check dia coordinator ke tak
        $program = Program::findOne(['head_program' => Yii::$app->user->identity->staff->id]);
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
        
        $searchModel = new ProgramCoordinatorSearch();
        $searchModel->semester = $semester->semester_id;
        $searchModel->search_course = $semester->str_search;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        
        return $this->render('program-coordinator', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'semester' => $semester,
            'program' => $program
        ]);
    }
	
	public function actionDates(){
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
		
		$dates = DateSetting::find()->where(['semester_id' => $semester->semester_id])->one();
		if($dates === null){
			$dates = new DateSetting;
			$dates->semester_id = $semester->semester_id;
			$dates->save();
		}
		
		if ($dates->load(Yii::$app->request->post())) {
			if($dates->save()){
				Yii::$app->session->addFlash('success', "Data Updated");
				return $this->refresh();
			}
		}

		
		return $this->render('dates', [
			'dates' => $dates,
			'semester' => $semester,
        ]);
	}

    public function actionCourseFilesView($id)
    {
        $model = new Checklist();
        $modelOffer = $this->findOffered($id);
		
		if ($modelOffer->load(Yii::$app->request->post())) {
			//echo $modelOffer->status; die();
			
			if($modelOffer->option_review == 50 and $modelOffer->option_course == 1){
				Yii::$app->session->addFlash('error', "You cannot verify at the same time open for update course");
			}else{
				if($modelOffer->status == 50){
					$modelOffer->verified_at = new Expression('NOW()');
					$modelOffer->verified_by = Yii::$app->user->identity->staff->id;
				}else if($modelOffer->option_course == 1){
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
				if($modelOffer->save()){
					Yii::$app->session->addFlash('success', "Status Updated");
					return $this->refresh();
				}else{
					$modelOffer->flashError();
				}
			}
			
			
		}else{
			$modelOffer->setOverallProgress();
			$modelOffer->save();
		}
		
		
		
		
		
		
        return $this->render('course-files-view', [
            'model' => $model,
            'modelOffer' => $modelOffer,
        ]);
    }
    
    public function actionCourseFilesCoorView($id)
    {
        $model = new Checklist();
        $modelOffer = $this->findOffered($id);

        return $this->render('course-files-coor-view', [
            'model' => $model,
            'modelOffer' => $modelOffer,
        ]);
    }

    protected function findOffered($id)
    {
        if (($model = CourseOffered::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionMakeCoorAsOwnerCode213(){
		$offers = CourseOffered::find()->where(['semester_id' => '202020211'])->all();
		foreach($offers as $offer){
			if($offer->course){
				if($offer->coor){
					$staff_id = $offer->coordinator;
					$course_id = $offer->course_id;
					$pic = CoursePic::findOne(['staff_id' => $staff_id, 'course_id' => $course_id]);
					if($pic){
						echo 'jutawan';echo '<br />';
					}else{
						$new = new CoursePic;
						$new->staff_id = $staff_id;
						$new->course_id = $course_id;
						$new->updated_at = new Expression('NOW()');
						if($new->save()){
							echo 'inserted';echo '<br />';
						}
					}
					echo $staff_id;echo '<br />';
					echo $course_id;echo '<br />';echo '<br />';
					//echo 'course: ' . $offer->course->course_name;echo '<br />';
					//echo $offer->id;echo $offer->coor->user->fullname;echo '<br />';echo '<br />';
					
				}
				
			}
			
			
		}
	}
}
