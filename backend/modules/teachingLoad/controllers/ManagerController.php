<?php

namespace backend\modules\teachingLoad\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\modules\teachingLoad\models\TeachingStaffSearch;
use backend\modules\teachingLoad\models\TeachingCourseSearch;
use backend\modules\teachingLoad\models\Setting;
use yii\db\Expression;

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
	
	public function actionByCourse()
    {
		$searchModel = new TeachingCourseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('bycourse', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
