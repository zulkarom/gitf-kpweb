<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\captcha\Captcha;
use backend\modules\aduan\models\AduanTopic;

/* @var $this yii\web\View */
/* @var $model backend\modules\aduan\models\Aduan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aduan-form">

    <section class="contact-page spad pt-0">
        <div class="container">
        
    <h3><?= Html::encode($this->title) ?></h3>  
    <br />

    <?php $form = ActiveForm::begin(); ?>

  
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        

                <?= $form->field($model, 'nric')->textInput(['maxlength' => true]) ?>
       
    
            <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
          

    
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
          

    
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
         

    

            <?= $form->field($model, 'topic_id')->dropDownList(
                ArrayHelper::map(AduanTopic::find()->all(),'id','topic_name'), ['prompt' => 'Pilih salah satu' ] ) ?>
          

    
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
         

    
            <?= $form->field($model, 'aduan')->textarea(['rows' => 6]) ?>
          
    
            <?= $form->field($model, 'upload_url')->fileInput() ?>
         

    <div class="row">
        <div class="col-md-6">
        Saya mengaku bahawa saya telah membaca dan memahami <b>takrif aduan</b> dan <b>Tatacara Pengaduan</b>.<br/>
        Segala maklumat diri dan maklumat perkara yang dikemukakan oleh saya adalah benar dan saya bertanggungjawab ke atasnya.
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, "declaration")->checkbox(['value' => '1', 'label'=> '']); ?>
        </div>
    </div>
  

            <?= $form->field($model, 'captcha')->textInput(['maxlength' => true]) ?>

          
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

        </div>
    </section>

</div>
