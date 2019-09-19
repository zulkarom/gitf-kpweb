<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\staff\models\StaffEducation */

$this->title = 'Update Education';
$this->params['breadcrumbs'][] = ['label' => 'My Educations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-education-create">

    <?= $this->render('_form_edu', [
        'model' => $model,
    ]) ?>

</div>
