<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\Publication */

$this->title = 'Create Publication';
$this->params['breadcrumbs'][] = ['label' => 'Publications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publication-create">

    <?= $this->render('_form', [
        'model' => $model,
		'authors' => $authors,
		'editors' => $editors
    ]) ?>

</div>
