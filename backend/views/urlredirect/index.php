<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Shorten Url';

?>

<div class="urlredirect-index">

    <div class="row">
        <div class="col-sm-6">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-sm-6 text-right" style="padding-top: 20px;">
            <?= Html::a('Create Short Link', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>

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
            ],
        ],
    ]); ?>

</div>
