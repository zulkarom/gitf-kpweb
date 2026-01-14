<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\grant\models\Category;
use backend\modules\grant\models\Type;

/* @var $this yii\web\View */
/* @var $model backend\modules\grant\models\Grant */
/* @var $form yii\widgets\ActiveForm */

$categories = ArrayHelper::map(Category::find()->orderBy(['category_name' => SORT_ASC])->all(), 'id', 'category_name');
$types = ArrayHelper::map(Type::find()->orderBy(['type_name' => SORT_ASC])->all(), 'id', 'type_name');
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

            <?= $form->field($model, 'head_researcher_id')->textInput() ?>

            <?= $form->field($model, 'head_researcher_name')->textInput(['maxlength' => true]) ?>

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
