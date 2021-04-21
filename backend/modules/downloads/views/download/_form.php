<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\downloads\models\DownloadCategory;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\modules\downloads\models\DeanList */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="dean-list-form">

<div class="box">
<div class="box-header"></div>
<div class="box-body">    <?php $form = ActiveForm::begin(); ?>


<div class="row">
<div class="col-md-6"><?= $form->field($model, 'category_id')->dropDownList(
        ArrayHelper::map(DownloadCategory::find()->all(),'id','category_name')
    ) ?>  <?= $form->field($model, 'matric_no')->textInput(['maxlength' => true]) ?></div>

<div class="col-md-6">
</div>

</div>

	

  

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?></div>
</div>


</div>
