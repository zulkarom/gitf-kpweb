<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\manual\models\Item */

$this->title = 'Create Item: ' . $title->title_text;
$this->params['breadcrumbs'][] = ['label' => 'Title Page', 'url' => ['title/view', 'id' => $model->title_id]];
$this->params['breadcrumbs'][] = 'New Item';
?>
<div class="item-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
