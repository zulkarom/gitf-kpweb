<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Candidate */

$this->title = 'Update Candidate: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Candidates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="candidate-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
