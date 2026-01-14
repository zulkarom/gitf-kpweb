<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\modules\grant\models\Category;
use backend\modules\grant\models\Type;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\grant\models\GrantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Grants';
$this->params['breadcrumbs'][] = $this->title;

$categories = ArrayHelper::map(Category::find()->orderBy(['category_name' => SORT_ASC])->all(), 'id', 'category_name');
$types = ArrayHelper::map(Type::find()->orderBy(['type_name' => SORT_ASC])->all(), 'id', 'type_name');
?>
<div class="grant-index">

    <p>
        <?= Html::a('Create Grant', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Export Excel', array_merge(['export-excel'], Yii::$app->request->queryParams), ['class' => 'btn btn-default']) ?>
    
    </p>

    <div class="box">
        <div class="box-header"></div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'grant_title:ntext',
                    //'project_code',
                    [
                        'attribute' => 'category_id',
                        'value' => function ($model) {
                            return $model->category ? $model->category->category_name : null;
                        },
                        'filter' => Html::activeDropDownList($searchModel, 'category_id', $categories, ['class' => 'form-control', 'prompt' => 'All']),
                    ],
                    [
                        'attribute' => 'type_id',
                        'value' => function ($model) {
                            return $model->type ? $model->type->type_name : null;
                        },
                        'filter' => Html::activeDropDownList($searchModel, 'type_id', $types, ['class' => 'form-control', 'prompt' => 'All']),
                    ],
                    [
                        'attribute' => 'researcher_linked',
                        'label' => 'Head Researcher',
                        'value' => function ($model) {
                            if ($model->headResearcher) {
                                $sv = $model->headResearcher;
                                if ($sv->staff) {
                                    return $sv->staff->staff_no . ' - ' . strtoupper($sv->svNamePlain);
                                }
                                return strtoupper($sv->svNamePlain);
                            }
                            return null;
                        },
                    ],
                    // [
                    //     'attribute' => 'head_researcher_name',
                    //     'label' => 'Researcher (Source)',
                    // ],
                    'amount',
                    'date_start',
                    [
                        'attribute' => 'date_end',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $val = $model->date_end;
                            if ((int)$model->is_extended === 1) {
                                if ($val) {
                                    return $val . ' <span style="background-color: yellow; padding: 2px 4px;">*extended</span>';
                                }
                                return '<span style="background-color: yellow; padding: 2px 4px;">*extended</span>';
                            }
                            return $val;
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update}',
                        'contentOptions' => ['style' => 'white-space:nowrap;'],
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a('View', $url, ['class' => 'btn btn-xs btn-info']);
                            },
                            'update' => function ($url, $model, $key) {
                                return Html::a('Update', $url, ['class' => 'btn btn-xs btn-primary']);
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
