<?php
use backend\models\Semester;
use kartik\widgets\ActiveForm;
use backend\modules\esiap\models\Program;
use yii\helpers\ArrayHelper;
?>

<?php 

$form = ActiveForm::begin([
'id' => 'sel-sem-form',
'action' => $model->action,
'method' => 'get',

]); ?>  
<div class="row">
	
<div class="col-md-5">
<?= $form->field($model, 'semester_id')->dropDownList(
        Semester::listSemesterArray()
    )->label(false) ?>
</div>
<div class="col-md-4">
<?= $form->field($model, 'str_search', ['addon' => ['prepend' => ['content'=>'<span class="glyphicon glyphicon-search"></span>']]])->label(false)->textInput(['placeholder' => "Search..."]) ?>
</div>
<div class="col-md-3">
<?=$form->field($model, 'program_search')->label(false)->dropDownList(
        ArrayHelper::map(Program::find()->where(['faculty_id' => Yii::$app->params['faculty_id'], 'status' => 1, 'trash' => 0])->all(),'id', 'pro_name_short'), ['prompt' => 'Select Program' ]);?>
</div>
</div>
    <?php ActiveForm::end(); ?>

<?php 

$this->registerJs('

$("#semesterform-semester_id").change(function(){
	$("#sel-sem-form").submit();
});

$("#semesterform-program_search").change(function(){
	$("#sel-sem-form").submit();
});

');

?>