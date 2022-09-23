<?php
namespace  backend\modules\user\controllers;

use Yii;
use backend\modules\user\models\PasswordResetRequestForm;
use backend\modules\user\models\ResetPasswordForm;
use dektrium\user\controllers\RecoveryController as BaseRecoveryController;
use InvalidArgumentException;
use yii\web\BadRequestHttpException;

class RecoveryController extends BaseRecoveryController
{
    
    public function actionRequest()
    {
		$this->layout = "//main-login";
        $model= new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->redirect(['/user/login']);
                
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }


        //custom recovey
        return $this->render('request', [
            'model' => $model
        ]);

       // return parent::actionRequest();
    }

    public function actionReset($id, $code)
    {
		$this->layout = "//main-login";
        return parent::actionReset($id, $code);
    }

    public function actionResetPassword($token)
    {
        $this->layout = "//main-login";
       
        try 
        {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Your new password has been successfully created.');
            
            return $this->redirect(['/site/security/login']);
        }
        
        return $this->render('reset', [
            'model' => $model,
        ]);
    }
}
