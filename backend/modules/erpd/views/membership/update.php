<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\Membership */

$this->title = 'Update Membership';
$this->params['breadcrumbs'][] = ['label' => 'Memberships', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="membership-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
