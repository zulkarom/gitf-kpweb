<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use backend\modules\grant\models\Category;
use backend\modules\grant\models\Type;
use backend\modules\postgrad\models\Supervisor;

/* @var $this yii\web\View */
/* @var $model backend\modules\grant\models\Grant */
/* @var $form yii\widgets\ActiveForm */

$categories = ArrayHelper::map(Category::find()->orderBy(['category_name' => SORT_ASC])->all(), 'id', 'category_name');
$types = ArrayHelper::map(Type::find()->orderBy(['type_name' => SORT_ASC])->all(), 'id', 'type_name');
$supervisors = Supervisor::find()->with(['staff.user', 'external'])->orderBy(['id' => SORT_ASC])->all();
$supervisorOptions = ArrayHelper::map($supervisors, 'id', function ($sv) {
    if ($sv->staff) {
        return $sv->staff->staff_no . ' - ' . strtoupper($sv->svNamePlain);
    }
    return strtoupper($sv->svNamePlain);
});
?>

<div class="grant-form">

    <div class="box">
        <div class="box-header"></div>
        <div class="box-body">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'grant_title')->textarea(['rows' => 4]) ?>

            <?= $form->field($model, 'project_code')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'category_id')->dropdownList($categories, ['prompt' => '- Select -']) ?>

            <?= $form->field($model, 'type_id')->dropdownList($types, ['prompt' => '- Select -']) ?>

            <?= $form->field($model, 'head_researcher_id')->widget(Select2::classname(), [
                'data' => $supervisorOptions,
                'options' => ['placeholder' => 'Select a Head Researcher ...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>

        

            <?= $form->field($model, 'amount')->textInput() ?>

            <?= $form->field($model, 'date_start')->textInput() ?>

            <?= $form->field($model, 'date_end')->textInput() ?>

            <?= $form->field($model, 'is_extended')->dropdownList([1 => 'Yes', 0 => 'No']) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
