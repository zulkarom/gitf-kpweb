<?php

namespace frontend\controllers;

use Yii;
use backend\models\Answer;
use yii\web\Controller;
use yii\filters\AccessControl;
use backend\models\Batch;
use backend\models\Question;

/**
 * AnswerController implements the CRUD actions for Answer model.
 */
class TestController extends Controller
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

        $quest = Question::find()->all();
        
        return $this->render('index', [
            'quest' => $quest,
            'answer' => $answer,
        ]); 
    }
    
    public function actionUpdate(){
        $this->layout = "//main-login";
        $session = Yii::$app->session;
        $batch = $session->get('batch');
        $batch = Batch::findOne($batch);
        if($batch->allow_update == 0){
            return $this->redirect(['index']);
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
                return $this->redirect(['index']);
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
            Answer::updateAll(['answer_status' => $status, 'created_at' => time()], ['can_id' => $user_id, 'bat_id' => $batch]);
        }else{
            Answer::updateAll(['answer_status' => $status, 'updated_at' => time()], ['can_id' => $user_id, 'bat_id' => $batch]);
        }
        
        Answer::processOverallStatus($status, 1, $user_id, $batch);
    }

    public function actionSubmit($last=1)
    {
        $session = Yii::$app->session;
        $batch = $session->get('batch');
        $user = Yii::$app->user->identity->id;

        $time = Yii::$app->request->post('time');
        $qlast = Yii::$app->request->post('qlast');
        $model = Answer::find()
        ->where(['can_id' => $user])
        ->andWhere(['bat_id' => $batch])
        ->one();

        Answer::updateLastSaved($user,$batch,$time,$qlast);

        $total = count(Question::getAllQuestions()); 

        $co = 1;
        for($i=1;$i<=$total;$i++){
            if($i >= $last){
                if($co==1){$c="";}else{$c=", ";}
                // $sql .= $c."q".$i." = :q".$i;
                $q = 'q'.$i;
                $jwb = Yii::$app->request->post($q);
                if($jwb == "" or $jwb == null){
                    $jwb = -1;
                }
                $model->$q = $jwb;
                $co++;
            }
        }
        if(!$model->save()){
            echo 0;                      
        }else{
            $action = Yii::$app->request->post('aksi');
            if ($action ==0){
                Answer::setStatus(3, $user, $batch);
            }
            echo 1;
        }
        exit;
    }
}
