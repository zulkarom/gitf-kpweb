<?php
use backend\modules\downloads\models\DownloadCategory;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
?>

<?php 

$form = ActiveForm::begin([
'id' => 'sel-sem-form',
'method' => 'get',

]); ?>  
<div class="row">
	
<div class="col-md-5">
<?= $form->field($model, 'category_id')->dropDownList(
        ArrayHelper::map(DownloadCategory::find()->all(),'id','category_name')
    )->label(false) ?>
</div>
<div class="col-md-4">
<?= $form->field($model, 'str_search', ['addon' => ['prepend' => ['content'=>'<span class="glyphicon glyphicon-search"></span>']]])->label(false)->textInput(['placeholder' => "Search Name or Matrics..."]) ?>
</div>
</div>
    <?php ActiveForm::end(); ?>

<?php 

$this->registerJs('

$("#downloadcategoryform-category_id").change(function(){
	$("#sel-sem-form").submit();
});

');

?>