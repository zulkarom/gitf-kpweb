<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model student\models\forms\ForgotPasswordRequestForm */

$this->title = 'Account Recovery';
?>
<div class="login-box-body">
    <p class="login-box-msg">Verify your identity to set a new password</p>

    <?php $form = ActiveForm::begin(['id' => 'request-password-form']); ?>

        <?= $form->field($model, 'matric_no')->textInput(['maxlength' => true, 'placeholder' => 'Matric Number']) ?>

        <?= $form->field($model, 'nric')->textInput(['maxlength' => true, 'placeholder' => 'I.C Number']) ?>

        <div class="row">
            <div class="col-xs-8">
                <a href="<?= yii\helpers\Url::to(['/site/login']) ?>">Back to Sign In</a>
            </div>
            <div class="col-xs-4">
                <?= Html::submitButton('Continue', ['class' => 'btn btn-primary btn-block btn-flat']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>
