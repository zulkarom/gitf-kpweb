<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use common\models\Upload;
use backend\modules\website\models\Event;
use frontend\models\EventSearch;
use frontend\models\NewsSearch;


/**
 * Site controller
 */
class EventController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
           
        ];
    }


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
	
        
    }
	
	public function actionView($id)
    {
		$event = $this->findModel($id);
		return $this->render('view', [
			'event' => $event
		]);
        
    }
	
	public function actionNews($id)
    {
		$event = $this->findModel($id);
		return $this->render('news', [
			'event' => $event
		]);
        
    }
	
	public function actionNewsList()
    {
		$searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('news-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        
    }
	
	public function actionUpcoming()
    {
		$searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        
    }
	
	public function actionLatestNews()
    {
		$searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        
    }

	
	protected function clean($string){
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }
	
	public function actionDownload($attr, $id, $identity = true){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $filename = strtoupper($attr) ;
        
        
        
        Upload::download($model, $attr, $filename);
    }
	
	/**
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	

	
	
}
