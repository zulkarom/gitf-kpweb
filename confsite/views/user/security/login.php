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

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@confsite/views/myasset');

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module $module
 */

$this->title = 'CONFERENCE MANAGER - LOGIN PAGE';
$this->params['breadcrumbs'][] = $this->title;



$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='fa fa-envelope form-control-feedback'></span>"
];
?>

<?= $this->render('../_alert', ['module' => Yii::$app->getModule('user')]) ?>




<div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                confsite MANAGER
                            </a>
                        </div>
                        <div class="login-form">
                           	<?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                    'validateOnType' => false,
                    'validateOnChange' => false,
                ]) ?>	
				
				<?=$form->field($model, 'login')
											->label('Email Address')
								->textInput()
										;
										?>
										
				
								
								<?= $form->field(
                        $model,
                        'password')
                        ->passwordInput()
                         ->label('Password')
                           
                         ?>
						 
						 
                                <div class="login-checkbox">
								<?=$form->field($model, 'rememberMe')->checkbox(['tabindex' => '3'])->label('Remember Me') ?>
                                    
                          
                                </div>
                      
								
								<?= Html::submitButton(
                    Yii::t('user', 'LOG IN'),
                    ['class' => 'au-btn au-btn--block au-btn--green m-b-20']
                ) ?>
                                
                            <?php ActiveForm::end(); ?>
                           
                        </div>
                    </div>
					

		
		<?php if ($module->enablePasswordRecovery): ?>
            <p class="text-center">
                <?= Html::a('FORGOT PASSWORD',['/user/recovery/request']) ?>
            </p>
        <?php endif ?>
		

					
					
                </div>
				
				
				<br />	<br />	<br />
