<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = $conf->conf_name;
?>

<h4 style="text-align:center; font-size:20px;">LOGIN OR REGISTER TO SUBMIT OR UPDATE YOUR PAPER.</h4>
<br /><br />
<div class="row">
    <div class="col-md-6 col-lg-6"> 
    <?php $form = ActiveForm::begin([
    'validateOnChange' => false
]); ?>

        <h5>LOGIN</h5>
        <br />

        
            <?= $form->field($modelLogin, 'username')->textInput(['class' => 'form-control form-control-lg'])
            ?>
        
          <?= $form->field($modelLogin, 'password')->passwordInput(['class' => 'form-control form-control-lg'])
            ?>

          <div class="form-group">
            <?= Html::submitButton('Log in', ['value' => '1', 'class' => 'btn btn-primary']) ?>
          </div>

      
        
        
            <?php ActiveForm::end(); ?>

            <p>
                <?= Html::a('Reset My Password',
                           ['/site/request-password-reset', 'confurl' => $conf->conf_url] ,['class' => 'field-label text-muted mb10',]
                                ) ?>
            </p>
            <br /><br />
        
    </div>





    <div class="col-md-6 col-lg-6"> 
    <?php $form = ActiveForm::begin([
      'enableClientValidation' => true,
      'enableAjaxValidation' => true,
      'validateOnChange' => true,
]); ?>
      <h5>REGISTER</h5>
       <br />
       <p>If you previously had a or already have an account with FKP Portal or Conferences managed by FKP Portal, please sign in using your credentials for that service, resetting your password if you do not recall it.</p>
       <br />
      <?php if(true){?>
 
        <?= $form->field($model, 'email')->textInput(['class' => 'form-control form-control-lg'])?>

            <?= $form->field($model, 'fullname')->textInput(['class' => 'form-control form-control-lg'])
            ?>

 
            
            
            <?= $form->field($model, 'institution')->textInput(['class' => 'form-control form-control-lg'])
            ?>
        
          <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control form-control-lg'])
            ?>
            <?= $form->field($model, 'password_repeat')->passwordInput(['class' => 'form-control form-control-lg'])
            ?>

          <div class="form-group">
            <?= Html::submitButton('Register', ['value' => '2', 'class' => 'btn btn-primary']) ?>
          </div>
        
        
     
         <?php }else{
			 
			 echo '<p>Kindly be informed that the new registration has been closed </p>';
		 } ?>
      
      <?php ActiveForm::end(); ?>
    </div>
    

</div>