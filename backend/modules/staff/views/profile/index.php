<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\staff\models\Staff */

$this->title = 'My Profile';
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="staff-update">


    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
