<?php

namespace backend\modules\jeb\controllers;

use Yii;
use common\models\User;
use backend\modules\jeb\models\UserSearch;
use backend\modules\jeb\models\UserScope;
use yii\helpers\ArrayHelper;



class UserController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
		$model = $this->findModel($id);

		$scopes = ArrayHelper::map($model->userScopes,'id', 'scope_id');
		
		if ($model->load(Yii::$app->request->post())) {
			$curr = $model->user_fields;
			
			$count_curr = $curr ? count($curr) : 0;
			$count_scopes = $scopes ? count($scopes) : 0;
			//ok check the current setting
			//scope id
			//if it more than ori than add
			if($count_curr > $count_scopes){
				//let say curr 4 ori 2
				//add 4-2 = 2
				$add = $count_curr - $count_scopes;
				$this->addScope($id, $add);
			}else if($count_curr < $count_scopes){
				//let say curr 2 ori 4
				//rmv 4 - 2 = 2
				$rmv = $count_scopes - $count_curr;
				$this->rmvScope($id, $rmv);
			}
			
			$new = UserScope::find()
			->where(['user_id' => $id])
			->all();
			if($new){
				$i = 0;
				foreach($new as $sc){
					$sc->scope_id = $curr[$i];
					$sc->save();
					
				$i++;
				}
			}
			
			return $this->redirect('index');
			
		}
        return $this->render('view', [
            'model' => $model,
        ]);
    }
	
	private function addScope($user, $count){
		for($i=1;$i<=$count;$i++){
			$scope = new UserScope;
			$scope->user_id = $user;
			$scope->scope_id = 0;
			$scope->save();
		}
	}
	
	private function rmvScope($user, $count){
		$ids = UserScope::find()
		->where(['user_id' => $user])
		->orderBy('id DESC')->limit($count)->all();
		if($ids){
			foreach($ids as $id){
				$id->delete();
			}
		}
		//->deleteAll();
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
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	

}
