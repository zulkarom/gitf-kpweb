<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\aduan\models\AduanAction */

$this->title = 'Create Action';
$this->params['breadcrumbs'][] = ['label' => 'Create Action', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aduan-action-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
