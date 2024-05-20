<?php

namespace frontend\controllers;

use backend\modules\protege\models\Company;
use backend\modules\protege\models\CompanyOffer;
use backend\modules\protege\models\Session;
use backend\modules\protege\models\StudentRegistration;
use frontend\models\ProtegeSearch;
use Yii;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ProceedingController implements the CRUD actions for Proceeding model.
 */
class ProtegeController extends Controller
{
	public function actionIndex(){
        $session = Session::findOne(['is_active' => 1]);
        $searchModel = new ProtegeSearch();
        if($session){
            $searchModel->session_id = $session->id;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'session' => $session
        ]);
    }

    public function actionView($id){
        $model = $this->findModel($id);
        $register = new StudentRegistration();
        $register->company_offer_id = $model->id;
        $register->status = 10;//default active

        if ($register->load(Yii::$app->request->post())) {
            //validate ada available ke tak?
            if($model->getBalance() > 1){
                $register->student_name = strtoupper($register->student_name);
                $register->student_matric = strtoupper($register->student_matric);
                $register->email = strtolower($register->email);
                $register->register_at = new Expression('NOW()');
                if($register->save()){
                    Yii::$app->session->addFlash('success', "Registration Successful");
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }else{
                Yii::$app->session->addFlash('error', "Sorry, the slot no longer available");
            }
            
            
        }

        return $this->render('view', [
            'model' => $model,
            'register' => $register,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = CompanyOffer::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not existx.');
    }

    

	

}
