<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\staff\models\Staff */

$this->title = 'Create Staff';
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
