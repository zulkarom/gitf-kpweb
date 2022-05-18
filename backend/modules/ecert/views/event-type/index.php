<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Event Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-type-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Event Type', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'event_id',
            'type_name',
            'field1_mt',
            'field1_size',
            //'field2_mt',
            //'field2_size',
            //'field3_mt',
            //'field3_size',
            //'field4_mt',
            //'field4_size',
            //'field5_mt',
            //'field5_size',
            //'margin_right',
            //'margin_left',
            //'set_type',
            //'custom_html:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
