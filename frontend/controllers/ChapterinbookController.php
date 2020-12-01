<?php

namespace frontend\controllers;

use Yii;
use backend\modules\chapterinbook\models\Chapterinbook;
use backend\modules\chapterinbook\models\Paper;
use backend\modules\chapterinbook\models\ChapterinbookSearch;
use frontend\models\PaperChapterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\UploadFile;

/**
 * ProceedingController implements the CRUD actions for Proceeding model.
 */
class ChapterinbookController extends Controller
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
        $searchModel = new ChapterinbookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	 public function actionPaper($purl)
    {
        $searchModel = new PaperChapterSearch();
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


    protected function findModel($purl)
    {
        if (($model = Chapterinbook::findOne(['chap_url' => $purl])) !== null) {
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
