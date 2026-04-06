<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Shorten Url';

?>

<div class="urlredirect-index">

    <p>
        <?= Html::a('Create Short Link', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'code',
            [
                'attribute' => 'url_to',
                'format' => 'ntext',
            ],
            'hit_counter',
            'latest_hit:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>

</div>
