<?php

namespace backend\modules\aduan\controllers;

use Yii;
use backend\modules\aduan\models\AduanAction;
use backend\modules\aduan\models\Aduan;
use backend\modules\aduan\models\AduanActionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;

/**
 * AduanActionController implements the CRUD actions for AduanAction model.
 */
class AduanActionController extends Controller
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
     * Lists all AduanAction models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AduanActionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AduanAction model.
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
     * Creates a new AduanAction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new AduanAction();

        $aduan = Aduan::find()
        ->where(['id' => $id])
        ->one();

        if ($model->load(Yii::$app->request->post())) {
            $model->aduan_id = $id;
            $model->created_at = new Expression('NOW()'); 
            $model->created_by = $aduan->nric;
            $model->save();
            return $this->redirect(['/aduan/aduan/view', 'id' => $id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AduanAction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id,$sid)
    {
        $model = $this->findModel($id);

        $aduan = Aduan::find()
        ->where(['id' => $sid])
        ->one();

        if ($model->load(Yii::$app->request->post()) ) {

             $model->updated_at = new Expression('NOW()');
             $model->save();

            return $this->redirect(['/aduan/aduan/view', 'id' => $aduan->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AduanAction model.
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

    /**
     * Finds the AduanAction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AduanAction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AduanAction::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
