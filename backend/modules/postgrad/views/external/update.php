<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\External */

$this->title = 'Update: ' . $model->ex_name;
$this->params['breadcrumbs'][] = ['label' => 'Externals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="external-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
