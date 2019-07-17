<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\Publication */

$this->title = 'Update Publication';
$this->params['breadcrumbs'][] = ['label' => 'Publications', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="publication-update">

    <?= $this->render('_form', [
        'model' => $model,
		'authors' => $authors,
		'editors' => $editors
    ]) ?>

</div>
