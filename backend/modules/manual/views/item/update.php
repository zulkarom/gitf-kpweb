<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\manual\models\Item */

$this->title = 'Update Item: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Title Page', 'url' => ['title/view', 'id' => $model->title_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="item-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
