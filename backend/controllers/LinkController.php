<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\models\Urlredirect;

class LinkController extends Controller
{
    public function actionGo($c)
    {
        $model = Urlredirect::find()->where(['code' => $c])->one();
        if (!$model || !$model->url_to) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model->hit_counter = (int)$model->hit_counter + 1;
        $model->latest_hit = time();
        $model->save(false, ['hit_counter', 'latest_hit']);

        return Yii::$app->response->redirect($model->url_to, 302);
    }
}
