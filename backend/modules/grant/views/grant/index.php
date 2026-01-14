<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\grant\models\GrantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Grants';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grant-index">

    <p>
        <?= Html::a('Create Grant', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Categories', ['//grant/category/index'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('Types', ['//grant/type/index'], ['class' => 'btn btn-default']) ?>
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
                    'project_code',
                    [
                        'attribute' => 'category_id',
                        'value' => function ($model) {
                            return $model->category ? $model->category->category_name : null;
                        },
                    ],
                    [
                        'attribute' => 'type_id',
                        'value' => function ($model) {
                            return $model->type ? $model->type->type_name : null;
                        },
                    ],
                    [
                        'attribute' => 'researcher_linked',
                        'label' => 'Researcher (Linked)',
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
                        'value' => function ($model) {
                            $val = $model->date_end;
                            if ((int)$model->is_extended === 1) {
                                if ($val) {
                                    return $val . ' *extended';
                                }
                                return '*extended';
                            }
                            return $val;
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
