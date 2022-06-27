<?php

namespace backend\modules\conference\controllers;

use Yii;
use backend\modules\conference\models\ConfRegistration;
use backend\modules\conference\models\ConfPaper;
use backend\modules\conference\models\Conference;
use backend\modules\conference\models\ConfRegistrationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

/**
 * RegisterController implements the CRUD actions for ConfRegistration model.
 */
class RegisterController extends Controller
{
    /**
     * {@inheritdoc}
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
	
	/* public function beforeAction($conf){
		if($conf){
			return true;
		}
		return false;
	} */

    /**
     * Lists all ConfRegistration models.
     * @return mixed
     */
    public function actionIndex($conf)
    {
        $searchModel = new ConfRegistrationSearch();
		$searchModel->conf_id = $conf;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$conference = $this->findConference($conf);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'conference' => $conference,
        ]);
    }

    /**
     * Displays a single ConfRegistration model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ConfRegistration model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ConfRegistration();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ConfRegistration model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ConfRegistration model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUnregister($id, $conf)
    {
		//cari dah hantar paper ke tak
		$reg = $this->findModel($id);
		$kira = ConfPaper::find()->where(['user_id' => $reg->user_id, 'conf_id' => $conf])->count();
		if($kira > 0){
			Yii::$app->session->addFlash('error', "The action failed since the user has submitted at least one paper!");
			
		}else{
			if($reg->delete()){
				Yii::$app->session->addFlash('success', "The user has been unregistered");
			}
			
		}
        

        return $this->redirect(['index', 'conf' => $conf]);
    }

    /**
     * Finds the ConfRegistration model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ConfRegistration the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ConfRegistration::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	 protected function findConference($id)
    {
        if (($model = Conference::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
