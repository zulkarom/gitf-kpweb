<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\aduan\models\Aduan */

$this->title = 'Update Aduan';
$this->params['breadcrumbs'][] = ['label' => 'Aduans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="aduan-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
