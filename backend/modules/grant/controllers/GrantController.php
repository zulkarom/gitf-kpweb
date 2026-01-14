<?php

namespace backend\modules\grant\controllers;

use Yii;
use backend\modules\grant\models\Grant;
use backend\modules\grant\models\GrantSearch;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class GrantController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new GrantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionStats()
    {
        $summary = (new Query())
            ->from('grn_grant')
            ->select([
                'grant_count' => 'COUNT(*)',
                'sum_amount' => 'COALESCE(SUM(amount), 0)',
                'extended_count' => 'SUM(CASE WHEN is_extended = 1 THEN 1 ELSE 0 END)',
            ])
            ->one();

        $byCategory = (new Query())
            ->from(['g' => 'grn_grant'])
            ->innerJoin(['c' => 'grn_category'], 'c.id = g.category_id')
            ->select([
                'category' => 'c.category_name',
                'grant_count' => 'COUNT(*)',
                'sum_amount' => 'COALESCE(SUM(g.amount), 0)',
            ])
            ->groupBy(['c.id', 'c.category_name'])
            ->orderBy(['grant_count' => SORT_DESC, 'category' => SORT_ASC])
            ->all();

        $byType = (new Query())
            ->from(['g' => 'grn_grant'])
            ->innerJoin(['t' => 'grn_type'], 't.id = g.type_id')
            ->select([
                'type' => 't.type_name',
                'grant_count' => 'COUNT(*)',
                'sum_amount' => 'COALESCE(SUM(g.amount), 0)',
            ])
            ->groupBy(['t.id', 't.type_name'])
            ->orderBy(['grant_count' => SORT_DESC, 'type' => SORT_ASC])
            ->all();

        return $this->render('stats', [
            'summary' => $summary,
            'byCategory' => $byCategory,
            'byType' => $byType,
        ]);
    }

    public function actionCreate()
    {
        $model = new Grant();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

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

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Grant::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
