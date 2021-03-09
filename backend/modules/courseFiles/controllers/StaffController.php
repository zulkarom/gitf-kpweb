<?php

namespace backend\modules\courseFiles\controllers;

use Yii;
use yii\db\Expression;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use backend\models\Semester;
use common\models\UploadFile;
use yii\helpers\Json;
use backend\modules\teachingLoad\models\StaffInvolved;


class StaffController extends Controller
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
	
    }

 
	
	public function actionUploadFile($attr, $id){

        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $model->file_controller = 'staff';
		
		$path = 'course-files/'.$model->semester_id.'/'.$model->staff->staff_no ;
		$model->prg_timetable = 1;

        return UploadFile::upload($model, $attr, 'updated_at', $path);

    }
	
	protected function findModel($id)
    {
        if (($model = StaffInvolved::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

	protected function clean($string){
		$allowed = ['timetable'];
        if(in_array($string,$allowed)){
            return $string;
        }
        throw new NotFoundHttpException('Invalid Attribute');
    }

	public function actionDeleteFile($attr, $id)
    {
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $attr_db = $attr . '_file';
        
        $file = Yii::getAlias('@upload/' . $model->{$attr_db});
        
        $model->scenario = $attr . '_delete';
        $model->{$attr_db} = '';
		$model->prg_timetable = 0;
        $model->updated_at = new Expression('NOW()');
        if($model->save()){
            if (is_file($file)) {
                unlink($file);
                
            }
            
            return Json::encode([
                        'good' => 1,
                    ]);
        }else{
            return Json::encode([
                        'errors' => $model->getErrors(),
                    ]);
        }
        


    }

	public function actionDownloadFile($attr, $id, $identity = true){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $filename = strtoupper($attr) . ' ' . Yii::$app->user->identity->fullname;
        
        
        
        UploadFile::download($model, $attr, $filename);
    }



    
}
