<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Candidate */

$this->title = 'Create Candidate';
$this->params['breadcrumbs'][] = ['label' => 'Candidates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="candidate-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
