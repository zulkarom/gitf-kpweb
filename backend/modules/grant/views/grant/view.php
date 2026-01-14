<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\grant\models\Grant */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Grants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grant-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="box-header"></div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'grant_title:ntext',
                    'project_code',
                    [
                        'attribute' => 'category_id',
                        'value' => $model->category ? $model->category->category_name : null,
                    ],
                    [
                        'attribute' => 'type_id',
                        'value' => $model->type ? $model->type->type_name : null,
                    ],
                    'head_researcher_id',
                    [
                        'label' => 'Researcher (Linked)',
                        'value' => $model->headResearcher ? $model->headResearcher->svNamePlain : null,
                    ],
                    [
                        'attribute' => 'head_researcher_name',
                        'label' => 'Researcher (Source)',
                    ],
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
                ],
            ]) ?>
        </div>
    </div>

</div>
