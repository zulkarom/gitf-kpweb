<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use backend\modules\staff\models\Staff;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;

/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\KnowledgeTransfer */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="knowledge-transfer-form">


	
	<div class="row">
<div class="col-md-10"><?= $form->field($model, 'ktp_title')->textarea(['rows' => '3'])  ?></div>
</div>

    <div class="row">
<div class="col-md-10"><?= $form->field($model, 'ktp_research')->textInput(['maxlength' => true]) ?></div>
</div>

<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.member-item',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-member',
        'deleteButton' => '.remove-member',
        'model' => $members[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'id',
        ],
    ]); ?>
    
    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5%"></th>
				<th width="15%">FKP Staff</th>
                <th>Members' Name
				<br /><i style="font-weight:normal"> * Leader at the top</i>
				</th>
                
 
                <th class="text-center" style="width: 90px;">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($members as $indexRes => $member): ?>
            <tr class="member-item">
                <td class="sortable-handle text-center vcenter" style="cursor: move;">
                        <i class="fa fa-arrows"></i>
                    </td>
            
                
                
                <td class="vcenter">
          
                    
                     <?php
					 
			$ex_style = 'style="display:none"';
			$ex_staff = '';
			if($member->staff_id == 0 and !$member->isNewRecord){
				$member->is_staff = 0;
				$ex_style = '';
				$ex_staff = 'style="display:none"';
			}
						
						
					 echo $form->field($member, "[{$indexRes}]is_staff")->dropDownList(
        [1=> 'Yes', 0 => 'No'], ['class' => "form-control is-staff"]
    ) 
->label(false) ?>

                </td>
				
				<td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $member->isNewRecord) {
                            echo Html::activeHiddenInput($member, "[{$indexRes}]id");
							
                        }
						
                    ?>
					<div class="con-staff" <?=$ex_staff?>>
                    <?= $form->field($member, "[{$indexRes}]staff_id")->dropDownList(ArrayHelper::map(Staff::activeStaff(),'id', 'staff_name'), ['prompt' => 'Please Select' ])->label(false) ?>
					</div>
					
					
					
					<div class="con-ext" <?=$ex_style?>>
					<?= $form->field($member, "[{$indexRes}]ext_name")->label(false) ?>
					</div>
					
					
                </td>
                
         
       

                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-member btn btn-default btn-sm"><span class="fa fa-remove"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
            <td></td>
                <td colspan="2">
                <button type="button" class="add-member btn btn-default btn-sm"><span class="fa fa-plus"></span> New Member</button>
                
                </td>
                <td>
                
                
                </td>
            </tr>
        </tfoot>
        
    </table>
    
    
    
    <?php DynamicFormWidget::end(); ?>

    <div class="row">
<div class="col-md-8"><?= $form->field($model, 'ktp_community')->textInput(['maxlength' => true]) ?></div>
</div>

<div class="row">
<div class="col-md-3"> 
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

<div class="col-md-3"> 
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
<div class="col-md-8"><?= $form->field($model, 'ktp_source')->textInput(['maxlength' => true]) ?></div>
</div> 


    <div class="row">
<div class="col-md-3">

<?= $form->field($model, 'ktp_amount', [
    'addon' => ['prepend' => ['content'=>'RM']]
]); ?>

</div>

</div>

<div class="row">
<div class="col-md-10"> <?= $form->field($model, 'ktp_description')->textarea(['rows' => 4]) ?></div>
</div>
   


</div>
</div>
</div>

    <div class="form-group">
		
		<?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE AS DRAFT', ['class' => 'btn btn-default', 'name' => 'wfaction', 'value' => 'save']) ?> 
		
		
		
		 <?= Html::submitButton('NEXT <span class="glyphicon glyphicon-arrow-right"></span>', ['class' => 'btn btn-warning', 'name' => 'wfaction', 'value' => 'next']) ?> 
		 
    </div>

<?php ActiveForm::end(); ?>




<?php
$js = <<<'EOD'

function configIsStaffSelect(){
	$('.is-staff').change(function(){
	var id = $(this).attr('id');
	var arr = id.split('-');
	var val = $(this).val();
	//alert(val);
	if(val == 0){
		$('#knowledgetransfermember-' + arr[1]  + '-staff_id').val('');
		$('.field-knowledgetransfermember-' + arr[1]  + '-staff_id').parent().hide();
		$('.field-knowledgetransfermember-' + arr[1]  + '-ext_name').parent().show();
		
	}else{
		$('.field-knowledgetransfermember-' + arr[1]  + '-staff_id').parent().show();
		$('.field-knowledgetransfermember-' + arr[1]  + '-ext_name').parent().hide();
	}
	

});
}

jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    configIsStaffSelect();        
});


var fixHelperSortable = function(e, ui) {
    ui.children().each(function() {
        $(this).width($(this).width());
    });
    return ui;
};

$(".container-items").sortable({
    items: "tr",
    cursor: "move",
    opacity: 0.6,
    axis: "y",
    handle: ".sortable-handle",
    helper: fixHelperSortable,
    update: function(ev){
        $(".dynamicform_wrapper").yiiDynamicForm("updateContainer");
    }
}).disableSelection();

configIsStaffSelect();

EOD;

JuiAsset::register($this);
$this->registerJs($js);
?>
