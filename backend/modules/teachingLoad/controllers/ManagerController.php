<?php

namespace backend\modules\teachingLoad\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use backend\modules\teachingLoad\models\TeachingStaffSearch;

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
	
}
