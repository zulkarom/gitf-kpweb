<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\jeb\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'manuscript_no',
            'user_id',
            'title:ntext',
            'keyword:ntext',
            'abstract:ntext',
            'reference:ntext',
            'scope_id',
            'status',
            'submission_file',
            'updated_at',
            'draft_at',
            'submit_at',
            'pre_evaluate_at',
            'pre_evaluate_by',
            'associate_editor',
            'review_file',
            'pre_evaluate_note:ntext',
            'asgn_reviewer_at',
            'asgn_reviewer_by',
            'review_at',
            'recommend_by',
            'recommend_at',
            'recommend_note:ntext',
            'recommend_option',
            'evaluate_option',
            'evaluate_note:ntext',
            'evaluate_by',
            'evaluate_at',
            'response_by',
            'response_at',
            'response_note:ntext',
            'correction_at',
            'correction_note:ntext',
            'correction_file',
            'post_evaluate_by',
            'post_evaluate_at',
            'assistant_editor',
            'galley_proof_at',
            'galley_proof_by',
            'galley_proof_note:ntext',
            'galley_file',
            'finalise_at',
            'finalise_option',
            'finalise_note:ntext',
            'finalise_file',
            'asgn_profrdr_at',
            'asgn_profrdr_by',
            'asgn_profrdr_note:ntext',
            'proof_reader',
            'post_finalise_at',
            'post_finalise_by',
            'postfinalise_file',
            'post_finalise_note:ntext',
            'proofread_at',
            'proofread_by',
            'proofread_note:ntext',
            'proofread_file',
            'camera_ready_at',
            'camera_ready_by',
            'camera_ready_note:ntext',
            'cameraready_file',
            'journal_at',
            'journal_by',
            'journal_id',
            'reject_at',
            'reject_by',
            'reject_note:ntext',
            'publish_number',
            'withdraw_by',
            'withdraw_at_status',
            'withdraw_at',
            'withdraw_note:ntext',
            'withdraw_request_at',
        ],
    ]) ?>

</div>
