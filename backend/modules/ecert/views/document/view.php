<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\ecert\models\Document */

$this->title = $model->participant_name;
$this->params['breadcrumbs'][] = [
    'label' => 'Documents',
    'url' => [
        'index',
        'type' => $model->type_id
    ]
];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="document-view">


    <p>
        <?=Html::a('Update', ['update','id' => $model->id], ['class' => 'btn btn-primary'])?>
        <?=Html::a('Delete', ['delete','id' => $model->id], ['class' => 'btn btn-danger','data' => ['confirm' => 'Are you sure you want to delete this item?','method' => 'post']])?>
    </p>
 <div class="box">
<div class="box-header"></div>
<div class="box-body">

    <?php

    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'participant_name',
            'eventName',
            'field2',
            'field3',
            'field4',
            'field5',
            'downloaded'
        ]
    ])?>
</div>
</div>


</div>
