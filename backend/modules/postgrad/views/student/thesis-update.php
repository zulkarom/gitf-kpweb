<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $student backend\modules\postgrad\models\Student */
/* @var $thesis backend\modules\postgrad\models\PgStudentThesis */

$this->title = 'Edit Thesis Title: ' . $student->matric_no;
$this->params['breadcrumbs'][] = ['label' => 'Postgraduate Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $student->user->fullname, 'url' => ['view', 'id' => $student->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="pg-student-thesis-update">

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <?= $this->render('_thesis_form', [
                'thesis' => $thesis,
            ]) ?>
        </div>
    </div>

</div>
