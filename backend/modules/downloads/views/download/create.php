<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\downloads\models\Download */

$this->title = 'Create Download';
$this->params['breadcrumbs'][] = ['label' => 'Downloads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="download-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
