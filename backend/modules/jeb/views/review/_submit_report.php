<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>




<div class="form-group" align="right">
<?php $form = ActiveForm::begin(); ?>



<?= Html::button('<span class="glyphicon glyphicon-plus"></span> Add Reviewer', ['id' =>'add-reviewer', 'class' => 'btn btn-warning']) ?> 
        

<?=Html::submitButton('Submit Review Report', 
    ['class' => 'btn btn-success', 'name' => 'wfaction', 'value' => 'send-recommend', 'data' => [
                'confirm' => 'Are you sure to submit this review report?'
            ],
    ])?>
	
	<?=$form->field($model, 'review_at')->hiddenInput(['value' => time()])->label(false)?>

    <?php ActiveForm::end(); ?>
</div>

<?php 
$this->registerJs('
$("#add-reviewer").click(function(){
	$("#con-add-reviewer").slideDown();
});
');

?>