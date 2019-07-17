<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\jeb\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'manuscript_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'keyword')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'abstract')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'reference')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'scope_id')->textInput() ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'submission_file')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'draft_at')->textInput() ?>

    <?= $form->field($model, 'submit_at')->textInput() ?>

    <?= $form->field($model, 'pre_evaluate_at')->textInput() ?>

    <?= $form->field($model, 'pre_evaluate_by')->textInput() ?>

    <?= $form->field($model, 'associate_editor')->textInput() ?>

    <?= $form->field($model, 'pre_evaluate_note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'asgn_reviewer_at')->textInput() ?>

    <?= $form->field($model, 'asgn_reviewer_by')->textInput() ?>

    <?= $form->field($model, 'review_at')->textInput() ?>

    <?= $form->field($model, 'recommend_by')->textInput() ?>

    <?= $form->field($model, 'recommend_at')->textInput() ?>

    <?= $form->field($model, 'recommend_note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'recommend_option')->textInput() ?>

    <?= $form->field($model, 'evaluate_by')->textInput() ?>

    <?= $form->field($model, 'evaluate_at')->textInput() ?>

    <?= $form->field($model, 'response_by')->textInput() ?>

    <?= $form->field($model, 'response_at')->textInput() ?>

    <?= $form->field($model, 'response_note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'correction_at')->textInput() ?>

    <?= $form->field($model, 'correction_note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'correction_file')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'post_evaluate_by')->textInput() ?>

    <?= $form->field($model, 'post_evaluate_at')->textInput() ?>

    <?= $form->field($model, 'assistant_editor')->textInput() ?>

    <?= $form->field($model, 'galley_proof_at')->textInput() ?>

    <?= $form->field($model, 'galley_proof_by')->textInput() ?>

    <?= $form->field($model, 'galley_proof_note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'galley_file')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'finalise_at')->textInput() ?>

    <?= $form->field($model, 'finalise_option')->textInput() ?>

    <?= $form->field($model, 'finalise_note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'finalise_file')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'asgn_profrdr_at')->textInput() ?>

    <?= $form->field($model, 'asgn_profrdr_by')->textInput() ?>

    <?= $form->field($model, 'asgn_profrdr_note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'proof_reader')->textInput() ?>

    <?= $form->field($model, 'post_finalise_at')->textInput() ?>

    <?= $form->field($model, 'post_finalise_by')->textInput() ?>

    <?= $form->field($model, 'postfinalise_file')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'post_finalise_note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'proofread_at')->textInput() ?>

    <?= $form->field($model, 'proofread_by')->textInput() ?>

    <?= $form->field($model, 'proofread_note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'proofread_file')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'camera_ready_at')->textInput() ?>

    <?= $form->field($model, 'camera_ready_by')->textInput() ?>

    <?= $form->field($model, 'camera_ready_note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'cameraready_file')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'journal_at')->textInput() ?>

    <?= $form->field($model, 'journal_by')->textInput() ?>

    <?= $form->field($model, 'journal_id')->textInput() ?>

    <?= $form->field($model, 'reject_note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'publish_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'withdraw_by')->textInput() ?>

    <?= $form->field($model, 'withdraw_at')->textInput() ?>

    <?= $form->field($model, 'withdraw_note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'withdraw_request_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
