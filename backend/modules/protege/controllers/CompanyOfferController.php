<?php

namespace backend\modules\protege\controllers;

use Yii;
use backend\modules\protege\models\CompanyOffer;
use backend\modules\protege\models\CompanyOfferSearch;
use backend\modules\protege\models\OfferForm;
use backend\modules\protege\models\Session;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompanyOfferController implements the CRUD actions for CompanyOffer model.
 */
class CompanyOfferController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
        {
            return [
                'access' => [
                    'class' => \yii\filters\AccessControl::className(),
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
     * Lists all CompanyOffer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session = $this->findActiveSession();
        $offer = new OfferForm();
        $offer->session_id = $session->id;
        $offer->is_published = 1;

        if ($offer->load(Yii::$app->request->post())) {
            
            if($offer->added()){
                //Yii::$app->session->addFlash('success', "Companies added");
                return $this->refresh();
            }
            
        }


        $searchModel = new CompanyOfferSearch();
        $searchModel->session_id = $session->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'offer' => $offer,
            'session' => $session
        ]);
    }

    /**
     * Displays a single CompanyOffer model.
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
     * Creates a new CompanyOffer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CompanyOffer();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CompanyOffer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->updated_at = time();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', "Data Updated");
            return $this->redirect(['index', 'session' => $model->session_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CompanyOffer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        $session = $model->session_id;
        try {
            $model->delete();
            Yii::$app->session->addFlash('success', "Company offer Deleted");
        } catch(\yii\db\IntegrityException $e) {
            Yii::$app->session->addFlash('error', "Could not delete this offer. Registration already exist.");
            
            
        }
        return $this->redirect(['index', 'session' => $session]);
    }

    /**
     * Finds the CompanyOffer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CompanyOffer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CompanyOffer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findSession($id)
    {
        if (($model = Session::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findActiveSession()
    {
        if (($model = Session::findOne(['is_active' => 1])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
