<?php

namespace backend\modules\sae\controllers;

use backend\modules\sae\models\Answer;
use backend\modules\sae\models\Batch;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

/**
 * Default controller for the `sae` module
 */
class DefaultController extends Controller
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
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $batches = Batch::find()->orderBy(['bat_text' => SORT_ASC])->all();
        $selectedBatchId = Yii::$app->request->get('batch_id');

        if (!$selectedBatchId) {
            $defaultBatch = Batch::find()->where(['bat_show' => 1])->one();
            if ($defaultBatch) {
                $selectedBatchId = $defaultBatch->id;
            } elseif (!empty($batches)) {
                $selectedBatchId = $batches[0]->id;
            }
        }

        $selectedBatch = $selectedBatchId ? Batch::findOne($selectedBatchId) : null;
        $stats = [
            'total' => 0,
            'submitted' => 0,
            'in_progress' => 0,
            'not_started' => 0,
        ];

        if ($selectedBatch) {
            $query = Answer::find()->where(['bat_id' => $selectedBatch->id]);
            $stats['total'] = (clone $query)->count();
            $stats['submitted'] = (clone $query)->andWhere(['overall_status' => 3])->count();
            $stats['in_progress'] = (clone $query)->andWhere(['overall_status' => 1])->count();
            $stats['not_started'] = (clone $query)->andWhere(['overall_status' => 0])->count();
        }

        return $this->render('index', [
            'batches' => $batches,
            'selectedBatch' => $selectedBatch,
            'stats' => $stats,
        ]);
    }
}
