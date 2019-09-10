<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\KnowledgeTransfer */

$this->title = 'Create Knowledge Transfer';
$this->params['breadcrumbs'][] = ['label' => 'Knowledge Transfers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="knowledge-transfer-create">


    <?= $this->render('_form', [
        'model' => $model,
		'members' => $members
    ]) ?>

</div>
