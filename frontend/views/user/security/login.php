<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\widgets\Connect;
use dektrium\user\models\LoginForm;
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module $module
 */

$this->title = 'JEB - LOGIN PAGE';
$this->params['breadcrumbs'][] = $this->title;



$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];


?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>


                
	<img src="<?=$directoryAsset?>/img/background-simple.jpg" width="100%" />			

			
				<div class="block-content">

		<div class="container">
			<div class="row">
				<div class="col">
					<h2 class="section_title text-center">LOGIN PAGE </h2>
				</div>

			</div>
			<br /><div style="padding-top:0px">
					<div class="row">
					<div class="col-sm-3"></div>
						<div class="col-sm-6">
														<div class="section">
										
														
														
														
							<?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                    'validateOnType' => false,
                    'validateOnChange' => false,
                ]) ?>							

                <?php if ($module->debug): ?>
                    <?= $form->field($model, 'login', [
                        'inputOptions' => [
                            'autofocus' => 'autofocus',
                            'class' => 'form-control',
                            'tabindex' => '1']])->dropDownList(LoginForm::loginList());
                    ?>

                <?php else: ?>
				

<?php 
$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='fa fa-envelope form-control-feedback'></span>"
];
?>

               <?=$form->field($model, 'login')
						->label('EMAIL')
            ->textInput()
                    ;
                    ?>
					
					</div>
							<div class="section">

                <?php endif ?>

                <?php if ($module->debug): ?>
                    <div class="alert alert-warning">
                        <?= Yii::t('user', 'Password is not necessary because the module is in DEBUG mode.'); ?>
                    </div>
                <?php else: ?>
				
                    <?= $form->field(
                        $model,
                        'password')
                        ->passwordInput()
                         ->label('PASSWORD')
                           
                         ?>
                <?php endif ?>

                <?php /// $form->field($model, 'rememberMe')->checkbox(['tabindex' => '3']) ?>
				
				
				 <?= Html::submitButton(
                    Yii::t('user', 'LOG IN'),
                    ['class' => 'btn btn-primary']
                ) ?>
				
				</div>
				</div>
				</div>
							<!-- end section -->
							
	

                

<?php ActiveForm::end(); ?>


				<br />
         <div class="panel-footer clearfix p10 ph15">
        
        <?php if ($module->enableRegistration): ?>
            <p class="text-center">
                <?= Html::a('SIGN UP / REGISTRATION', ['/user/registration/register'], ['class' => 'field-label text-muted mb10']) ?>
            </p>
        <?php endif ?>
		
		<?php if ($module->enablePasswordRecovery): ?>
            <p class="text-center">
                <?= Html::a('FORGOT PASSWORD',
                           ['/user/recovery/request'],['class' => 'field-label text-muted mb10', 'tabindex' => '5']
                                ) ?>
            </p>
        <?php endif ?>
		
		<?php if ($module->enableConfirmation): ?>
            <p class="text-center">
                <?= Html::a('RESEND EMAIL CONFIRMATION', ['/user/registration/resend'],['class' => 'field-label text-muted mb10', 'tabindex' => '6']) ?>
            </p>
        <?php endif ?>
		
		
		
		
		
        <?= Connect::widget([
            'baseAuthUrl' => ['/user/security/auth'],
        ]) ?>
		
		</div>
		
				</div>			</div>
</div>
				
				



