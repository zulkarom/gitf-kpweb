<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Shorten Url';

?>

<div class="urlredirect-index">

    <p>
        <?= Html::a('Create Short Link', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
        <div class="box-header"></div>
        <div class="box-body">
            <div class="table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        'id',
                        'code',
                        [
                            'label' => 'Full Short URL',
                            'value' => function ($model) {
                                return Url::to(['/link/go', 'c' => $model->code], true);
                            },
                            'format' => 'raw',
                            'content' => function ($model) {
                                $full = Url::to(['/link/go', 'c' => $model->code], true);
                                return Html::a(Html::encode($full), $full, ['target' => '_blank', 'rel' => 'noopener']);
                            },
                        ],
                        [
                            'attribute' => 'url_to',
                            'format' => 'ntext',
                        ],
                        'hit_counter',
                        'latest_hit',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update} {delete}',
                            'buttons' => [
                                'update' => function ($url, $model, $key) {
                                    return Html::a('<i class="fa fa-pencil"></i>', $url, [
                                        'title' => 'Update',
                                        'class' => 'btn btn-primary btn-xs',
                                    ]);
                                },
                                'delete' => function ($url, $model, $key) {
                                    return Html::a('<i class="fa fa-trash"></i>', $url, [
                                        'title' => 'Delete',
                                        'class' => 'btn btn-danger btn-xs',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this item?',
                                            'method' => 'post',
                                        ],
                                    ]);
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>

</div>
