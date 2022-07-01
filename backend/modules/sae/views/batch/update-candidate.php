<?php
use yii\helpers\Html;

$this->title = 'Update Candidate';
$this->params['breadcrumbs'][] = ['label' => 'Batches', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelBatch->bat_text, 'url' => ['view', 'id' => $modelBatch->id]];
$this->params['breadcrumbs'][] = ['label' => 'Candidates', 'url' => ['view-candidates', 'bat_id' => $modelBatch->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="batch-update">

<div class="card">
    <div class="card-body">
    <?= $this->render('_form_candidate', [
        'model' => $model,
        'modelBatch' => $modelBatch,
        'modelAnswer' => $modelAnswer,
    ]) ?>
    </div>
</div>

</div>
