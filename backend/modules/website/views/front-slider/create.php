<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\website\models\FrontSlider */

$this->title = 'Create Front Slider';
$this->params['breadcrumbs'][] = ['label' => 'Front Sliders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="front-slider-create">

   <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
