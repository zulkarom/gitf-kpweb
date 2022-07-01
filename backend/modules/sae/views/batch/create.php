<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Batch */

$this->title = 'Create Batch';
$this->params['breadcrumbs'][] = ['label' => 'Batches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="batch-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
