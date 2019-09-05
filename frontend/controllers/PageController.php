<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\ArchiveSearch;
use backend\modules\jeb\models\Journal;



/**
 * Page controller
 */
class PageController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        
    }
	
	/**
     * Committees.
     *
     * @return mixed
     */
    public function actionCommittee()
    {
		return $this->render('committe');
        
    }
	
	public function actionSubmissionGuideline(){
		return $this->render('submission-guideline');
	}
	
	public function actionEditorialPolicy(){
		return $this->render('editorial-policy');
	}
	
	public function actionEthicalGuideline(){
		return $this->render('ethical-guideline');
	}
	
	public function actionJournal($id){
		$journal = $this->findJournal($id);
		return $this->render('journal',[
			'journal' => $journal
		]);
	}
	
	  /**
     * Finds the Journal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Journal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findJournal($id)
    {
        if (($model = Journal::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionArchive(){
		$searchModel = new ArchiveSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('archive', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}
	
	
	
	
}
