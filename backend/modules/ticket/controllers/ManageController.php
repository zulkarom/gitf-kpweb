<?php

namespace backend\modules\ticket\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use backend\modules\ticket\models\Ticket;
use backend\modules\ticket\models\TicketMessage;
use backend\modules\ticket\models\TicketCategory;
use backend\modules\ticket\models\TicketSearch;
use backend\modules\staff\models\Staff;

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
                        'roles' => ['manage-ticket'],
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

        $post = Yii::$app->request->post();

        // Reply / internal note: save message (and status if provided)
        if ($message->load($post) && $message->save()) {
            if ($model->load($post)) {
                $model->save(false);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        // Ticket-only updates from the main Update Ticket form
        if ($model->load($post) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $categories = TicketCategory::find()->where(['is_active' => 1])->orderBy(['sort_order' => SORT_ASC, 'name' => SORT_ASC])->all();

        return $this->render('view', [
            'model' => $model,
            'message' => $message,
            'categories' => $categories,
        ]);
    }

    public function actionStaffList($q = null, $id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => []];

        if ($q !== null) {
            $query = Staff::find()
                ->alias('s')
                ->joinWith('user u')
                ->where(['s.staff_active' => 1])
                ->andWhere([
                    'or',
                    ['like', 'u.fullname', $q],
                    ['like', 'u.username', $q],
                ])
                ->orderBy(['u.fullname' => SORT_ASC])
                ->limit(20)
                ->all();

            foreach ($query as $staff) {
                $text = $staff->user && $staff->user->fullname
                    ? $staff->user->fullname
                    : ($staff->user ? $staff->user->username : null);
                if ($text === null) {
                    continue;
                }
                $out['results'][] = [
                    'id' => $staff->user_id,
                    'text' => $text,
                ];
            }
        } elseif ($id) {
            $staff = Staff::find()
                ->alias('s')
                ->joinWith('user u')
                ->where(['s.staff_active' => 1, 's.user_id' => $id])
                ->one();
            if ($staff && $staff->user) {
                $out['results'][] = [
                    'id' => $staff->user_id,
                    'text' => $staff->user->fullname ? $staff->user->fullname : $staff->user->username,
                ];
            }
        }

        return $out;
    }

    public function actionMyassigned()
    {
        $searchModel = new TicketSearch();
        $dataProvider = $searchModel->search(
            Yii::$app->request->queryParams,
            null,
            Yii::$app->user->id
        );

        return $this->render('myassigned', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
