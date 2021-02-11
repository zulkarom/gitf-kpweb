<?php

namespace backend\modules\staff\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\staff\models\Staff;
use backend\modules\staff\models\StaffMainPosition;
use backend\models\Department;
use backend\modules\esiap\models\Program;

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

	public function actionMainPosition(){
		
		// Dekan
		$model = StaffMainPosition::find()->all();
		if(Yii::$app->request->post('Main')){
            $post_main = Yii::$app->request->post('Main');	
            foreach ($model as $pos) {

            	$pos->staff_id = $post_main[$pos->id];
            	$pos->save();
            }
           
        }

        // Ketua Jabatan
        $modelDepartment = Department::find()->all();
		if(Yii::$app->request->post('Department')){
            $post_depart = Yii::$app->request->post('Department');	
            foreach ($modelDepartment as $dep) {

            	$dep->head_dep = $post_depart[$dep->id];
            	$dep->save();
            }
            
           
        }

        // Ketua Program
        $modelProgram = Program::find()->where(['faculty_id' => 1])->all();
		if(Yii::$app->request->post('Program')){
            $post_program = Yii::$app->request->post('Program');	
            foreach ($modelProgram as $pro) {

            	$pro->head_program = $post_program[$pro->id];
            	$pro->save();
            }
            Yii::$app->session->addFlash('success', "Data Saved");
        }

        
        return $this->render('main-position',[
			'model' => $model,
			'modelProgram' => $modelProgram,
			'modelDepartment' => $modelDepartment,
			
		]);
	}


}
