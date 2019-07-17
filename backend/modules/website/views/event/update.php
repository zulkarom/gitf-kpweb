<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\widgets\TimePicker;
use common\models\Upload;

$model->file_controller = 'event';

/* @var $this yii\web\View */
/* @var $model backend\modules\website\models\Event */

$this->title = 'Update Event';
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

 <?php $form = ActiveForm::begin(); ?>

<div class="box">
<div class="box-header"></div>
<div class="box-body">

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'venue')->textInput(['maxlength' => true]) ?>
	
	<?php 
	if($model->date_start == '0000-00-00'){
		$model->date_start = date('Y-m-d');
	}
	
	if($model->date_end == '0000-00-00'){
		$model->date_end = date('Y-m-d');
	}
	
	if($model->time_start == '00:00:00'){
		$model->time_start = '08:00:00';
	}
	
	if($model->time_end == '00:00:00'){
		$model->time_end = '17:00:00';
	}
	
	
	?>
	
	<div class="row">
<div class="col-md-3"> <?=$form->field($model, 'date_start')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
]); ?></div>

<div class="col-md-3"> <?=$form->field($model, 'date_end')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
]); ?></div>

<div class="col-md-3"><?=$form->field($model, 'time_start')->widget(TimePicker::classname(), ['pluginOptions' => [
        'showMeridian' => false,
        'minuteStep' => 1,
    ]]);?>
</div><div class="col-md-3"><?=$form->field($model, 'time_end')->widget(TimePicker::classname(), ['pluginOptions' => [
        'showMeridian' => false,
        'minuteStep' => 1,
    ]]);?>
</div>

</div>



</div>
</div>



<h4>Promotion Section</h4>


<div class="box">
<div class="box-header"></div>
<div class="box-body">
<?=Upload::fileInput($model, 'promoimg')?>

<?= $form->field($model, 'intro_promo')->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'register_link')->textarea(['rows' => 1]) ?>

     
	<?= $form->field($model, 'fee', [
    'addon' => ['prepend' => ['content'=>'RM']]
]); ?>


<?= $form->field($model, 'target_participant')->textarea(['rows' => 3]) ?>

<?= $form->field($model, 'objective')->textarea(['rows' => 3]) ?>

<?= $form->field($model, 'contact_pic')->textarea(['rows' => 3]) ?>

<?= $form->field($model, 'speaker')->textarea(['rows' => 3]) ?>

<?=Upload::fileInput($model, 'brochure')?>
	






<?= $form->field($model, 'publish_promo')->dropDownList([1=>'Yes', 0=>'No'], ['prompt' => 'Please Select' ]
    ) ?>
</div>
</div>


<h4>Report Section</h4>
<div class="box">
<div class="box-header"></div>
<div class="box-body">

<?=Upload::fileInput($model, 'newsimg')?>

<?=Upload::fileInput($model, 'imagetop')?>

<?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'report_1')->textarea(['rows' => 6]) ?>
	
	<?=Upload::fileInput($model, 'imagemiddle')?>

    <?= $form->field($model, 'report_2')->textarea(['rows' => 6]) ?>


<?=Upload::fileInput($model, 'imagebottom')?>


<?= $form->field($model, 'publish_report')->dropDownList([1=>'Yes', 0=>'No'], ['prompt' => 'Please Select' ]
    ) ?>


</div>
</div>



 



<div class="form-group">
        <?= Html::submitButton('UPDATE EVENT', ['class' => 'btn btn-primary']) ?>
    </div>

   <?php ActiveForm::end(); ?>

