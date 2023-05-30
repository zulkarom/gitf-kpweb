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
class OptionController extends Controller
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
    
}
