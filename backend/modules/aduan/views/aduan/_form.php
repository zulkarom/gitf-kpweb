<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\aduan\models\AduanTopic;
use yii\helpers\ArrayHelper;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $model backend\modules\aduan\models\Aduan */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="box">
<div class="box-body">
<div class="aduan-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'nric')->textInput(['maxlength' => true]) ?>
         </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'address')->textarea(['rows' => 6]) ?>
          </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
          </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
          </div>
    </div>

    <div class="row">
        <div class="col-md-4">

            <?= $form->field($model, 'topic_id')->dropDownList(
                ArrayHelper::map(AduanTopic::find()->all(),'id','topic_name'), ['prompt' => 'Pilih salah satu' ] ) ?>
          </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
          </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'aduan')->textarea(['rows' => 6]) ?>
          </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'upload_url')->fileInput() ?>
          </div>
    </div>

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
  
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'captcha')->textInput(['maxlength' => true]) ?>

          </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
