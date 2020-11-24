<?php

namespace backend\modules\teachingLoad\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\modules\teachingLoad\models\TeachingStaffSearch;
use backend\modules\teachingLoad\models\TeachingCourseSearch;
use backend\modules\teachingLoad\models\CourseLectureStaffSearch;
use backend\modules\teachingLoad\models\CourseLectureSearch;
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
        $semester->action = ['/teaching-load/manager/summary-by-staff'];
        
        if(Yii::$app->getRequest()->getQueryParam('SemesterForm')){
            $sem = Yii::$app->getRequest()->getQueryParam('SemesterForm');
            $semester->semester_id = $sem['semester_id'];
            $semester->str_search = $sem['str_search'];
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
		$semester->action = ['/teaching-load/manager/summary-by-course'];
		
		if(Yii::$app->getRequest()->getQueryParam('SemesterForm')){
			$sem = Yii::$app->getRequest()->getQueryParam('SemesterForm');
			$semester->semester_id = $sem['semester_id'];
			$semester->str_search = $sem['str_search'];
		}else{
			$semester->semester_id = Semester::getCurrentSemester()->id;
		}
		
		
        $searchModel = new CourseLectureSearch();
		$searchModel->semester = $semester->semester_id;
		$searchModel->search_course = $semester->str_search;
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

    public function actionMaximumHour(){

        $model = new MaximumHour();
        
        return $this->render('maximumhour', [
            'model' => $model,
        ]);
        
    }

     public function actionAddStaff()
    {
        $model = new MaximumHour();

        // if ($model->load(Yii::$app->request->post())) {
        //     if($model->courses){
        //         $flag = true;
        //         foreach($model->courses as $course){
        //             if($this->offeredNotExist($model->semester_id, $course)){
        //                 if(!$this->addNew($model->semester_id, $course)){
        //                     $flag = false;
        //                     exit;
        //                 }
        //             }
                    
        //         }
        //         if($flag){
        //             Yii::$app->session->addFlash('success', "Courses Offered Added");
        //         }
                
        //         return $this->redirect(['index']);
        //     }

        // }

        return $this->render('addstaff', [
            'model' => $model,
        ]);
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
	
}
