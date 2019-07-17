<?php

use yii\helpers\Html;
use kartik\date\DatePicker;
use kartik\widgets\ActiveForm;
use backend\modules\erpd\models\ResearchGrant;
use backend\modules\staff\models\Staff;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;


/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\Research */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="research-form">

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?= $form->field($model, 'res_title')->textarea(['rows' => '2']) ?>
	
	
	

<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.researcher-item',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-researcher',
        'deleteButton' => '.remove-researcher',
        'model' => $researchers[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'is_staff',
            'staff_id',
            'ext_name',
			'is_leader'
        ],
    ]); ?>
    
    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5%"></th>
				<th width="15%">FKP Staff</th>
                <th>Researchers' Name
				<br /><i style="font-weight:normal"> * Leader at the top</i>
				</th>
                
 
                <th class="text-center" style="width: 90px;">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($researchers as $indexRes => $researcher): ?>
            <tr class="researcher-item">
                <td class="sortable-handle text-center vcenter" style="cursor: move;">
                        <i class="fa fa-arrows"></i>
                    </td>
            
                
                
                <td class="vcenter">
          
                    
                     <?php

					 echo $form->field($researcher, "[{$indexRes}]is_staff")->dropDownList(
        [1=> 'Yes', 0 => 'No'], ['class' => "form-control is-staff"]
    ) 
->label(false) ?>

                </td>
				
				<td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $researcher->isNewRecord) {
                            echo Html::activeHiddenInput($researcher, "[{$indexRes}]resr_id");
                        }
                    ?>
                    <?= $form->field($researcher, "[{$indexRes}]staff_id")->dropDownList(ArrayHelper::map(Staff::activeStaff(),'id', 'staff_name'), ['prompt' => 'Please Select' ])->label(false) ?>
					
					
					
					<div class="con-ext" style="display:none">
					<?= $form->field($researcher, "[{$indexRes}]ext_name")->label(false) ?>
					</div>
					
					
                </td>
                
         
       

                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-researcher btn btn-default btn-sm"><span class="fa fa-remove"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
            <td></td>
                <td colspan="2">
                <button type="button" class="add-researcher btn btn-default btn-sm"><span class="fa fa-plus"></span> New Researcher</button>
                
                </td>
                <td>
                
                
                </td>
            </tr>
        </tfoot>
        
    </table>
    
    
    
    <?php DynamicFormWidget::end(); ?>

	
	
	

	<div class="row">

<div class="col-md-4">



 <?=$form->field($model, 'date_start')->widget(DatePicker::classname(), [
	'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
		'format' => 'yyyy-mm-dd',
		'todayHighlight' => true,
		
    ],
	
	
])?>

</div>
<div class="col-md-4">
 <?=$form->field($model, 'date_end')->widget(DatePicker::classname(), [
	'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
		'format' => 'yyyy-mm-dd',
		'todayHighlight' => true,
		
    ],
	
	
])?>

</div>

</div>

    
<div class="row">
<div class="col-md-6"><?= $form->field($model, 'res_grant')->dropDownList(
        ArrayHelper::map(ResearchGrant::find()->all(),'gra_id', 'gra_abbr'), ['prompt' => 'Please Select' ]
    )
 ?></div>
 
 <?php 
if($model->res_grant){
	if($model->res_grant == 9){
		$other_show = true;
	}else{
		$other_show = false;
	}
	
}else{
	$other_show = false;
	
}

if($other_show){
	$other_style = '';
}else{
	$other_style = 'style="display:none"';
}
?>

<div class="col-md-6"> <div id="con-other" <?=$other_style?>><?= $form->field($model, 'res_grant_others')->textInput(['maxlength' => true]) ?></div>


</div>
</div>
<div class="row">
<div class="col-md-6"><?= $form->field($model, 'res_source')->textInput(['maxlength' => true]) ?></div>
<div class="col-md-3"><?= $form->field($model, 'res_amount', [
    'addon' => ['prepend' => ['content'=>'RM']]
]); ?></div>
<div class="col-md-3"><?php 
	$st = [0 => 'On Going', 1 => 'Complete'];
	
	echo $form->field($model, 'res_status')->dropDownList(
        $st, ['prompt' => 'Please Select' ]
    ) 
 ?></div>
</div>
	

 

    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i> Save Research', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>

<?php
$js = <<<'EOD'

function configIsStaffSelect(){
	$('.is-staff').change(function(){
	var id = $(this).attr('id');
	var arr = id.split('-');
	var val = $(this).val();
	//alert(val);
	if(val == 0){
		$('.field-researchers-' + arr[1]  + '-staff_id').hide();
		$('.field-researchers-' + arr[1]  + '-ext_name').parent().show();
	}else{
		$('.field-researchers-' + arr[1]  + '-staff_id').show();
		$('.field-researchers-' + arr[1]  + '-ext_name').parent().hide();
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


$('#research-res_grant').change(function(){
	var val = $(this).val();
	if(val == 9){
		$('.field-research-res_grant_others').parent().show();
		
	}else{
		$('.field-research-res_grant_others').parent().hide();
	}
});

EOD;

JuiAsset::register($this);
$this->registerJs($js);
?>
