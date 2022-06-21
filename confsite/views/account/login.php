<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Application;

$dirAssests = Yii::$app->assetManager->getPublishedUrl('@frontend/assets/swissAsset');

$this->title = 'Sign Up/Sign In';
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="wrapper row3">
  <main class="hoc container clear" style="padding-top:40px;"> 
  
  <h4 style="padding-bottom:40px;text-align:center">LOGIN OR REGISTER TO SUBMIT OR VIEW YOUR APPLICATION.</h4>
  
    <!-- main body -->
    <!-- ################################################################################################ -->

 <?php $form = ActiveForm::begin([
    'validateOnChange' => false
]); ?>
    <div class="sidebar one_half first"> 
        <h3>LOGIN</h3>
        <br />
        <div class="row">
        <div class="col-md-10">
        
            <?= $form->field($modelLogin, 'username')->textInput(['class' => 'form-control form-control-lg'])
            ?>
        
          <?= $form->field($modelLogin, 'password')->passwordInput(['class' => 'form-control form-control-lg'])
            ?>

          <div class="form-group">
            <?= Html::submitButton('<i class="fas fa-sign-in-alt"></i> Log in', ['value' => '1', 'class' => 'btn btn-outline-danger']) ?>
          </div>

          <p>
                <?= Html::a('Forget Password?',
                           ['/site/request-password-reset'],['class' => 'field-label text-muted mb10',]
                                ) ?>
            </p>
        
        
        </div>
        <div></div>
        </div>
        
    </div>

<?php ActiveForm::end(); ?>


 <?php $form = ActiveForm::begin([
    'validateOnChange' => false
]); ?>
    <div class="content one_half"> 

      <h3>REGISTER</h3>
       <br />
      <?php if(Application::isOpen()){?>
      <div class="row">
        <div class="col-md-10">
        
       

            <?= $form->field($model, 'fullname')->textInput(['class' => 'form-control form-control-lg'])
            ?>

   <?= $form->field($model, 'email')->textInput(['class' => 'form-control form-control-lg'])?>
            
            
            <?= $form->field($model, 'institution')->textInput(['class' => 'form-control form-control-lg'])
            ?>
        
          <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control form-control-lg'])
            ?>
            <?= $form->field($model, 'password_repeat')->passwordInput(['class' => 'form-control form-control-lg'])
            ?>

          <div class="form-group">
            <?= Html::submitButton('<i class="fas fa-sign-in-alt"></i> Register', ['value' => '2', 'class' => 'btn btn-outline-danger']) ?>
          </div>
        
        
        </div>
        
        </div>
         <?php }else{
			 
			 echo '<p>Kindly be informed that the new registration has been closed </p>';
		 } ?>
      
      
    
      <!-- ################################################################################################ -->
    </div>
    <?php ActiveForm::end(); ?>
    <!-- ################################################################################################ -->
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>


