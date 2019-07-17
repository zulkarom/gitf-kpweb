<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\KnowledgeTransfer */

$this->title = 'Update Knowledge Transfer';
$this->params['breadcrumbs'][] = ['label' => 'Knowledge Transfers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="knowledge-transfer-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
