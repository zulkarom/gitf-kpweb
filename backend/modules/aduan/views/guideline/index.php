<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Guidelines';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guideline-index">


    <p>
        <?= Html::a('Create Guideline', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

   <div class="box">
<div class="box-header"></div>
<div class="box-body"> <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

       
            'guideline_text:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?></div>
</div>

</div>
