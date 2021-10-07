<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\time\TimePicker;
use yii\helpers\ArrayHelper;
use backend\modules\workshop\models\Kursus;
use dosamigos\tinymce\TinyMce;
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body">
<div class="kursus-siri-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'kursus_name')->textInput() ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4">  <?= $form->field($model, 'kategori_id')->widget(Select2::classname(), [
            'data' => $model->categoryList,
            'options' => ['placeholder' => 'Select...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
            ]);?>
        </div>
        
         <div class="col-md-1">
            <?= $form->field($model, 'capacity')->textInput() ?>
        </div>
        
        
        
        </div>
    
    <div class="row">
     <div class="col-md-2">
            <?=$form->field($model, 'date_start')->widget(DatePicker::classname(), [
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    
                ],
                
                
            ]);

            ?>
        </div>
        <div class="col-md-2">
            <?=$form->field($model, 'date_end')->widget(DatePicker::classname(), [
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    
                ],
                
                
            ]);

            ?>
        </div>
         <div class="col-md-4">
            <?= $form->field($model, 'location')->textInput()?>
        </div>
  
</div>

    <div class="row">
    	<div class="col-md-2">
	
	 <?=$form->field($model, 'time_start')->widget(TimePicker::classname(), [
                	     'addonOptions' => [
                	         'buttonOptions' => ['class' => 'btn btn-info']
                	     ]
            ])->label('Time Start'); ?>
	
	
	</div>
	<div class="col-md-2">
	
	<?=$form->field($model, 'time_end')->widget(TimePicker::classname(), [
                	     'addonOptions' => [
                	         'buttonOptions' => ['class' => 'btn btn-info']
                	     ]
            ])->label('Time End'); ?>
	
	</div>
   
  
</div>

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
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
