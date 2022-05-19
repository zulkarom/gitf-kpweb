<?php
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Types';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="type-index">
    <p>
        <?=Html::a('Create Type', ['create'], ['class' => 'btn btn-success'])?>

    </p>



     <div class="box">
<div class="box-header"></div>
<div class="box-body">

    <?php

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn'
            ],
            'id',
            'type_name',
            [
                'class' => 'yii\grid\ActionColumn'
            ]
        ]
    ]);
    ?>
</div>
</div>
</div>
