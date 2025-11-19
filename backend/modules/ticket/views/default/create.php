<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\modules\ticket\models\Ticket */
/* @var $categories backend\modules\ticket\models\TicketCategory[] */

$this->title = 'Create Ticket';
$this->params['breadcrumbs'][] = ['label' => 'My Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$categoryItems = ArrayHelper::map($categories, 'id', 'name');
?>


    <div class="box box-solid">
        <div class="box-header">
            <h3 class="box-title">Create Ticket</h3>
        </div>
        <div class="box-body">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'category_id')->dropDownList($categoryItems, ['prompt' => 'Select Category']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'priority')->dropDownList([
                1 => 'Low',
                2 => 'Normal',
                3 => 'High',
                4 => 'Urgent',
            ], ['prompt' => 'Select Priority']) ?>
        </div>
    </div>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= $model->isNewRecord ? Html::submitButton('Submit Ticket', ['class' => 'btn btn-success']) : Html::submitButton('Update Ticket', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>

