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

        $quest = Question::find()->all();
        
        return $this->render('index', [
            'quest' => $quest,
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
        $answer = Answer::findOne(['can_id' => $user_id, 'bat_id' => $batch]);
        if($answer){
            
            if($answer->answer_status == 0 && $answer->answer_status2 == 0){
                $answer->created_at = time();
            }
            if($status == 1){
                $answer->answer_start1 = time();
            }

            $answer->answer_status = $status;
            $answer->updated_at = time();
        }
        $answer->processOverallStatus();
    }

    public function actionSubmit($last=1)
    {
        $session = Yii::$app->session;
        $batch = $session->get('batch');
        $user = Yii::$app->user->identity->id;

        $time = Yii::$app->request->post('time');
        $qlast = Yii::$app->request->post('qlast');
        $answer = Answer::find()
        ->where(['can_id' => $user])
        ->andWhere(['bat_id' => $batch])
        ->one();
        if($answer){
            Answer::updateLastSaved($user,$batch,$time,$qlast);
            $answer->answer_last_saved = $time;
            $answer->question_last_saved  = $qlast;
            $answer->updated_at = time();

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
                    $answer->$q = $jwb;
                    $co++;
                }
            }
            if(!$answer->save()){
                echo 0;                      
            }else{
                $action = Yii::$app->request->post('aksi');
                if ($action ==0){
                    $answer->answer_status = 3;
                    $answer->processOverallStatus();
                }
                echo 1;
            }
        }
        
        exit;
    }
}
