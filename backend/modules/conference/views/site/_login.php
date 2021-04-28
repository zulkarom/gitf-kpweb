<?php $form = ActiveForm::begin([
	'id' => 'login-form',
	'action' => ['/user/login'],
	'enableAjaxValidation' => true,
	'enableClientValidation' => false,
	'validateOnBlur' => false,
	'validateOnType' => false,
	'validateOnChange' => false,
]) ?>
<div class="row register_row">
	<div class="col-lg-3 register_col">
		<div class="register_form_title">GO TO MY PAGE</div>
	</div>

	<div class="col-lg-3 register_col">
	
	<?=$form->field($model, 'login')
	->textInput()
	->input('email', ['placeholder' => "Email"])
                    ;
                    ?>
	

		
		
	</div>
	<div class="col-lg-3 register_col">
		<input type="tel" class="form_input" placeholder="Password">
	</div>
	<div class="col-lg-3">
		<button type="submit" class="form_button trans_200">LOG IN</button>
		
		<div style="text-align:center; margin-top:10px;">Forgot Password</div>
	</div>
</div>
 <?php ActiveForm::end(); ?>