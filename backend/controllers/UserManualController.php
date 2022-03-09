<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;


/**
 * Site controller
 */
class UserManualController extends Controller
{

    public $layout = 'main_guide';

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
		]);
    }
	
	
	
	
}
