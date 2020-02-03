<?php

namespace backend\modules\esiap\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use backend\modules\esiap\models\CoursePic;
use backend\modules\esiap\models\CourseAccess;
use backend\modules\esiap\models\ProgramPic;
use backend\modules\esiap\models\ProgramAccess;
use yii\filters\AccessControl;
 
/**
 * Default controller for the `esiap` module
 */
class DefaultController extends Controller
{
	   

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
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
       $dataProvider = new ActiveDataProvider([
            'query' => CoursePic::find()->where(['staff_id' => Yii::$app->user->identity->staff->id]),
        ]);
		
		$dataProvider2 = new ActiveDataProvider([
            'query' => CourseAccess::find()->where(['staff_id' => Yii::$app->user->identity->staff->id]),
        ]);
		
		$dataProvider3 = new ActiveDataProvider([
            'query' => ProgramPic::find()->where(['staff_id' => Yii::$app->user->identity->staff->id]),
        ]);
		
		$dataProvider4 = new ActiveDataProvider([
            'query' => ProgramAccess::find()->where(['staff_id' => Yii::$app->user->identity->staff->id]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
			'dataProvider2' => $dataProvider2,
			'dataProvider3' => $dataProvider3,
			'dataProvider4' => $dataProvider4,
        ]);
    }
}
