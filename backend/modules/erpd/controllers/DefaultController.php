<?php

namespace backend\modules\erpd\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
/**
 * Default controller for the `erpd` module
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
        return $this->render('index');
    }
	

}
