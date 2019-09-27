<?php

namespace backend\modules\staff\controllers;

use yii\web\Controller;
use backend\modules\staff\models\Staff;

/**
 * Default controller for the `staff` module
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
	
	public function actionRenameFileGsdf(){
		$staff = Staff::find()->all();
		foreach($staff as $s){
			$img = $s->image_file;
			$s->image_file = 'profile/' . $img;
			$s->save();
		}
		echo 'done';
	}
}
