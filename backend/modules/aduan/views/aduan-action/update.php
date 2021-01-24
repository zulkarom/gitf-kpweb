<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\aduan\models\AduanAction */

$this->title = 'Update Aduan Action';
$this->params['breadcrumbs'][] = ['label' => 'Aduan Action', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="aduan-action-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
