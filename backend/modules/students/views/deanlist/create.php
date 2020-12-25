<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\students\models\DeanList */

$this->title = 'Create Dean List';
$this->params['breadcrumbs'][] = ['label' => 'Dean Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dean-list-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
