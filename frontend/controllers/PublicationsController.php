<?php

namespace frontend\controllers;

use Yii;
use backend\modules\proceedings\models\Proceeding;
use backend\modules\proceedings\models\Paper;
use backend\modules\proceedings\models\ProceedingSearch;
use frontend\models\PaperSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\UploadFile;

/**
 * ProceedingController implements the CRUD actions for Proceeding model.
 */
class PublicationsController extends Controller
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
     * Lists all Proceeding models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProceedingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	 public function actionPaper($purl)
    {
        $searchModel = new PaperSearch();
		$searchModel->url = $purl;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('paper', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'proceeding' => $this->findModel($purl)
        ]);
    }
	
	public function actionDownloadFile($id){
        $attr = 'paper';
        $model = $this->findPaper($id);
        $filename = strtoupper($attr) . '_' . $model->paper_no;

        UploadFile::download($model, $attr, $filename);
    }
	
	public function actionDownloadImage($purl){
        $attr = 'image';
        $model = $this->findModel($purl);
        $filename = strtoupper($attr);

        UploadFile::download($model, $attr, $filename);
    }

    /**
     * Displays a single Proceeding model.
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
     * Creates a new Proceeding model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Proceeding();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Proceeding model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Proceeding model.
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
     * Finds the Proceeding model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Proceeding the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($purl)
    {
        if (($model = Proceeding::findOne(['proc_url' => $purl])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not existx.');
    }
	
	protected function findPaper($id)
    {
        if (($model = Paper::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
