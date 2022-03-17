<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StageExaminer */

$this->title = 'Update Examiner: ' . $model->stage->student->user->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Stage', 'url' => ['student-stage/view', 'id' => $model->stage_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stage-examiner-update">
<h4>Stage: <?php echo $model->stage->stage->stage_name?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
