<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use common\models\Country;


$this->title = 'JOURNAL REGISTRATION';
$this->params['breadcrumbs'][] = $this->title;

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');


 $form = ActiveForm::begin([
		'id' => 'form-signup',
		'enableAjaxValidation' => true,
		'enableClientValidation' => false,
		'validateOnBlur' => false,
		'validateOnType' => false,
		'validateOnChange' => false,
	]); ?>
			

				
<img src="<?=$directoryAsset?>/img/background-simple.jpg" width="100%" />			

			
				<div class="block-content">

		<div class="container">
			<div class="row">
				<div class="col">
					<h2 class="section_title text-center">JOURNAL REGISTRATION </h2>
				</div>

			</div>
			<br />			
					<div class="row">
						<div class="col-sm-12">

							<div class="section">
							
			<div class="row">
<div class="col-md-6"><?= $form
            ->field($model, 'fullname')
            ->label('NAME')
            ->textInput() ?></div><div class="col-md-6"><?= $form
            ->field($model, 'email')
            ->label('EMAIL')
            ->textInput() ?></div>

</div>			
			
			
				
				</div>

				

				
				
							<div class="row">
<div class="col-md-6"><?= $form
				->field($model, 'password')
				->passwordInput()
                ->label('PASSWORD')?></div>
<div class="col-md-6"><?= $form
				->field($model, 'password_repeat')
				->passwordInput()
                ->label('PASSWORD REPEAT') ?></div>
</div>
							

<div class="row">
<div class="col-md-6"><?= $form
				->field($model, 'institution')
				->textInput()
                ->label('INSTITUTION')?></div>
<div class="col-md-6"><?= $form
				->field($model, 'country_id')
				->dropDownList(
        ArrayHelper::map(Country::find()->all(),'id', 'country_name'), ['prompt' => 'Please Select' ]
    ) 

                ->label('COUNTRY') ?>
<?php 

/* echo $form->field($model, 'country_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Country::find()->all(),'id', 'country_name'),
    'language' => 'de',
    'options' => ['multiple' => false,'placeholder' => 'Select a country ...'],
])->label('COUNTRY'); */


?>				
				
				
				
				
				
				</div>
</div>							
				
				
				
				
				</div>
				</div>
			
			<div>

                
                    <?= Html::submitButton('REGISTER', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
				
				
				

            <?php ActiveForm::end(); ?>
			
			
         <div>
		 <br /><br />
		 <p>
                <?= Html::a('GO TO LOGIN PAGE',['/user/login']) ?>
            </p>
		 </div>
			
	
			</div>
</div>

<br /><br /><br />