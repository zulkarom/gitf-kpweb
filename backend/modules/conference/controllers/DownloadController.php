<?php

namespace backend\modules\conference\controllers;

use Yii;
use backend\modules\conference\models\Conference;
use backend\modules\conference\models\ConfDownload;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\modules\conference\models\UploadDownloadFile as UploadFile;
use common\models\Model;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

/**
 * ConferenceController implements the CRUD actions for Conference model.
 */
class DownloadController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all Conference models.
     * @return mixed
     */
    public function actionIndex($conf)
    {
		$model = $this->findConference($conf);
		$downloads = $model->confDownloads;
		
		if(Yii::$app->request->post()){
            if(Yii::$app->request->validateCsrfToken()){
                $post = Yii::$app->request->post('ConfDownload');
				if($post){
					foreach(array_filter($post) as $pdata){
						$id = $pdata["id"];
						$d = $this->findModel($id);
						$d->download_name = $pdata['download_name'];
						$d->save();
					}
					return $this->redirect(['index', 'conf' => $conf]);
				}
				$model->document_updated_at = new Expression('NOW()');
				$model->save();
            }
            
        }

	
		return $this->render('download', [
            'model' => $model,
            'downloads' => $downloads
        ]);
    }


    /**
     * Updates an existing Conference model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($conf)
    {
        $model = $this->findModel($conf);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['site/index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
	
	public function actionCreate($conf){
		$model = new ConfDownload;
		$model->scenario = 'create';
		$model->conf_id = $conf;
		if($model->save()){
			return $this->redirect(['index', 'conf' => $conf]);
		}
	}
	
    

    /**
     * Finds the Conference model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Conference the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ConfDownload::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function findConference($id)
    {
        if (($model = Conference::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


	public function actionUploadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $model->file_controller = 'download';

        return UploadFile::upload($model, $attr, 'updated_at');

    }

	protected function clean($string){
        $allowed = ['download'];
        
        foreach($allowed as $a){
            if($string == $a){
                return $a;
            }
        }
        
        throw new NotFoundHttpException('Invalid Attribute');

    }
	
	public function actionDeleteRow($id, $conf){
		$model = $this->findModel($id);
		if($model->delete()){
			$this->redirect(['index', 'conf' => $conf]);
		}
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
