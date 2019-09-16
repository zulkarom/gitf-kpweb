<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\jeb\models\EmailTemplate */

$this->title = 'Update Email Template';
$this->params['breadcrumbs'][] = ['label' => 'Email Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="box">
<div class="box-body"><div class="email-template-update">

<h5>* <?=$model->description?></h5>
<br />

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div></div>
</div>
