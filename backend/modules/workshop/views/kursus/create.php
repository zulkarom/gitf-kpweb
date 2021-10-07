<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\Kursus */

$this->title = 'Create Kursus';
$this->params['breadcrumbs'][] = ['label' => 'Kursus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kursus-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
