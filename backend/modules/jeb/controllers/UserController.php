<?php

namespace backend\modules\jeb\controllers;

use Yii;
use common\models\User;
use common\models\AuthAssignment;
use common\models\AuthItem;
use backend\modules\jeb\models\UserSearch;
use backend\modules\jeb\models\UserScope;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use backend\modules\jeb\models\Associate;



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
		
		if ($model->load(Yii::$app->request->post())) {
			
			$this->processRole($model);
			
			$this->processScope($model);
			
			return $this->redirect('index');
			
		}
        return $this->render('view', [
            'model' => $model,
        ]);
    }
	
	private function processRole($model){
		$id = $model->id;
		$roles = ArrayHelper::map($model->jebAuthAssignments, 'item_name', 'item_name');
		$curr = $model->user_roles;
		//print_r($curr);die();
		$count_curr = $curr ? count($curr) : 0;
		$count_roles = $roles ? count($roles) : 0;
		if($count_curr > $count_roles){
			$add = $count_curr - $count_roles;
			$new_array = [];
				foreach($curr as $c){
					if(!in_array($c, $roles)){
						$new_array[] = $c;
					}
				}
			$this->addRole($id, $new_array);
		}else if($count_curr < $count_roles){
			$rmv = $count_roles - $count_curr;
			$this->rmvRole($id, $rmv);
		}
		
		//no need to sort
		/* $new = AuthAssignment::find()->where(['like', 'item_name', 'jeb-'])->andWhere(['user_id' => $id])->all();
		//echo $id;echo count($curr);echo '-';echo count($new);die();
		if($new){
			$i = 0;
			foreach($new as $sc){
				$sc->item_name = $curr[$i];
				$sc->save();
			$i++;
			}
		} */
		return true;
	}
	
	private function processScope($model){
		$id = $model->id;
		$scopes = ArrayHelper::map($model->userScopes, 'id', 'scope_id');
		$curr = $model->user_fields;
		$count_curr = $curr ? count($curr) : 0;
		$count_scopes = $scopes ? count($scopes) : 0;
		if($count_curr > $count_scopes){
			$add = $count_curr - $count_scopes;
			$this->addScope($id, $add);
		}else if($count_curr < $count_scopes){
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
		return true;
	}
	
	private function addScope($user, $count){
		for($i=1;$i<=$count;$i++){
			$scope = new UserScope;
			$scope->user_id = $user;
			$scope->scope_id = 0;
			$scope->save();
		}
	}
	
	private function addRole($user, $new){
		foreach($new as $n){
			$role = new AuthAssignment;
			$role->item_name = $n;
			$role->user_id = $user;
			$role->created_at = time();
			if(!$role->save()){
				$role->flashError();
			}
		}
	}
	
	private function rmvRole($user, $count){
		//echo $count;die();
		$ids = AuthAssignment::find()->where(['like', 'item_name', 'jeb-'])
		->andWhere(['user_id' => $user])
		->orderBy('created_at DESC')->limit($count)->all();
		if($ids){
			foreach($ids as $id){
				$id->delete();
			}
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
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
	
    public function actionExternal()
    {
        $model = new User();
		$model->scenario = 'create_external';
		

        if ($model->load(Yii::$app->request->post())) {
			
			$model->username = $model->email;
			$model->setPassword($model->email);
			
			//manual confirm at
			$model->confirmed_at = time();
			
			$model->updated_at = new Expression('NOW()');
			$model->created_at = new Expression('NOW()');
			
			if($model->save()){
				
				$assoc = new Associate;
				$assoc->user_id = $model->id;
				$assoc->institution = $model->institution;
				$assoc->country_id = $model->country;
				$assoc->admin_creation = 1;
				
				if($assoc->save()){
					Yii::$app->session->addFlash('success', "The user has been successfully created");
					return $this->redirect(['/jeb/user/view', 'id' => $model->id]);
				}
			}else{
				$model->flashError();
			}
           
			
			
        } 
		
		return $this->render('external', [
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
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	

}
