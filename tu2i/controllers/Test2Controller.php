<?php

namespace tu2i\controllers;

use Yii;
use backend\modules\sae\models\Answer;
use yii\web\Controller;
use yii\filters\AccessControl;
use backend\modules\sae\models\Batch;
use backend\modules\sae\models\Question;

/**
 * AnswerController implements the CRUD actions for Answer model.
 */
class Test2Controller extends Controller
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

    public function actionTest(){
        
    }

    /**
     * Lists all Answer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "//main-login";
        $session = Yii::$app->session;
        $batch = $session->get('batch');
        $answer = Answer::find()
        ->where(['bat_id' => $batch, 'can_id' => Yii::$app->user->identity->id])
        ->one();
        if(!$answer){
            Yii::$app->user->logout();
            return $this->redirect(['site/index']);
        }

        return $this->render('index', [
            'answer' => $answer,
        ]); 
    }
    
    public function actionUpdate(){
        //echo Yii::$app->user->identity->id;die();
        $this->layout = "//main-login";
        $session = Yii::$app->session;
        $batch = $session->get('batch');
        $batch = Batch::findOne($batch);
        if($batch->allow_update == 0){
            return $this->redirect(['test/index']);
        }
        
        $answer = Answer::find()
        ->where(['bat_id' => $batch->id, 'can_id' => Yii::$app->user->identity->id])
        ->one();
        if(!$answer){
            Yii::$app->user->logout();
            return $this->redirect(['site/index']);
        }
        
        if ($answer->load(Yii::$app->request->post())) {
            if($answer->save()){
                return $this->redirect(['test/index']);
            }
        }
        
        return $this->render('update', [
            'model' => $answer,
            'batch' => $batch,
        ]);
    }

    public function actionChangeStatus($status=0){
        $session = Yii::$app->session;
        $batch = $session->get('batch');
        $user_id = Yii::$app->user->identity->id;

        // Answer::setStatus($status, $user->id);
        if($status == 1){
            Answer::updateAll(['answer_status2' => $status, 'created_at' => time()], ['can_id' => $user_id, 'bat_id' => $batch]);
        }else{
            Answer::updateAll(['answer_status2' => $status, 'updated_at' => time()], ['can_id' => $user_id, 'bat_id' => $batch]);
        }
        
        Answer::processOverallStatus($status, 1, $user_id, $batch);
    }

    public function actionSubmit()
    {
        $session = Yii::$app->session;
        $batch = $session->get('batch');
        $user = Yii::$app->user->identity->id;

        $time = Yii::$app->request->post('time');
        $karangan = Yii::$app->request->post('karangan');
        $action = Yii::$app->request->post('aksi');
        $model = Answer::find()
        ->where(['can_id' => $user])
        ->andWhere(['bat_id' => $batch])
        ->one();

        $model->biz_idea = $karangan;
        $model->answer_last_saved2 = $time;
        if($action == 0){

        }
        
        if(!$model->save()){
            echo 0;                      
        }else{
            
            if ($action ==0){
                Answer::setStatus(3, $user, $batch);
            }
            echo 1;
        }
        exit;
    }
}
