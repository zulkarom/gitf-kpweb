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

$this->title = 'FKP STAFF PORTAL LOG IN PAGE';
$this->params['breadcrumbs'][] = $this->title;


$fieldOptions1 = [
    'options' => [
	'class' => 'form-group has-feedback',
	'tabindex' => '1'
	
	],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];


?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<style>
/* Slightly bigger fonts for better readability on login */
.login-box-msg { font-size: 16px; }
#login-form .form-control { font-size: 16px; height: 42px; }
#login-form .checkbox label { font-size: 14px; }
#login-form .btn { font-size: 16px; padding: 10px 16px; }
</style>

            			
														
														
							<?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                    'validateOnType' => false,
                    'validateOnChange' => false,
                ]) ?>							

				

               <?= $form
            ->field($model, 'login', $fieldOptions1)
            //->label(false)
            ->textInput(['placeholder' => 'Staff No.']) ;?>
                    

			<?= $form
            ->field($model, 'password', $fieldOptions2)
            //->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
			
			
			<div class="row">
            <div class="col-xs-8">
                <?=$form->field($model, 'rememberMe')->checkbox(['tabindex' => '3']) ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Log in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button','tabindex' => '4']) ?>
            </div>
            <!-- /.col -->
        </div>
				
				
 

<?php ActiveForm::end(); ?>

       <?= Html::a('Recover My Password',
                           ['/user/recovery/request'],['tabindex' => '5']
                                ) ?>
		
		
		<br>
		
		<?php // Html::a('User Manual',['/user-manual'],['target' => '_blank']) ?>
		
		
		<br>




