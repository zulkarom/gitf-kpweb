<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use common\models\User;
use backend\modules\jeb\models\ArticleStatus;
use backend\modules\jeb\models\Journal;
use backend\modules\jeb\models\JournalIssue;
use backend\modules\jeb\models\Scope;
use backend\modules\jeb\models\ReviewForm;
use common\models\Upload;
use common\models\AuthAssignment;
use wbraganca\dynamicform\DynamicFormWidget;
use richardfan\widget\JSRegister;

/* @var $this yii\web\View */
/* @var $model backend\modules\jeb\models\ArticleOverwrite */
/* @var $form yii\widgets\ActiveForm */

$model->file_controller = 'article-overwrite';

?>
<?php $form = ActiveForm::begin(['id' => 'dynamic-form']);  ?>

<div class="box">
<div class="box-header"></div>
<div class="box-body">
		
		<div class="row">
<div class="col-md-6"> <?= $form->field($model, 'status')->dropDownList(ArticleStatus::getAllStatusesArray())->label('Select Manuscript Status') ?></div>


</div>
	


    <?= $form->field($model, 'title')->textarea(['rows' => 3]) ?>
	
  <?= $form->field($model, 'abstract')->textarea(['rows' => 3]) ?>
	

  




    

</div></div>
</div>

<div class="row">
<div class="col-md-6"><div class="form-group">
        <?= Html::submitButton('<span class="fa fa-save"></span> SAVE DATA', ['class' => 'btn btn-primary']) ?>
    </div></div>

<div class="col-md-6" align="right">
<?=Html::a('<span class="fa fa-trash"></span>', ['delete-article', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this manuscript?',
                'method' => 'post',
            ],
        ])?>
</div>

</div>


<?php ActiveForm::end(); ?>



<?php JSRegister::begin(); ?>
<script>
$("#articleoverwrite-journal_id").change(function(){
	putOption();
});

function putOption(){
	var target_id =  'articleoverwrite-journal_issue_id';
	var journal =  $('#articleoverwrite-journal_id').val();
	$('#' + target_id).html('<option>Loading...</option>');
	var url = '<?=Url::to(['publish/list-issues', 'journal' => '']) ?>' + journal ;
	
	console.log(url)
	
	$.ajax({url:  url, success: function(result){
	var str = '';
	if(result){
		var reviewer = JSON.parse(result);
		console.log(reviewer);
		
		for(var id in reviewer) {
		   str += '<option value=\"' + id +  '\">' + reviewer[id] + '</option>';
		}

	}
		
	$('#' + target_id).html(str);
	
	
    }});
	
}
</script>
<?php JSRegister::end(); ?>