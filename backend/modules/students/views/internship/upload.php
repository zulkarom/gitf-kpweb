<?php
use yii\widgets\ActiveForm;
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => '.pdf']) ?>

    <button class="btn btn-success">Submit</button>

<?php ActiveForm::end() ?></div>
</div>
