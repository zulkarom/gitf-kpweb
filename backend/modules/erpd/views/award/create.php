<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\Award */

$this->title = 'New Award';
$this->params['breadcrumbs'][] = ['label' => 'Awards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="award-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
