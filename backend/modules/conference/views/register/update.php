<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\ConfRegistration */

$this->title = 'Update Conf Registration: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Conf Registrations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="conf-registration-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
