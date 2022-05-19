<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\ecert\models\EventType */

$this->title = $model->type_name;
$this->params['breadcrumbs'][] = ['label' => 'Event Types', 'url' => ['index', 'event' => $model->event_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="event-type-view">

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
            'eventName',
            'type_name',
            'field1_mt',
            'field1_size',
            'field2_mt',
            'field2_size',
            'field3_mt',
            'field3_size',
            'field4_mt',
            'field4_size',
            'field5_mt',
            'field5_size',
            'margin_right',
            'margin_left',
            'set_type',
            'custom_html:ntext',
        ],
    ]) ?>

</div>
</div>


</div>
