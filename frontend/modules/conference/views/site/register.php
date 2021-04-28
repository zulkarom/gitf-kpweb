<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \ijeob\models\SignupForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use common\models\Country;
use kartik\select2\Select2;
use richardfan\widget\JSRegister;


$this->title = 'JOURNAL REGISTRATION';
$this->params['breadcrumbs'][] = $this->title;

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@ijeob/views/myasset');


 $form = ActiveForm::begin([
		'id' => 'form-signup'
	]); ?>
			

	
			
				<div class="block-content">

		<div class="container">
			
			<br />			
					<div class="row">
					
						<div class="col-sm-12">
						
						<div class="row">
				<div class="col">
					<h4 class="section_title">REGISTRATION </h4>
					<br />
				</div>

			</div>

							<div class="section">
							
			<div class="row">
			
			<div class="col-md-4"><?= $form
            ->field($model, 'title', ['template' => '{label}<div id="con-title">{input}</div>{error}']
)
            ->label('Title')
            ->dropDownList($model->defaultTitle()) ?></div>
			
			
<div class="col-md-8"><?= $form
            ->field($model, 'fullname')
            ->label('Name')
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
			
			
				
				</div>

				

				
				
							<div class="row">
							<div class="col-md-4"><?= $form
				->field($model, 'password')
				->passwordInput()
                ->label('Password')?> 
	</div>
				
				<div class="col-md-4">
				
				<?= $form
				->field($model, 'password_repeat')
				->passwordInput()
                ->label('Password Repeat') ?></div>
							
							
			
		
				
				

</div>
							

<div class="row">
<div class="col-md-6"><?= $form
				->field($model, 'institution')
				->textarea(['rows' => 2])
                ->label('Institution')?></div>
	

<div class="col-md-6"><?= $form
				->field($model, 'assoc_address')
				->textarea(['rows' => 2])
                ->label('Address')?>
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
$("#signupform-title").change(function(){
	var val = $(this).val();
	if(val == 999){
		var html = '<input type="text" id="signupform-title" placeholder="Please specify" class="form-control" name="signupform[title]" / >';
		$("#con-title").html(html);
	}
});
</script>
<?php JSRegister::end(); ?>
