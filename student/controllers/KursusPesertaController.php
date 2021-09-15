<?php

namespace student\controllers;

use Yii;
use backend\modules\postgrad\models\KursusAnjur;
use backend\modules\postgrad\models\KursusPeserta;
use backend\modules\postgrad\models\KursusKategori;
use student\models\KursusPesertaSearch;
use student\models\KursusAnjurSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Expression;
/**
 * KursusPesertaController implements the CRUD actions for KursusPeserta model.
 */
class KursusPesertaController extends Controller
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
     * Lists all KursusPeserta models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KursusPesertaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single KursusPeserta model.
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
     * Creates a new KursusPeserta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new KursusKategori();

        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['anjur', 'cid' => $model->kategori]);
        }


        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    public function actionAnjur($cid){

        $searchModel = new KursusAnjurSearch();
        $searchModel->kategori = $cid;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('anjur', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAnjurView($id)
    {
        $model = KursusAnjur::findOne($id);

        return $this->render('anjur_view', [
            'model' => $model,
        ]);
    }

    public function actionAnjurRegister($id){

        $anjur = KursusAnjur::findOne($id);
        $model = new KursusPeserta();

        $checkKursus = KursusPeserta::find()
        ->where(['user_id' => Yii::$app->user->identity->id])
        ->andWhere(['anjur_id' => $anjur->id, 'user_type' => 4])
        ->one();

        if($checkKursus){
            Yii::$app->session->addFlash('warning', "Kursus yang dipilih telah didaftarkan. Sila pilih kursus lain.");
            return $this->redirect(['anjur-view', 'id' => $id]);

        }else if($model->getCountPeserta($anjur->id) >= $anjur->capacity){
            Yii::$app->session->addFlash('warning', "Kapasiti kursus penuh. Sila pilih kursus lain.");
            return $this->redirect(['anjur-view', 'id' => $id]);

        }else{
            $model->anjur_id = $anjur->id;
            $model->user_type = 4;
            $model->user_id = Yii::$app->user->identity->id;
            $model->status = 10;
            $model->submitted_at = new Expression('NOW()');

            if($model->save()){
                Yii::$app->session->addFlash('success', "Daftar Kursus Berjaya");
                return $this->redirect(['index']);
                // return $this->redirect(['anjur', 'cid' => $anjur->kursus->kategori_id]);
            }else{
                $model->flashError();
            }
        }
    }

    /**
     * Updates an existing KursusPeserta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if($model->save()){
            Yii::$app->session->addFlash('success', "Data Updated");
            return $this->redirect(['view', 'id' => $model->id]);
        }else{
            $model->flashError();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing KursusPeserta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($model->delete()){
            Yii::$app->session->addFlash('danger', "Data Deleted");
        }else{
            $model->flashError();
        }

        return $this->redirect(['index']);
    }

    public function actionGetDetails($id){

        $anjur = KursusAnjur::find()->where(['id' => $id])->one();
        if($anjur)
        {
            $details = array("date_start" => date('d F Y', strtotime($anjur->date_start)), 
                                "date_end" =>date('d F Y', strtotime($anjur->date_end)), 
                                "capacity" =>$anjur->capacity, 
                                "location" =>$anjur->location);
            $result = json_encode($details);
            return $result;
        }
        
    }

    /**
     * Finds the KursusPeserta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return KursusPeserta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = KursusPeserta::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
