<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';
$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>


<div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

    <style>
        .level-selector { margin-bottom: 15px; }
        .level-selector .label-title { display:block; margin-bottom:8px; font-weight:600; }
        .level-options { display:flex; gap:10px; }
        .level-option { position: relative; }
        .level-option input[type="radio"] { position: absolute; opacity: 0; pointer-events: none; }
        .level-option .pill { display:inline-block; padding:8px 14px; border:1px solid #cfd8dc; border-radius: 20px; color:#37474f; background:#fff; cursor:pointer; transition: all .15s ease; user-select:none; min-width: 150px; text-align:center; }
        .level-option .pill:hover { border-color:#90a4ae; color:#263238; }
        .level-option input[type="radio"]:checked + .pill { background:#3c8dbc; color:#fff; border-color:#3c8dbc; box-shadow: 0 2px 6px rgba(60,141,188,.3); }
        @media (max-width: 420px) { .level-options { gap:8px; } .level-option .pill { min-width: 120px; padding:8px 12px; } }
    </style>

    <div class="level-selector">
        <span class="label-title">Choose Level</span>
        <div class="level-options">
            <label class="level-option">
                <input type="radio" name="LoginForm[level]" value="UG" <?= $model->level === 'UG' ? 'checked' : '' ?>>
                <span class="pill">Undergraduate</span>
            </label>
            <label class="level-option">
                <input type="radio" name="LoginForm[level]" value="PG" <?= $model->level === 'PG' ? 'checked' : '' ?>>
                <span class="pill">Postgraduate</span>
            </label>
        </div>
    </div>

    <?= $form
        ->field($model, 'username', $fieldOptions1)
        ->label('Matric Number')
        ->textInput(['placeholder' => 'Matric Number']) ?>

    <?= $form
        ->field($model, 'password', $fieldOptions2)
        ->label('Password')
        ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

    <div class="row">
        <div class="col-xs-8">
            <?= $form->field($model, 'rememberMe')->checkbox() ?>
        </div>
        <div class="col-xs-4">
            <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <a href="<?= \yii\helpers\Url::to(['/site/request-password']) ?>">I forgot my password</a><br>

</div>
<!-- /.login-box-body -->
