<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use backend\modules\jeb\models\UserScope;

$scope = UserScope::find()->where(['user_id' => Yii::$app->user->identity->id])->all();
$scope = ArrayHelper::map($scope, 'scope_id','scope.scope_name');

$form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
 
<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">Add Reviewer</h3>

</div>

<div class="box-body"> 


<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.reviewer-item',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-reviewer',
        'deleteButton' => '.remove-reviewer',
        'model' => $reviewers[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'user_id',
			'user_field'
     
        ],
    ]); ?>
    
	<div class="row">
<div class="col-md-12">

<table class="table table-bordered table-striped">
        <thead>
            <tr>
				<th width="20%">Internal/External</th>
				
				<th width="33%">Reviewer's Field</th>
				
                <th>Reviewer Name</th>

                <th width="5%">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($reviewers as $indexAu => $reviewer): ?>
            <tr class="reviewer-item">
				<td>
				<?php
				
				$reviewer->setInex();
				
				echo $form->field($reviewer, "[{$indexAu}]inex")->dropDownList([1 => 'Internal', 2 => 'External'], ['class' => 'form-control inex-select'])->label(false) ?>
				
				</td>
				
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $reviewer->isNewRecord) {
                            echo Html::activeHiddenInput($reviewer, "[{$indexAu}]id");
                        }
                    ?>
                    <?= $form->field($reviewer, "[{$indexAu}]scope_id")->dropDownList($scope, ['prompt' => 'Please Select', 'class' => 'form-control scope-select' ])->label(false) ?>
                </td>
				
                <td>
				<?= $form->field($reviewer, "[{$indexAu}]user_id")->dropDownList($reviewer->listReviewers(), ['prompt' => 'Please Select' ])->label(false) ?>
				
				</td>


                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-reviewer btn btn-default btn-sm"><span class="fa fa-remove"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
                <td colspan="3">
                <button type="button" class="add-reviewer btn btn-default btn-sm"><span class="fa fa-plus"></span> Add Reviewer</button>
                
                </td>
                <td>
                
                
                </td>
            </tr>
        </tfoot>
        
    </table>
</div>
</div>
    
    
    
    
    
    <?php DynamicFormWidget::end(); ?>
	


  <?=$form->field($model, 'review_at')->hiddenInput(['value' => time()])->label(false)?>
  
 






</div>
</div>

<div class="form-group">

		
	<?=Html::submitButton('Assign Reviewer', ['class' => 'btn btn-success', 'name' => 'wfaction', 'value' => 'assign-reviewer', 'data' => [
                'confirm' => 'Are you sure to assign selected reviewer(s)?'
            ],
])?>

    </div>
<?php 

ActiveForm::end(); 

?>


<?php 
$js = "

function getTargetId(element){
	var val = element.val();
	var curr_id = element.attr('id');
	var index_id_arr = curr_id.split('-');
	var index_id = index_id_arr[1];
	var target_id =  'articlereviewer-' + index_id + '-user_id';
	
	var scope =  $('#articlereviewer-' + index_id + '-scope_id').val();
	
	var inex =  $('#articlereviewer-' + index_id + '-inex').val();
	
	$('#' + target_id).html('<option>Loading...</option>');
	
	var url = '".Url::to(['submission/list-reviewers', 'scope' => ''])."' + scope + '&inex=' + inex;
	
	//alert(url);
	
	$.ajax({url:  url, success: function(result){
	var str = '';
	if(result){
		var reviewer = JSON.parse(result);
		//console.log(reviewer.76);
		
		for(var id in reviewer) {
		   str += '<option value=\"' + id +  '\">' + reviewer[id] + '</option>';
		}

	}
		
	$('#' + target_id).html(str);
	
	
    }});
	
	
}

";

$this->registerJs($js);

$js = <<<'EOD'



jQuery( ".scope-select" ).change(function() {
	   getTargetId($(this));
});

jQuery( ".inex-select" ).change(function() {
	   getTargetId($(this));
});



jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
	jQuery( ".scope-select" ).change(function() {
		var target_id = $(this).attr('id');
	   getTargetId($(this));
}); 

jQuery( ".inex-select" ).change(function() {
		var target_id = $(this).attr('id');
	   getTargetId($(this));
});  
     
});



EOD;

$this->registerJs($js);

?>