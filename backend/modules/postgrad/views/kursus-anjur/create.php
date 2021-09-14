<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\KursusAnjur */

$this->title = 'Create Kursus Anjur';
$this->params['breadcrumbs'][] = ['label' => 'Kursus Anjur', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kursus-anjur-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
