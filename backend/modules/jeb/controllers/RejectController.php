<?php

namespace backend\modules\jeb\controllers;

use Yii;
use backend\modules\jeb\models\Article;
use backend\modules\jeb\models\RejectSearch;
use backend\modules\jeb\models\WithdrawSearch;
use backend\modules\jeb\models\ArticleStatus;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use raoul2000\workflow\validation\WorkflowScenario;
use common\models\Model;
use yii\filters\AccessControl;

class RejectController extends \yii\web\Controller
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

        $searchModel = new RejectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionWithdraw()
    {

        $searchModel = new WithdrawSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('withdraw', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	private function withdraw($id)
    {
		$model = $this->findModel($id);
		
		$model->scenario = WorkflowScenario::enterStatus('ta-withdraw');
		
			
        $model->withdraw_at = new Expression('NOW()');
		$model->withdraw_by = Yii::$app->user->identity->id;
		
		$model->sendToStatus('ta-withdraw');
		
        if($model->save()){
			$model->sendEmail();
            Yii::$app->session->addFlash('success', "The manuscript has been successfully withdrew.");
			
            
        }else{

			if($model->getErrors()){
				foreach($model->getErrors() as $error){
					if($error){
						foreach($error as $e){
							Yii::$app->session->addFlash('error', $e);
						}
					}
				}
			}
		}
		

		
		
		return $this->redirect('withdraw');
    }
	
	public function actionViewWithdraw($id)
    {
	
	$model = $this->findModel($id);
	
		
		if ($model->load(Yii::$app->request->post())) {
			
			$wfaction = Yii::$app->request->post('wfaction');
			
		
			
			if($wfaction == 'allow'){
				$model->scenario = WorkflowScenario::enterStatus('ta-withdraw');
				$model->withdraw_at = new Expression('NOW()');
				$model->withdraw_by = Yii::$app->user->identity->id;
				$model->sendToStatus('ta-withdraw');
				
				if($model->save()){
					$model->sendEmail();
					Yii::$app->session->addFlash('success', "The manuscript has been successfully withdrew.");
					return $this->redirect(['reject/withdraw']);
					
				}
			}else{
				
				$wf_arr = explode('/', $model->withdraw_at_status);
				$sendto = $wf_arr[1];
				$model->scenario = WorkflowScenario::enterStatus($sendto);
				$model->sendToStatus($sendto);
				
				if($model->save()){
					Yii::$app->session->addFlash('success', "The manuscript has been successfully restored to previous status.");
					return $this->redirect(['withdraw']);
					
				}
			}
			
			
		}
		return $this->render('view-withdraw', [
            'model' => $model,
        ]);
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
	

}
