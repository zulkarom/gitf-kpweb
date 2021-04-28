<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'CONFVALLEY - LOGIN PAGE';
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="row">
<div class="col-md-8">

<div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                               <h4 class="m-text23 p-t-56 p-b-34">LOGIN FORM</h4>
                            </a>
                        </div>
                        <div class="login-form">
                           	<?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                ]) ?>	
				
				<?=$form->field($model, 'username')
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
                    ['class' => 'btn btn-primary']
                ) ?>
                                
                            <?php ActiveForm::end(); ?>
                           
                        </div>
                    </div>
					

		

            <p class="text-center">
                <?= Html::a('FORGOT PASSWORD',['/user/recovery/request', 'url' => $conf->conf_url]) ?>
            </p>

		

					
					
                </div>


</div>

</div>



				
				
				<br />	<br />	<br />
