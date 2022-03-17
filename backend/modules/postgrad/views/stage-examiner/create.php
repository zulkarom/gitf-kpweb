<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StageExaminer */

$this->title = 'Add Examiner: ';
$this->params['breadcrumbs'][] = ['label' => 'Stage', 'url' => ['student-stage/view', 'id' => $stage->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stage-examiner-create">

<h4>Stage: <?php echo $stage->stage->stage_name?></h4>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
