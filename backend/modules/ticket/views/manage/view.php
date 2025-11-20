<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\select2\Select2;
use backend\modules\ticket\models\Ticket;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model backend\modules\ticket\models\Ticket */
/* @var $message backend\modules\ticket\models\TicketMessage */
/* @var $categories backend\modules\ticket\models\TicketCategory[] */

$this->title = 'Manage Ticket #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'All Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$categoryItems = ArrayHelper::map($categories, 'id', 'name');
?>
<div class="ticket-manage-view">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-solid">
        <div class="box-header">
            <h3 class="box-title">Ticket Summary</h3>
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
                            <th style="width: 35%;">Send By</th>
                            <td><?= $model->creator && $model->creator->fullname
                                    ? $model->creator->fullname
                                    : $model->created_by ?></td>
                        </tr>
                        <tr>
                            <th>Assigned To</th>
                            <td><?= $model->assignee && $model->assignee->fullname
                                    ? $model->assignee->fullname
                                    : ($model->assignee ? $model->assignee->username : '-') ?></td>
                        </tr>
                        <tr>
                            <th>Created At</th>
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


    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Update Ticket</h3>
        </div>
        <div class="box-body">

  

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'category_id')->dropDownList($categoryItems, ['prompt' => 'Select Category']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'assigned_to')->widget(Select2::class, [
                'initValueText' => $model->assignee && $model->assignee->fullname
                    ? $model->assignee->fullname
                    : null,
                'options' => ['placeholder' => 'Not Assigned'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 2,
                    'ajax' => [
                        'url' => Url::to(['staff-list']),
                        'dataType' => 'json',
                        'delay' => 250,
                        'data' => new \yii\web\JsExpression('function(params) { return {q: params.term}; }'),
                        'processResults' => new \yii\web\JsExpression('function(data) { return data; }'),
                    ],
                ],
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'priority')->dropDownList(Ticket::getPriorityList()) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'status')->dropDownList(Ticket::getStatusList()) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save Changes', ['class' => 'btn btn-success']) ?>
    </div>
        </div></div>

    <?php ActiveForm::end(); ?>


     <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Messages (including internal)</h3>
        </div>
        <div class="box-body">


    <div class="ticket-messages">
        <?php foreach ($model->messages as $m): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= Html::encode($m->user ? $m->user->username : 'User') ?>
                    <?php if ($m->is_internal): ?>
                        <span class="label label-warning">Internal</span>
                    <?php endif; ?>
                    <span class="pull-right"><?= Yii::$app->formatter->asDatetime($m->created_at) ?></span>
                </div>
                <div class="panel-body">
                    <?= nl2br(Html::encode($m->message)) ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <h3>Add Reply / Note</h3>
    <?php $form2 = ActiveForm::begin(); ?>

    <?= $form2->field($message, 'message')->textarea(['rows' => 4]) ?>

    <?= $form2->field($message, 'is_internal')->checkbox() ?>

    <?= $form2->field($model, 'status')->dropDownList(Ticket::getStatusList()) ?>

    <div class="form-group">
        <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
                    </div>
                    </div>
