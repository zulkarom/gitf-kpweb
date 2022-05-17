<?php
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\ecert\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">

    <?php
    // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?=Html::a('Create Event', ['create'], ['class' => 'btn btn-success'])?>
    </p>


     <div class="box">
<div class="box-header"></div>
<div class="box-body">

  <?php

echo GridView::widget([
    'dataProvider' => $dataProvider,
    // 'filterModel' => $searchModel,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn'
        ],
        'id',
        'event_name',
        [
            'class' => 'yii\grid\ActionColumn'
        ]
    ]
]);
?>
</div>
</div>
</div>
