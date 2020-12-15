<?php

namespace backend\modules\teachingLoad\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\filters\AccessControl;

class AppointmentLetterController extends Controller
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

}