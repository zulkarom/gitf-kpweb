<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\ecert\models\Event */
$this->title = 'Update Event: ' . $model->id;
$this->params['breadcrumbs'][] = [
    'label' => 'Events',
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->id,
    'url' => [
        'view',
        'id' => $model->id
    ]
];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="event-update">


    <?=$this->render('_form', ['model' => $model])?>

</div>
