<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \staff\models\PasswordResetRequestForm */

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

$dirAssests = Yii::$app->assetManager->getPublishedUrl('@backend/assets/adminpress');

$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-logo" style="font-family:verdana">
    <b>FKP PORTAL</b>
</div>
<div class="site-request-password-reset">

     <h4 class="login-box-msg"><?= Html::encode($this->title) ?></h4>

    <p>Please fill out your student email. A link to reset password will be sent there.</p>


            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Send', ['class' => 'btn btn-info']) ?>
                </div>

            <?php ActiveForm::end(); ?>
            <br />
            
       <br>

</div>
