<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Synchronize';
$this->params['breadcrumbs'][] = ['label' => 'Student', 'url' => ['/students/student/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="student-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <input type="file" name="csv" value="" />

    <div class="form-group">
        <br/>
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
