<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\University */

$this->title = 'Create University';
$this->params['breadcrumbs'][] = ['label' => 'Universities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="university-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
