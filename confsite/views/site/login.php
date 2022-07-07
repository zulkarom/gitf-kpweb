<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Country;
use kartik\select2\Select2;

$this->title = $conf->conf_name;
?>

<h4 style="text-align:center; font-size:20px;margin-top:20px;font-weight:bold">LOGIN OR REGISTER TO SUBMIT OR UPDATE YOUR PAPER.</h4>
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
        <?php  
if($conf->is_pg == 0){
    echo $form->field($model, 'title')->textInput(['class' => 'form-control form-control-lg']) ;
}
?>

        <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control form-control-lg'])
            ?>
            <?= $form->field($model, 'password_repeat')->passwordInput(['class' => 'form-control form-control-lg'])
            ?>

            

<?php  
if($conf->is_pg == 1){
    echo $form->field($model, 'matric_no')->textInput(['class' => 'form-control form-control-lg']) ;
   
?>


<?=$form->field($model, 'phone')->textInput(['class' => 'form-control form-control-lg']) ;
   

?>

<?= $form
            ->field($model, 'pro_study')
           ->dropDownList($model->listProgramStudy(), ['prompt' => 'Select', 'class' => 'form-control form-control-lg']) ?>
           
           <?= $form
            ->field($model, 'cumm_sem')
            ->dropDownList($model->listSemNumber(), ['prompt' => 'Select', 'class' => 'form-control form-control-lg']) ?>

<?= $form
            ->field($model, 'sv_main')
			->label('Main Supervisor')
            ->textInput(['class' => 'form-control form-control-lg']) ?>
            <?= $form
            ->field($model, 'sv_co1')
            ->textInput(['class' => 'form-control form-control-lg']) ?>
            <?= $form
            ->field($model, 'sv_co2')
            ->textInput(['class' => 'form-control form-control-lg']) ?>
            <?= $form
            ->field($model, 'sv_co3')
            ->textInput(['class' => 'form-control form-control-lg']) ?>
            

        
<?php }else{ ?>   
    
    <?= $form->field($model, 'institution')->textInput(['class' => 'form-control form-control-lg'])
            ?>

<?php 

$model->country_id = 158;
echo $form->field($model, 'country_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Country::find()->all(),'id', 'country_name'),
    'language' => 'en',
    'options' => ['multiple' => false,'placeholder' => 'Select a country ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('Country');


?>

    <?php } ?>   

          <div class="form-group">
            <?= Html::submitButton('Register', ['value' => '2', 'class' => 'btn btn-primary']) ?>
          </div>
        
        
     
         <?php }else{
			 
			 echo '<p>Kindly be informed that the new registration has been closed </p>';
		 } ?>
      
      <?php ActiveForm::end(); ?>
    </div>
    

</div>