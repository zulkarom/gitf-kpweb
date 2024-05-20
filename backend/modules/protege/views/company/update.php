<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\protege\models\Company */

$this->title = 'Update Company';
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="company-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
