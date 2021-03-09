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
use backend\modules\courseFiles\models\CourseFilesSearch;

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

        if(Yii::$app->getRequest()->getQueryParam('SemesterForm')){
            $sem = Yii::$app->getRequest()->getQueryParam('SemesterForm');
            $semester->semester_id = $sem['semester_id'];
            $semester->str_search = $sem['str_search'];
        }else{
            $semester->semester_id = Semester::getCurrentSemester()->id;
        }

        $searchModel = new CourseFilesSearch();
        $searchModel->semester = $semester->semester_id;
        $searchModel->search_course = $semester->str_search;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'semester' => $semester
        ]);
    }

    public function actionCourseFilesView($id, $revert=false)
    {
        $model = new Checklist();
        $modelOffer = $this->findOffered($id);  
		$modelOffer->setOverallProgress();
		if($revert){
			$modelOffer->status = 0;
		}
		$modelOffer->save();
        return $this->render('course-files-view', [
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
}
