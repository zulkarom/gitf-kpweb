<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use backend\models\Semester;
use backend\modules\postgrad\models\StudentRegister;

/* @var $this yii\web\View */
/* @var $student backend\modules\postgrad\models\Student */
/* @var $models backend\modules\postgrad\models\StudentRegister[] */

$this->title = 'Bulk Add/Edit Semester Registration';
$this->params['breadcrumbs'][] = ['label' => 'Postgraduate Students', 'url' => ['student/index']];
$this->params['breadcrumbs'][] = ['label' => $student->user->fullname, 'url' => ['student/view', 'id' => $student->id]];
$this->params['breadcrumbs'][] = $this->title;

$semesterList = ArrayHelper::map(Semester::find()->orderBy(['id' => SORT_DESC])->all(), 'id', function($m){
    return $m->longFormat();
});

$statusList = StudentRegister::statusDaftarList();
?>

<div class="student-register-bulk-edit">

    <div class="box">
        <div class="box-body">

            <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper',
                'widgetBody' => '.container-items',
                'widgetItem' => '.item',
                'limit' => 50,
                'min' => 1,
                'insertButton' => '.add-item',
                'deleteButton' => '.remove-item',
                'model' => $models[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'semester_id',
                    'status_daftar',
                ],
            ]); ?>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th style="width: 45%">Semester</th>
                    <th style="width: 45%">Status Daftar</th>
                    <th style="width: 10%"></th>
                </tr>
                </thead>
                <tbody class="container-items">
                <?php foreach ($models as $index => $model): ?>
                    <tr class="item">
                        <td>
                            <?php
                                if (!$model->isNewRecord) {
                                    echo Html::activeHiddenInput($model, "[{$index}]id");
                                }
                            ?>
                            <?= $form->field($model, "[{$index}]semester_id")->dropDownList($semesterList, ['prompt' => ''])->label(false) ?>
                        </td>
                        <td>
                            <?= $form->field($model, "[{$index}]status_daftar")->dropDownList($statusList)->label(false) ?>
                        </td>
                        <td class="text-center" style="vertical-align: middle;">
                            <a class="remove-item" href="javascript:void(0)"><span class="fa fa-remove"></span></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="3">
                        <button type="button" class="add-item btn btn-default btn-sm"><span class="fa fa-plus"></span> Add Row</button>
                    </td>
                </tr>
                </tfoot>
            </table>

            <?php DynamicFormWidget::end(); ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                <a href="<?= Url::to(['student/view', 'id' => $student->id]) ?>" class="btn btn-default">Cancel</a>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>
