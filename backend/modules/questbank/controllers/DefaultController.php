<?php

namespace backend\modules\questbank\controllers;

use yii\web\Controller;

/**
 * Default controller for the `questbank` module
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
	
	public function actionOverview($course){
		return $this->render('overview');
	}
}
