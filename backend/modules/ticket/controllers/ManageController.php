<?php

namespace backend\modules\ticket\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\modules\ticket\models\Ticket;
use backend\modules\ticket\models\TicketMessage;
use backend\modules\ticket\models\TicketCategory;
use backend\modules\ticket\models\TicketSearch;

class ManageController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin', 'support'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new TicketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $message = new TicketMessage();
        $message->ticket_id = $model->id;
        $message->user_id = Yii::$app->user->id;

        if ($message->load(Yii::$app->request->post()) && $message->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $categories = TicketCategory::find()->where(['is_active' => 1])->orderBy(['sort_order' => SORT_ASC, 'name' => SORT_ASC])->all();

        return $this->render('view', [
            'model' => $model,
            'message' => $message,
            'categories' => $categories,
        ]);
    }

    protected function findModel($id)
    {
        $model = Ticket::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $model;
    }
}
