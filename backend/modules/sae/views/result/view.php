<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Candidate */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Candidates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="candidate-view">

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
            'session_id',
            'username',
            'auth_key',
            'matric_no',
            'program',
            'password_hash',
            'password_reset_token',
            'email:email',
            'status',
            'can_name',
            'department',
            'can_batch',
            'can_zone',
            'finished_at',
            'answer_status',
            'answer_status2',
            'overall_status',
            'answer_last_saved',
            'question_last_saved',
            'answer_last_saved2',
            'created_at',
            'updated_at',
            'verification_token',
            'user_active',
            'user_deleted',
            'user_account_type',
            'user_has_avatar',
            'user_remember_me_token',
            'user_creation_timestamp:datetime',
            'user_suspension_timestamp:datetime',
            'user_last_login_timestamp:datetime',
            'user_failed_logins',
            'user_last_failed_login',
            'user_activation_hash',
            'user_password_reset_hash',
            'user_password_reset_timestamp:datetime',
            'user_provider_type:ntext',
        ],
    ]) ?>

</div>
