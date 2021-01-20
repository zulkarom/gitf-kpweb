<?php

namespace frontend\controllers;

use Yii;
use backend\modules\aduan\models\Aduan;
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
        $dataProvider = new ActiveDataProvider([
            'query' => Aduan::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Aduan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Aduan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Aduan();

        if ($model->load(Yii::$app->request->post())) {

            $uploadFile = UploadedFile::getInstance($model,'upload_url');

            if(!$uploadFile){
                $model->upload_url = $uploadFile->name; 
                $uploadFile->saveAs(Yii::$app->basePath . '/web/upload/' . $uploadFile->name);
                
                $model->progress_id = 1;
                $model->created_at = new Expression('NOW()'); 

                $model->save(false);
            }else{
                $model->progress_id = 1;
                $model->created_at = new Expression('NOW()'); 

                $model->save(false);
            }
            

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCheck()
    {
        $model = new Aduan();
        $modelAction =  AduanAction::find()->where(['aduan_id' => $id])->all();

        if ($model->load(Yii::$app->request->post())) {


        }

        return $this->render('check', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing Aduan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $oldfile = $model->upload_url;
            if($oldfile != ""){
                unlink(Yii::$app->basePath . '/web/upload/' . $oldfile);
            }

            $uploadFile = UploadedFile::getInstance($model,'upload_url');
            
            $model->upload_url = $uploadFile->name; 

            $model->save(false);

            $uploadFile->saveAs(Yii::$app->basePath . '/web/upload/' . $uploadFile->name);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Aduan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $oldfile = $model->upload_url;
        unlink(Yii::$app->basePath . '/web/upload/' . $oldfile);
        $model->delete();

        return $this->redirect(['index']);
    }
    /**
     * Finds the Aduan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Aduan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Aduan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
