<?php

namespace frontend\modules\conference\controllers;

use Yii;
use backend\modules\conference\models\Conference;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\User;

/**
 * ConferenceController implements the CRUD actions for Conference model.
 */
class PageController extends Controller
{
	public $layout = 'main-page';
	
	public function actionFees($confurl){
        $model = $this->findModel($confurl);
        return $this->render('fees', [
			'model' => $model,
		]);
    }
	
	public function actionTentative($confurl){
        $model = $this->findModel($confurl);
        return $this->render('tentative', [
			'model' => $model,
		]);
    }
	
	public function actionSubmission($confurl){
        $model = $this->findModel($confurl);
        return $this->render('submission', [
			'model' => $model,
		]);
    }
	
	public function actionPublication($confurl){
        $model = $this->findModel($confurl);
        return $this->render('publication', [
			'model' => $model,
		]);
    }
	
	public function actionScope($confurl){
        $model = $this->findModel($confurl);
        return $this->render('scope', [
			'model' => $model,
		]);
    }
	
	public function actionAccommodation($confurl){
        $model = $this->findModel($confurl);
        return $this->render('accommodation', [
			'model' => $model,
		]);
    }
	
	public function actionLanguage($confurl){
        $model = $this->findModel($confurl);
        return $this->render('language', [
			'model' => $model,
		]);
    }
	
	public function actionBackground($confurl){
        $model = $this->findModel($confurl);
        return $this->render('background',[
			'model' => $model,
		]);
    }
	
	public function actionContact($confurl){
        $model = $this->findModel($confurl);
        return $this->render('contact', [
			'model' => $model,
		]);
    }
	
	public function actionDates($confurl){
        $model = $this->findModel($confurl);
        return $this->render('dates', [
			'model' => $model,
		]);
    }
	
	public function actionAward($confurl){
        $model = $this->findModel($confurl);
        return $this->render('award', [
			'model' => $model,
		]);
    }
	
	public function actionCommittee($confurl){
        $model = $this->findModel($confurl);
        return $this->render('committee', [
			'model' => $model,
		]);
    }
	
	public function actionRegister($confurl){
		$this->layout = 'main-login';
		$model = $this->findModel($confurl);
		$user = new User;
		$user->scenario = 'checkemail';
		
		if ($user->load(Yii::$app->request->post())) {
			if($user->isEmailExist()){
				Yii::$app->session->addFlash('error', "You have already registered with Edusage Network, please proceed to login page. You can use forgot password feature in case you have forgotten your password");
			}else{
				$this->redirect(['user/register', 'url' => $confurl,'email' => $user->email]);
			}
		}

		return $this->render('register',[
			'user' => $user,
			'model' => $model
		]);
	}
	
	/**
     * Finds the Conference model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Conference the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($url)
    {
        if (($model = Conference::findOne(['conf_url' => $url])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
