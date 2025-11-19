<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            'status',
            'priority',
            'created_by',
            'assigned_to',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <h3>Update Ticket</h3>

    <?= $form->field($model, 'category_id')->dropDownList($categoryItems, ['prompt' => 'Select Category']) ?>

    <?= $form->field($model, 'priority')->dropDownList([
        1 => 'Low',
        2 => 'Normal',
        3 => 'High',
        4 => 'Urgent',
    ]) ?>

    <?= $form->field($model, 'status')->dropDownList([
        0 => 'New',
        1 => 'Open',
        2 => 'In Progress',
        3 => 'Awaiting User',
        4 => 'Resolved',
        5 => 'Closed',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save Changes', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <h3>Messages (including internal)</h3>
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

    <div class="form-group">
        <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
