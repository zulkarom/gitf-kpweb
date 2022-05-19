<?php
use common\models\UploadFile;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\ecert\models\EventType */

$this->title = $model->type_name;
$this->params['breadcrumbs'][] = [
    'label' => 'Event Types',
    'url' => [
        'index',
        'event' => $model->event_id
    ]
];
$this->params['breadcrumbs'][] = $this->title;
$model->file_controller = 'event-type';

?>
<div class="event-type-view">

    <p>
    <?php
    if ($model->published == 0) {
        echo Html::a('Publish', [
            'publish',
            'id' => $model->id
        ], [
            'class' => 'btn btn-info'
        ]);
    } else {
        echo Html::a('Unpublish', [
            'unpublish',
            'id' => $model->id
        ], [
            'class' => 'btn btn-warning'
        ]);
    }

    ?>
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
            'publishLabel:html',
            'eventName',
            'type_name',
            'name_mt',
            'name_size',
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
            'custom_html:ntext'
        ]
    ])?>

<br />
    <?=UploadFile::fileInput($model, 'template')?>



</div>
</div>


</div>
