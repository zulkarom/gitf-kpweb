<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\ecert\models\Event */
$this->title = 'Create Event';
$this->params['breadcrumbs'][] = [
    'label' => 'Events',
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-create">


    <?=$this->render('_form', ['model' => $model])?>

</div>
