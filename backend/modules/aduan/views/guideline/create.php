<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\aduan\models\Guideline */

$this->title = 'Create Guideline';
$this->params['breadcrumbs'][] = ['label' => 'Guidelines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guideline-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
