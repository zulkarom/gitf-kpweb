<?php
use yii\widgets\ActiveForm;
use backend\models\Semester;

$this->title = 'Upload Dean\'s List Certificates';
$model->semester = Semester::getCurrentSemester()->id;
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body">

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

	<?= $form->field($model, 'semester')->dropDownList(
        Semester::listSemesterArray()
    )->label(false) ?>

    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => '.pdf']) ?>

    <button class="btn btn-success">Submit</button>

<?php ActiveForm::end() ?></div>
</div>
