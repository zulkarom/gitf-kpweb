<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\proceedings\models\Paper */

$this->title = 'Update Paper: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Proceedings', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => 'Papers List', 'url' => ['index', 'proc' => $model->proc_id]];

$this->params['breadcrumbs'][] = 'Update';
?>
<div class="paper-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
