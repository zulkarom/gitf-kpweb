<?php

namespace backend\modules\staff\controllers;

use Yii;
use backend\modules\staff\models\Staff;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\User;
use common\models\Upload;
use common\models\UploadFile;
use yii\helpers\Json;
use yii\db\Expression;
use yii\filters\AccessControl;

/**
 * StaffController implements the CRUD actions for Staff model.
 */
class ProfileController extends Controller
{
    /**
     * @inheritdoc
     */

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
     * Lists all Staff models.
     * @return mixed
     */
    public function actionIndex()
    {
		$model = $this->findModel();

        if ($model->load(Yii::$app->request->post())) {
			
			if($model->save()){
				Yii::$app->session->addFlash('success', "Data Updated");
				return $this->redirect(['index']);
			}
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Staff model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Staff the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel()
    {
        if (($model = Staff::findOne(Yii::$app->user->identity->staff->id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	
	public function actionImage(){
		$id = Yii::$app->user->identity->id;
        $model = $this->findModel(['user_id' => $id]);
		
		if($model->image_file){
			$file = Yii::getAlias('@upload/profile/' . $model->image_file);
		}else{
			$file = Yii::getAlias('@img') . '/user.png';
		}
        
		
			if (file_exists($file)) {
			
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			
			$filename = Yii::$app->user->identity->fullname . '.' . $ext ;
			
			Upload::sendFile($file, $filename, $ext);
			
			}
		
	}

	public function actionUploadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $model->file_controller = 'staff';

        return UploadFile::upload($model, $attr, 'updated_at');

    }

	protected function clean($string){
        $allowed = ['image'];
        
        foreach($allowed as $a){
            if($string == $a){
                return $a;
            }
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
