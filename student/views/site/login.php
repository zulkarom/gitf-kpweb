<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';
$dirAsset = Yii::$app->assetManager->getPublishedUrl('@student/assets/adminlte');
$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>



   
<section class="contact-page spad pt-0">
        <div class="container">


<div class="row">
	<div class="col-md-6 d-none d-sm-none d-md-block">
	<img src="<?=$dirAsset?>/images/login.jpg" />
	
	</div>
	<div class="col-md-4">
	
	
	<div class="login-logo" style="font-family:verdana">
       <span style="font-size:25px">STUDENT LOGIN</span>
    </div>

    <!-- /.login-logo -->
        <p class="login-box-msg">Log in to start your session</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => 'Matric Number']) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

  
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
    
                <?= Html::submitButton('Sign in', ['class' => 'btn btn-block btn-flat', 'style' => 'background-color:#353b87;color:white']) ?>




        <?php ActiveForm::end(); ?>
		
		<div class="form-group">
 <br /> <?= Html::a('Recover My Password',['/site/request-password-reset']) ?><br>
</div>
	
	
	
	</div>
</div>




       


	        </div>
    </section>


