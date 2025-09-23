<?php

namespace backend\modules\postgrad\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Default controller for the `postgrad` module
 * https://drive.google.com/drive/folders/1UEusfaryAjgms_aLlxiTYtt84ztJa0Og
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
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
}
