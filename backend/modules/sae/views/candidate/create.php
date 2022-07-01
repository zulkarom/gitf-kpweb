<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Candidate */

$this->title = 'Create Candidate';
$this->params['breadcrumbs'][] = ['label' => 'Candidates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="candidate-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
