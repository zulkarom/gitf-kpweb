<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\grant\models\Grant */

$this->title = 'Create Grant';
$this->params['breadcrumbs'][] = ['label' => 'Grants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grant-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
