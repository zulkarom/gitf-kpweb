<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \confsite\models\SignupForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use common\models\Country;
use kartik\select2\Select2;
use richardfan\widget\JSRegister;


$this->title = 'REGISTRATION';
$this->params['breadcrumbs'][] = $this->title;

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@confsite/views/myasset');


 $form = ActiveForm::begin([
		'id' => 'form-signup',
		'enableAjaxValidation' => true,
		'enableClientValidation' => false,
		/* 'validateOnBlur' => false,
		'validateOnType' => false,
		'validateOnChange' => false, */
	]); ?>
			

				
			
				<div class="block-content">

		<div class="container">
			
			
					<div class="row">
					<div class="col-sm-1"></div>
						<div class="col-sm-12">
						
						<div class="row">
				<div class="col">
					<h2 class="section_title">REGISTRATION</h2>
					<br />
				</div>

			</div>

							<div class="section">
							
			<div class="row">
			
			
			
			
<div class="col-md-8"><?= $form
            ->field($model, 'fullname')
            ->label('Full Name')
            ->textInput() ?></div>
			
			<div class="col-md-4"><?= $form
            ->field($model, 'matric_no')
            ->textInput() ?></div>
			
			

</div>	


<div class="row">

<div class="col-md-6"><?php 
$model->email = $email;
echo $form
            ->field($model, 'email')
            ->label('Email')
            ->textInput() ?></div>
	<div class="col-md-6">
<?php 


echo $form->field($model, 'phone');


?>
	</div>

</div>		
			
			
				
				</div>

				

				
				
							<div class="row">
							<div class="col-md-6"><?= $form
				->field($model, 'password')
				->passwordInput()
                ->label('Password')?> 
	</div>
				
				<div class="col-md-6">
				
				<?= $form
				->field($model, 'password_repeat')
				->passwordInput()
                ->label('Password Repeat') ?></div>
							
							
			
		
				
				

</div>

<div class="row">
<div class="col-md-6"><?= $form
            ->field($model, 'pro_study')
           ->dropDownList($model->listProgramStudy(), ['prompt' => 'Select']) ?></div>
<div class="col-md-4"><?= $form
            ->field($model, 'cumm_sem')
            ->dropDownList($model->listSemNumber(), ['prompt' => 'Select']) ?></div>
</div>	
							



<div class="row">
<div class="col-md-6"><?= $form
            ->field($model, 'sv_main')
			->label('Main Supervisor')
            ->textInput() ?></div>
<div class="col-md-6"><?= $form
            ->field($model, 'sv_co1')
            ->textInput() ?></div>
</div>	
<div class="row">
<div class="col-md-6"><?= $form
            ->field($model, 'sv_co2')
            ->textInput() ?></div>

<div class="col-md-6"><?= $form
            ->field($model, 'sv_co3')
            ->textInput() ?></div>
</div>


<div class="row">
	<div class="col-md-6">
<?php 

$model->country_id = 158;
echo $form->field($model, 'country_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Country::find()->all(),'id', 'country_name'),
    'language' => 'en',
    'options' => ['multiple' => false,'placeholder' => 'Select a country ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('Country');


?>
	</div>

</div>			
				
				
				<div>

                
                    <?= Html::submitButton('REGISTER', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
				
				<br /><br />
		 <p>
                <?= Html::a('GO TO LOGIN PAGE',['/user/login']) ?>
            </p>
				
				</div>
				
				
				
				
				</div>
			
			
				
				
				

            <?php ActiveForm::end(); ?>
			
			
         <div>
		 
		 </div>
			
	
			</div>
</div>

<br /><br /><br />



<?php JSRegister::begin(); ?>
<script>
$("#register-form-title").change(function(){
	var val = $(this).val();
	if(val == 999){
		var html = '<input type="text" id="register-form-title" placeholder="Please specify" class="form-control" name="register-form[title]" / >';
		$("#con-title").html(html);
	}
});
</script>
<?php JSRegister::end(); ?>
