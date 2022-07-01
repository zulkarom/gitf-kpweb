<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Answer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="answer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'can_id')->textInput() ?>

    <?= $form->field($model, 'bat_id')->textInput() ?>

    <?= $form->field($model, 'column1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'column2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'column3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'finished_at')->textInput() ?>

    <?= $form->field($model, 'answer_status')->textInput() ?>

    <?= $form->field($model, 'answer_status2')->textInput() ?>

    <?= $form->field($model, 'overall_status')->textInput() ?>

    <?= $form->field($model, 'answer_last_saved')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'question_last_saved')->textInput() ?>

    <?= $form->field($model, 'answer_last_saved2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'q1')->textInput() ?>

    <?= $form->field($model, 'q2')->textInput() ?>

    <?= $form->field($model, 'q3')->textInput() ?>

    <?= $form->field($model, 'q4')->textInput() ?>

    <?= $form->field($model, 'q5')->textInput() ?>

    <?= $form->field($model, 'q6')->textInput() ?>

    <?= $form->field($model, 'q7')->textInput() ?>

    <?= $form->field($model, 'q8')->textInput() ?>

    <?= $form->field($model, 'q9')->textInput() ?>

    <?= $form->field($model, 'q10')->textInput() ?>

    <?= $form->field($model, 'q11')->textInput() ?>

    <?= $form->field($model, 'q12')->textInput() ?>

    <?= $form->field($model, 'q13')->textInput() ?>

    <?= $form->field($model, 'q14')->textInput() ?>

    <?= $form->field($model, 'q15')->textInput() ?>

    <?= $form->field($model, 'q16')->textInput() ?>

    <?= $form->field($model, 'q17')->textInput() ?>

    <?= $form->field($model, 'q18')->textInput() ?>

    <?= $form->field($model, 'q19')->textInput() ?>

    <?= $form->field($model, 'q20')->textInput() ?>

    <?= $form->field($model, 'q21')->textInput() ?>

    <?= $form->field($model, 'q22')->textInput() ?>

    <?= $form->field($model, 'q23')->textInput() ?>

    <?= $form->field($model, 'q24')->textInput() ?>

    <?= $form->field($model, 'q25')->textInput() ?>

    <?= $form->field($model, 'q26')->textInput() ?>

    <?= $form->field($model, 'q27')->textInput() ?>

    <?= $form->field($model, 'q28')->textInput() ?>

    <?= $form->field($model, 'q29')->textInput() ?>

    <?= $form->field($model, 'q30')->textInput() ?>

    <?= $form->field($model, 'q31')->textInput() ?>

    <?= $form->field($model, 'q32')->textInput() ?>

    <?= $form->field($model, 'q33')->textInput() ?>

    <?= $form->field($model, 'q34')->textInput() ?>

    <?= $form->field($model, 'q35')->textInput() ?>

    <?= $form->field($model, 'q36')->textInput() ?>

    <?= $form->field($model, 'q37')->textInput() ?>

    <?= $form->field($model, 'q38')->textInput() ?>

    <?= $form->field($model, 'q39')->textInput() ?>

    <?= $form->field($model, 'q40')->textInput() ?>

    <?= $form->field($model, 'q41')->textInput() ?>

    <?= $form->field($model, 'q42')->textInput() ?>

    <?= $form->field($model, 'q43')->textInput() ?>

    <?= $form->field($model, 'q44')->textInput() ?>

    <?= $form->field($model, 'q45')->textInput() ?>

    <?= $form->field($model, 'q46')->textInput() ?>

    <?= $form->field($model, 'q47')->textInput() ?>

    <?= $form->field($model, 'q48')->textInput() ?>

    <?= $form->field($model, 'q49')->textInput() ?>

    <?= $form->field($model, 'q50')->textInput() ?>

    <?= $form->field($model, 'q51')->textInput() ?>

    <?= $form->field($model, 'q52')->textInput() ?>

    <?= $form->field($model, 'q53')->textInput() ?>

    <?= $form->field($model, 'q54')->textInput() ?>

    <?= $form->field($model, 'q55')->textInput() ?>

    <?= $form->field($model, 'q56')->textInput() ?>

    <?= $form->field($model, 'q57')->textInput() ?>

    <?= $form->field($model, 'q58')->textInput() ?>

    <?= $form->field($model, 'q59')->textInput() ?>

    <?= $form->field($model, 'q60')->textInput() ?>

    <?= $form->field($model, 'q61')->textInput() ?>

    <?= $form->field($model, 'q62')->textInput() ?>

    <?= $form->field($model, 'q63')->textInput() ?>

    <?= $form->field($model, 'q64')->textInput() ?>

    <?= $form->field($model, 'q65')->textInput() ?>

    <?= $form->field($model, 'q66')->textInput() ?>

    <?= $form->field($model, 'q67')->textInput() ?>

    <?= $form->field($model, 'q68')->textInput() ?>

    <?= $form->field($model, 'q69')->textInput() ?>

    <?= $form->field($model, 'q70')->textInput() ?>

    <?= $form->field($model, 'q71')->textInput() ?>

    <?= $form->field($model, 'q72')->textInput() ?>

    <?= $form->field($model, 'q73')->textInput() ?>

    <?= $form->field($model, 'q74')->textInput() ?>

    <?= $form->field($model, 'q75')->textInput() ?>

    <?= $form->field($model, 'q76')->textInput() ?>

    <?= $form->field($model, 'q77')->textInput() ?>

    <?= $form->field($model, 'q78')->textInput() ?>

    <?= $form->field($model, 'q79')->textInput() ?>

    <?= $form->field($model, 'q80')->textInput() ?>

    <?= $form->field($model, 'q81')->textInput() ?>

    <?= $form->field($model, 'q82')->textInput() ?>

    <?= $form->field($model, 'q83')->textInput() ?>

    <?= $form->field($model, 'q84')->textInput() ?>

    <?= $form->field($model, 'q85')->textInput() ?>

    <?= $form->field($model, 'q86')->textInput() ?>

    <?= $form->field($model, 'q87')->textInput() ?>

    <?= $form->field($model, 'q88')->textInput() ?>

    <?= $form->field($model, 'q89')->textInput() ?>

    <?= $form->field($model, 'q90')->textInput() ?>

    <?= $form->field($model, 'q91')->textInput() ?>

    <?= $form->field($model, 'q92')->textInput() ?>

    <?= $form->field($model, 'q93')->textInput() ?>

    <?= $form->field($model, 'q94')->textInput() ?>

    <?= $form->field($model, 'q95')->textInput() ?>

    <?= $form->field($model, 'q96')->textInput() ?>

    <?= $form->field($model, 'q97')->textInput() ?>

    <?= $form->field($model, 'q98')->textInput() ?>

    <?= $form->field($model, 'q99')->textInput() ?>

    <?= $form->field($model, 'q100')->textInput() ?>

    <?= $form->field($model, 'q101')->textInput() ?>

    <?= $form->field($model, 'q102')->textInput() ?>

    <?= $form->field($model, 'q103')->textInput() ?>

    <?= $form->field($model, 'q104')->textInput() ?>

    <?= $form->field($model, 'q105')->textInput() ?>

    <?= $form->field($model, 'q106')->textInput() ?>

    <?= $form->field($model, 'q107')->textInput() ?>

    <?= $form->field($model, 'q108')->textInput() ?>

    <?= $form->field($model, 'q109')->textInput() ?>

    <?= $form->field($model, 'q110')->textInput() ?>

    <?= $form->field($model, 'q111')->textInput() ?>

    <?= $form->field($model, 'q112')->textInput() ?>

    <?= $form->field($model, 'q113')->textInput() ?>

    <?= $form->field($model, 'q114')->textInput() ?>

    <?= $form->field($model, 'q115')->textInput() ?>

    <?= $form->field($model, 'q116')->textInput() ?>

    <?= $form->field($model, 'q117')->textInput() ?>

    <?= $form->field($model, 'q118')->textInput() ?>

    <?= $form->field($model, 'q119')->textInput() ?>

    <?= $form->field($model, 'q120')->textInput() ?>

    <?= $form->field($model, 'biz_idea')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
