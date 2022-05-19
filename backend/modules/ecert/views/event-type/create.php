<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\ecert\models\EventType */

$this->title = 'Create Event Type';
$this->params['breadcrumbs'][] = ['label' => 'Event Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
