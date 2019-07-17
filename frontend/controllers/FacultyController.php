<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * Site controller
 */
class FacultyController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
           
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
		return $this->render('about-faculty');
        
    }
	
	public function actionDeanDesk()
    {
		return $this->render('dean-desk');
        
    }
	
	
}
