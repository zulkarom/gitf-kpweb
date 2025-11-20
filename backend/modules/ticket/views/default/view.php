<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use backend\modules\ticket\models\Ticket;

/* @var $this yii\web\View */
/* @var $model backend\modules\ticket\models\Ticket */
/* @var $message backend\modules\ticket\models\TicketMessage */

$this->title = 'Ticket #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'My Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-view">

    <div class="box box-solid">
        <div class="box-header">
            <h3 class="box-title">Ticket Summary</h3>
            <?php if (in_array($model->status, [0,1,2,3])): ?>
                <div class="box-tools pull-right">
                    <?= Html::a('Mark as Resolved', ['resolve', 'id' => $model->id], [
                        'class' => 'btn btn-success btn-xs',
                        'data' => [
                            'method' => 'post',
                            'confirm' => 'Mark this ticket as resolved?',
                        ],
                    ]) ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-condensed">
                        <tr>
                            <th style="width: 35%;">Ticket ID</th>
                            <td>#<?= $model->id ?></td>
                        </tr>
                        <tr>
                            <th>Title</th>
                            <td><?= Html::encode($model->title) ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td><?= $model->getStatusLabel() ?></td>
                        </tr>
                        <tr>
                            <th>Priority</th>
                            <td><?= $model->getPriorityLabel() ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-condensed">
                        <tr>
                            <th style="width: 35%;">Created At</th>
                            <td><?= Yii::$app->formatter->asDatetime($model->created_at) ?></td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td><?= Yii::$app->formatter->asDatetime($model->updated_at) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <h3>Messages</h3>
    <div class="ticket-messages">
        <?php foreach ($model->messages as $m): ?>
            <?php if ($m->is_internal) continue; ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= Html::encode($m->user ? $m->user->username : 'User') ?>
                    <span class="pull-right"><?= Yii::$app->formatter->asDatetime($m->created_at) ?></span>
                </div>
                <div class="panel-body">
                    <?= nl2br(Html::encode($m->message)) ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="box box-solid">
        <div class="box-header">
            <h3 class="box-title">Add Reply</h3>
        </div>
        <div class="box-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($message, 'message')->textarea(['rows' => 4]) ?>

    <?= $form->field($model, 'status')->dropDownList(Ticket::getUserStatusList()) ?>

    <div class="form-group">
        <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>
    </div>
</div>
