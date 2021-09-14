<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use backend\modules\postgrad\models\KursusKategori;
use backend\modules\postgrad\models\KursusKategoriSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\db\Expression;
use backend\modules\postgrad\models\Kursus;
/**
 * KursusKategoriController implements the CRUD actions for KursusKategori model.
 */
class KursusKategoriController extends Controller
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
     * Lists all KursusKategori models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KursusKategoriSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single KursusKategori model.
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
     * Creates a new KursusKategori model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new KursusKategori();

        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = new Expression('NOW()');
            
            if($model->save()){
                Yii::$app->session->addFlash('success', "Kursus Kategori Added");
                return $this->redirect('index');
            }
            
        }


        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing KursusKategori model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->updated_at = new Expression('NOW()');
            
            if($model->save()){
                Yii::$app->session->addFlash('success', "Kursus Kategori Updated");
                return $this->redirect('index');
            }
            
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing KursusKategori model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionDeleteKursus($id, $cat)
    {
        $this->findKursus($id)->delete();
        
        return $this->redirect(['view', 'id' => $cat]);
    }

    /**
     * Finds the KursusKategori model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return KursusKategori the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = KursusKategori::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findKursus($id)
    {
        if (($model = Kursus::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
