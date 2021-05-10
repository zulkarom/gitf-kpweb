<?php

namespace backend\modules\teachingLoad\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\modules\teachingLoad\models\TeachingStaffSearch;
use backend\modules\teachingLoad\models\ContactHourSearch;
use backend\modules\teachingLoad\models\TeachingCourseSearch;
use backend\modules\teachingLoad\models\CourseLectureStaffSearch;
use backend\modules\teachingLoad\models\CourseLectureSearch;
use backend\modules\teachingLoad\models\Course;
use backend\modules\teachingLoad\models\Setting;
use backend\modules\teachingLoad\models\MaximumHour;
use yii\db\Expression;
use backend\models\SemesterForm;
use backend\models\Semester;


/**
 * Default controller for the `teaching-load` module
 */
class ManagerController extends Controller
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
        //return $this->render('index');
    }
	
	public function actionByStaff()
    {
		$searchModel = new TeachingStaffSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('bystaff', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    public function actionSummaryByStaff()
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

        $searchModel = new CourseLectureStaffSearch();
        $searchModel->semester = $semester->semester_id;
        $searchModel->search_staff = $semester->str_search;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('summarybystaff', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'semester' => $semester
        ]);

    }

    public function actionSummaryByCourse()
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
		
		
        $searchModel = new CourseLectureSearch();
		$searchModel->semester = $semester->semester_id;
		$searchModel->search_course = $semester->str_search;
		$searchModel->search_program = $semester->program_search;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('summarybycourse', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'semester' => $semester
        ]);

    }
	
	public function actionByCourse()
    {
		$searchModel = new TeachingCourseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('bycourse', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }
	
	public function actionContactHour(){
		$searchModel = new ContactHourSearch();
		$request = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($request);
		
		if(array_key_exists('per-page',$request) and array_key_exists('page',$request)){
			$perpage = Yii::$app->request->queryParams['per-page'];
			$page = Yii::$app->request->queryParams['page'];
		}else{
			$perpage = '';
			$page = '';
		}
		
		return $this->render('contact-hour', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'perpage' => $perpage,
			'page' => $page,

        ]);
	}
	
	public function actionContactHourForm($course, $page=false, $perpage=false){
		
		$course = $this->findCourse($course);
		$course->scenario = 'contact_hour';
		
		if ($course->load(Yii::$app->request->post())) {
			//echo $course->page .' - '. $course->perpage;
			//die();
			if($course->save()){
				Yii::$app->session->addFlash('success', "Data Updated");
				return $this->redirect(['contact-hour', 'page' => $course->page, 'per-page' => $course->perpage]);
			}
			
		}

		
		return $this->renderAjax('contact-hour-form', [
			'course' => $course,
			'perpage' => $perpage,
			'page' => $page,

        ]);
	}

    public function actionMaximumHour(){

        $model = MaximumHour::find()->all();

       $setting = Setting::findOne(1);
	   $setting->scenario = 'setmax';
	   
	   if ($setting->load(Yii::$app->request->post())) {
		   if($setting->save()){
				Yii::$app->session->addFlash('success', "General Setting Saved.");
			}else{
				$setting->flashError();
			}
	   }
	   
	   
       if(Yii::$app->request->post('Max')){
            $post_max = Yii::$app->request->post('Max');
            
            foreach ($model as $staff) {
                $staff->max_hour = $post_max[$staff->id]['max_hour'];
                $staff->save();
            }
			//buat flash sikit
			Yii::$app->session->addFlash('success', "Staff Custom Maximum Hour Updated");
        }


        return $this->render('maximumhour', [
            'model' => $model,
            'setting' => $setting,

        ]);
        
    }

     public function actionDeleteMaximumHour($id)
    {
        
        $model = $this->findMaximumHour($id);
        
        MaximumHour::deleteAll(['id' => $id]);

        Yii::$app->session->addFlash('success', "Data Updated");
        

        return $this->redirect(['maximum-hour','id'=> $id]);
    }

     public function actionAddStaff()
    {
        $model = new MaximumHour();

         if ($model->load(Yii::$app->request->post())) {

            if($model->staffM){
                $flag = true;
                foreach($model->staffM as $staff){
                    if($this->staffNotExist($staff)){
                        if(!$this->addNew($staff)){
                            $flag = false;
                            exit;
                        }    
                    }
                }
                if($flag){
                    Yii::$app->session->addFlash('success', "Staff Added");
                }
                
                return $this->redirect(['maximum-hour']);
            }

        }

        return $this->render('addstaff', [
            'model' => $model,
        ]);
    }

    protected function staffNotExist($staff){
        $model = MaximumHour::findOne(['staff_id' => $staff]);
        
        if ($model) {
            return false;
        }else{
            return true;
        }
        
    }

    protected function addNew($staff){
        $new = new MaximumHour();
        $new->staff_id = $staff;
        
        if(!$new->save()){
            $new->flashError();
            //Yii::$app->session->addFlash('error', $course);
            return false;
        }
        return true;
    }
	
	public function actionSetting(){
		
		$model = Setting::findOne(1);
		
		if ($model->load(Yii::$app->request->post())) {
			$model->updated_by = Yii::$app->user->identity->id;
			$model->updated_at = new Expression('NOW()'); 
			if($model->save()){
				Yii::$app->session->addFlash('success', "Data Updated");
				return $this->redirect('setting');
			}
		}
		
		return $this->render('setting', [
            'model' => $model,
        ]);
		
	}

    protected function findMaximumHour($id)
    {
        if (($model = MaximumHour::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function findCourse($id)
    {
        if (($model = Course::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
}
