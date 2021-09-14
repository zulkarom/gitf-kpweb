<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\modules\postgrad\models\Kursus;
/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\KursusSiri */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body">
<div class="kursus-siri-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'kursus_siri')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?=$form->field($model, 'date_start')->widget(DatePicker::classname(), [
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    
                ],
                
                
            ]);

            ?>
        </div>
        <div class="col-md-4">
            <?=$form->field($model, 'date_end')->widget(DatePicker::classname(), [
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    
                ],
                
                
            ]);

            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'capacity')->textInput() ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'kursus_id')->widget(Select2::classname(), [
            'data' =>  ArrayHelper::map(Kursus::find()->all(),'id', 'kursus_name'),
            'options' => ['placeholder' => 'Select...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
            ]);?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'location')->textarea(['rows' => '3'])?>
        </div>
    </div>

    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
