<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;



/**
 * Site controller
 */
class EnController extends Controller
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

		
		return $this->redirect(['site/index']);
        
    }
	


	
	
}
