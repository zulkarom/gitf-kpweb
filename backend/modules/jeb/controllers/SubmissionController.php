<?php

namespace backend\modules\jeb\controllers;

use Yii;
use backend\modules\jeb\models\Article;
use backend\modules\jeb\models\SubmissionSearch;
use backend\modules\jeb\models\ArticleReviewer;
use backend\modules\jeb\models\UserScope;
use backend\modules\jeb\models\Setting;
use common\models\Upload;
use yii\db\Expression;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use raoul2000\workflow\validation\WorkflowScenario;
use common\models\Model;
use common\models\UserToken;
use yii\filters\AccessControl;

class SubmissionController extends \yii\web\Controller
{
	

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

    public function actionIndex()
    {

        $searchModel = new SubmissionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionSubmitManuscript()
    {
		$token = new UserToken;
		$token->setToken();
		$user = Yii::$app->user->identity->id;
		if($token->save()){
			return $this->redirect(Yii::$app->urlManager->createUrl(Setting::$frontUrl .'site/staff-login?id='.$user.'&redirect=submission&action=create&token='.$token->token));
		}
    }
	
	public function actionCorrection($id)
    {
		$token = new UserToken;
		$token->setToken();
		$user = Yii::$app->user->identity->id;
		if($token->save()){
			return $this->redirect(Yii::$app->urlManager->createUrl(Setting::$frontUrl . 'site/staff-login?id='.$user.'&redirect=submission&action=correction&article='.$id.'&token='.$token->token));
		}
    }
	
	public function actionFinalise($id)
    {
		$token = new UserToken;
		$token->setToken();
		$user = Yii::$app->user->identity->id;
		if($token->save()){
			return $this->redirect(Yii::$app->urlManager->createUrl(Setting::$frontUrl .'site/staff-login?id='.$user.'&redirect=submission&action=finalise&article='.$id.'&token='.$token->token));
		}
    }
	
	
	
	
	
	public function actionUpload($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $model->file_controller = 'submission';

        return Upload::upload($model, $attr, 'updated_at');

    }
	
	/**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	public function actionDownload($attr, $id, $identity = true){
		$attr = $this->clean($attr);
        $model = $this->findModel($id);
		$filename = strtoupper($attr);
		Upload::download($model, $attr, $filename);
	}
	
	public function actionDelete($attr, $id)
	{
		$attr = $this->clean($attr);
        $model = $this->findModel($id);
		$attr_db = $attr . '_file';
		
		$file = Yii::getAlias('@upload/' . $model->{$attr_db});
		
		$model->scenario = $attr . '_delete';
		$model->{$attr_db} = '';
		$model->updated_at = new Expression('NOW()');
		if($model->save()){
			if (is_file($file)) {
				unlink($file);
				
			}
			
			return Json::encode([
						'good' => 1,
					]);
		}else{
			return Json::encode([
						'errors' => $model->getErrors(),
					]);
		}
		

	}
	
	protected function clean($string){
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
	}
	
	public function actionListReviewers($scope, $inex){
		$reviewers = UserScope::listReviewers($scope, $inex);
		
		return Json::encode($reviewers);
		
	}

}
