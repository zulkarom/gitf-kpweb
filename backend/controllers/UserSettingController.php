<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use common\models\ChangePasswordForm;
use common\models\User;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UserSettingController extends Controller
{
    /**
     * @inheritdoc
     */
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
	
	public function actionChangePassword()
	{
		$id = Yii::$app->user->id;
	 
		try {
			$model = new ChangePasswordForm($id);
		} catch (InvalidParamException $e) {
			throw new \yii\web\BadRequestHttpException($e->getMessage());
		}
	 
		if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->changePassword()) {
			Yii::$app->session->setFlash('success', 'Password Changed!');
		}
	 
		return $this->render('change-password', [
			'model' => $model,
		]);
	}
	
	public function actionReturnRole()
	{
		$session = Yii::$app->session;
		if ($session->has('or-usr')){
			$id = $session->get('or-usr');
			$user = User::findIdentity($id);
				if(Yii::$app->user->login($user)){
					$session->remove('or-usr');
					return $this->redirect(['site/index']);
				}
			
		}else{
			throw new NotFoundHttpException('The requested page does not exist..');
		}
		
	}

}
