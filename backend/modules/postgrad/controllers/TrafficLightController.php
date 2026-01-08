<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\modules\postgrad\models\PgSetting;

class TrafficLightController extends Controller
{
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

    public function actionIndex()
    {
        $models = PgSetting::find()->orderBy(['module' => SORT_ASC, 'color' => SORT_ASC])->all();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            if (Model::loadMultiple($models, $post) && Model::validateMultiple($models)) {
                $tx = Yii::$app->db->beginTransaction();
                try {
                    foreach ($models as $m) {
                        $m->updated_at = time();
                        $m->updated_by = Yii::$app->user->id;
                        $m->save(false);
                    }
                    $tx->commit();
                    Yii::$app->session->addFlash('success', 'Traffic Light setting updated');
                    return $this->refresh();
                } catch (\Throwable $e) {
                    $tx->rollBack();
                    throw $e;
                }
            }

            Yii::$app->session->addFlash('error', 'Failed to update Traffic Light setting');
        }

        return $this->render('index', [
            'models' => $models,
        ]);
    }
}
