<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\website\models\FrontSlider */

$this->title = 'Update:' . $model->slide_name;
$this->params['breadcrumbs'][] = ['label' => 'Front Sliders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="front-slider-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
