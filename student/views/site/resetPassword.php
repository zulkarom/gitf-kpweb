<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \staff\models\ResetPasswordForm */

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-logo" style="font-family:verdana">
    <b>FKP PORTAL</b>
</div>
<div class="site-reset-password">

    
     <h2 class="login-box-msg">RESET PASSWORD</h2>

    <p>Please choose your new password:</p>


            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-info']) ?>
                </div>

            <?php ActiveForm::end(); ?>

</div>
