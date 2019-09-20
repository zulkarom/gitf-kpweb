<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\journal\models\ArticleOverwriteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-overwrite-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'journal_id') ?>

    <?= $form->field($model, 'manuscript_no') ?>

    <?= $form->field($model, 'yearly_number') ?>

    <?= $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'pay_amount') ?>

    <?php // echo $form->field($model, 'is_paid') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'keyword') ?>

    <?php // echo $form->field($model, 'abstract') ?>

    <?php // echo $form->field($model, 'reference') ?>

    <?php // echo $form->field($model, 'scope_id') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'submission_file') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'draft_at') ?>

    <?php // echo $form->field($model, 'submit_at') ?>

    <?php // echo $form->field($model, 'pre_evaluate_at') ?>

    <?php // echo $form->field($model, 'pre_evaluate_by') ?>

    <?php // echo $form->field($model, 'payment_submit_at') ?>

    <?php // echo $form->field($model, 'payment_file') ?>

    <?php // echo $form->field($model, 'payment_note') ?>

    <?php // echo $form->field($model, 'payment_amount') ?>

    <?php // echo $form->field($model, 'payment_verified_at') ?>

    <?php // echo $form->field($model, 'associate_editor') ?>

    <?php // echo $form->field($model, 'review_file') ?>

    <?php // echo $form->field($model, 'pre_evaluate_note') ?>

    <?php // echo $form->field($model, 'asgn_reviewer_at') ?>

    <?php // echo $form->field($model, 'asgn_associate_at') ?>

    <?php // echo $form->field($model, 'asgn_reviewer_by') ?>

    <?php // echo $form->field($model, 'review_at') ?>

    <?php // echo $form->field($model, 'review_submit_at') ?>

    <?php // echo $form->field($model, 'recommend_by') ?>

    <?php // echo $form->field($model, 'recommend_at') ?>

    <?php // echo $form->field($model, 'recommend_note') ?>

    <?php // echo $form->field($model, 'recommend_option') ?>

    <?php // echo $form->field($model, 'evaluate_option') ?>

    <?php // echo $form->field($model, 'evaluate_note') ?>

    <?php // echo $form->field($model, 'evaluate_by') ?>

    <?php // echo $form->field($model, 'evaluate_at') ?>

    <?php // echo $form->field($model, 'response_by') ?>

    <?php // echo $form->field($model, 'response_at') ?>

    <?php // echo $form->field($model, 'response_note') ?>

    <?php // echo $form->field($model, 'response_option') ?>

    <?php // echo $form->field($model, 'correction_at') ?>

    <?php // echo $form->field($model, 'correction_note') ?>

    <?php // echo $form->field($model, 'correction_file') ?>

    <?php // echo $form->field($model, 'post_evaluate_by') ?>

    <?php // echo $form->field($model, 'post_evaluate_at') ?>

    <?php // echo $form->field($model, 'assistant_editor') ?>

    <?php // echo $form->field($model, 'galley_proof_at') ?>

    <?php // echo $form->field($model, 'galley_proof_by') ?>

    <?php // echo $form->field($model, 'galley_proof_note') ?>

    <?php // echo $form->field($model, 'galley_file') ?>

    <?php // echo $form->field($model, 'finalise_at') ?>

    <?php // echo $form->field($model, 'finalise_option') ?>

    <?php // echo $form->field($model, 'finalise_note') ?>

    <?php // echo $form->field($model, 'finalise_file') ?>

    <?php // echo $form->field($model, 'asgn_profrdr_at') ?>

    <?php // echo $form->field($model, 'asgn_profrdr_by') ?>

    <?php // echo $form->field($model, 'asgn_profrdr_note') ?>

    <?php // echo $form->field($model, 'proof_reader') ?>

    <?php // echo $form->field($model, 'post_finalise_at') ?>

    <?php // echo $form->field($model, 'post_finalise_by') ?>

    <?php // echo $form->field($model, 'postfinalise_file') ?>

    <?php // echo $form->field($model, 'post_finalise_note') ?>

    <?php // echo $form->field($model, 'proofread_at') ?>

    <?php // echo $form->field($model, 'proofread_by') ?>

    <?php // echo $form->field($model, 'proofread_note') ?>

    <?php // echo $form->field($model, 'proofread_file') ?>

    <?php // echo $form->field($model, 'camera_ready_at') ?>

    <?php // echo $form->field($model, 'camera_ready_by') ?>

    <?php // echo $form->field($model, 'camera_ready_note') ?>

    <?php // echo $form->field($model, 'cameraready_file') ?>

    <?php // echo $form->field($model, 'assign_journal_at') ?>

    <?php // echo $form->field($model, 'journal_at') ?>

    <?php // echo $form->field($model, 'journal_by') ?>

    <?php // echo $form->field($model, 'journal_issue_id') ?>

    <?php // echo $form->field($model, 'reject_at') ?>

    <?php // echo $form->field($model, 'reject_by') ?>

    <?php // echo $form->field($model, 'reject_note') ?>

    <?php // echo $form->field($model, 'publish_number') ?>

    <?php // echo $form->field($model, 'doi_ref') ?>

    <?php // echo $form->field($model, 'withdraw_by') ?>

    <?php // echo $form->field($model, 'withdraw_at_status') ?>

    <?php // echo $form->field($model, 'withdraw_at') ?>

    <?php // echo $form->field($model, 'withdraw_note') ?>

    <?php // echo $form->field($model, 'withdraw_request_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
