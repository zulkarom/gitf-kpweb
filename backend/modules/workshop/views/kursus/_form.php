<?php

use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\Kursus */
/* @var $form yii\widgets\ActiveForm */
?>

 <div class="box">
<div class="box-header"></div>
<div class="box-body">

<div class="kursus-form">

<div class="row">
	<div class="col-md-8">
	
	
	 <?php $form = ActiveForm::begin(); ?>
	 
	 <?= $form->field($model, 'kategori_id')->dropDownList($model->categoryList, ['prompt' => 'Select Category']) ?>

    <?= $form->field($model, 'kursus_name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'description')->widget(TinyMce::className(), [
    'options' => ['rows' => 14],
    'language' => 'en',
    'clientOptions' => [
        'plugins' => [
            "advlist autolink lists link charmap",
            "searchreplace visualblocks code fullscreen",
            "paste"
        ],
        'menubar' => false,
        'toolbar' => "undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent"
    ]
]);?>
    
    



    <div class="form-group">
        <?= Html::submitButton('Save Kursus', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
	
	
	
	</div>

</div>

   
</div>

</div>
</div>


