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
class AcademicController extends Controller
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
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
		return $this->render('undergraduate');
        
    }
	
	public function actionPostGraduate()
    {
		return $this->render('postgraduate');
        
    }
	
	
}
