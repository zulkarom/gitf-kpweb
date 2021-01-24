<?php

namespace frontend\controllers;

use Yii;
use backend\modules\aduan\models\Aduan;
use backend\modules\aduan\models\Guideline;
use backend\modules\aduan\models\AduanAction;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\db\Expression;

/**
 * AduanController implements the CRUD actions for Aduan model.
 */
class AduanController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Aduan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Aduan();
		$panduan = Guideline::find()->all();
		$model->scenario = 'frontend';
		
		$kemaskini = new Aduan();
		$kemaskini->scenario = 'kemaskini';

        if ($model->load(Yii::$app->request->post())) {
			$random = Yii::$app->security->generateRandomString();
			$model->token = $random;
			$code = rand(1000,9999);
			$model->email_code = $code;
			$model->progress_id = 1;
            $model->created_at = new Expression('NOW()'); 
			$model->updated_at = new Expression('NOW()'); 
			if($model->save()){
				
				if(!$model->upload()){
					Yii::$app->session->addFlash('error', "Fail lampiran gagal dimuatnaik");
				}
				
				$model->sendCode();
				
				return $this->redirect(['verify', 'id' => $model->id, 't' => $random]);
				
			}else{
				$model->flashError();
			}

            
        }

        return $this->render('index', [
            'model' => $model,
			'kemaskini' => $kemaskini,
			'panduan' => $panduan
        ]);
    }
	
	public function actionVerify($id, $t)
    {
        $model = $this->findModel($id, $t);
		$model->scenario = 'verify';
		
		
        if ($model->load(Yii::$app->request->post())) {
			if($model->email_code == $model->post_code){
				$model->progress_id = 20;
				if($model->save()){
					$model->sendEmail();
					$model->sendEmailAdmin();
					Yii::$app->session->addFlash('success', "Aduan telah berjaya dihantar. Nombor aduan anda (Aduan#) anda adalah <b>".$model->id."</b>. Sila simpan nombor ini untuk tujuan rujukan masa hadapan.");
					return $this->redirect(['index']);
				
				}else{
					$model->flashError();
				}
			}else{
				Yii::$app->session->addFlash('error', "Kod verifikasi tidak tepat!");
			}
			
        }

        return $this->render('verify', [
            'model' => $model,
			
        ]);
    }

    public function actionCheck()
    {
		$model = new Aduan;
		
        if ($model->load(Yii::$app->request->post())) {
			
            $aduan_id = $model->id;
            $email = $model->email;
            
            $modelAduan =  Aduan::find()->where(['id' => $aduan_id, 'email' => $email])->one();
			
			if($modelAduan){
				$token = $modelAduan->token;
				return $this->redirect(['kemaskini', 'id' =>  $modelAduan->id ,'t' => $token]);
			}else{
				Yii::$app->session->addFlash('error', "Maaf, aduan tidak dijumpai, pastikan maklumat email dan nombor aduan yang diisi tepat.");
				return $this->redirect(['index']);
			}
        } 
    }


    /**
     * Updates an existing Aduan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionKemaskini($id, $t)
    {
        $model = $this->findModel($id, $t);
		
		$action =  AduanAction::find()->where(['aduan_id' => $id])->all();
        $actionCreate = new AduanAction();

        if ($actionCreate->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post())) {
            $actionCreate->aduan_id = $id;
            $actionCreate->created_at = new Expression('NOW()'); 
            $actionCreate->created_by = 0;
			$actionCreate->progress_id = $model->progress_id;
            $actionCreate->save();
            $model->save();
            return $this->refresh();
        }

        return $this->render('update', [
            'model' => $model,
			'action' => $action,
            'actionCreate' => $actionCreate,
        ]);
    }

    /**
     * Deletes an existing Aduan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /* 
	
	public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $oldfile = $model->upload_url;
        unlink(Yii::$app->basePath . '/web/upload/' . $oldfile);
        $model->delete();

        return $this->redirect(['index']);
    } 
	
	*/
    /**
     * Finds the Aduan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Aduan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $t)
    {
        if (($model = Aduan::findOne(['id' => $id, 'token' => $t])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionDownload($id){
        $model = $this->findModel($id);
        $model->download();
    }
}
