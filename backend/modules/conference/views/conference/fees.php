<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
use dosamigos\tinymce\TinyMce;


/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\Conference */

$this->title = 'FEES: ' . $model->conf_abbr;
$this->params['breadcrumbs'][] = ['label' => 'Conferences', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Fees';

$local = $model->currency_local;
$int = $model->currency_int;

$curr = [$local => $local, $int=>$int];
?>
<div class="conference-update">

<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title"><?=$this->title?></h3>
						</div>
						<div class="panel-body">
<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

<?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>

<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.date-item',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-date',
        'deleteButton' => '.remove-date',
        'model' => $fees[0],
        'formId' => 'dynamic-form',
        'formFields' => [
			'id',
            'fee_name',
			'fee_amount',
			'fee_early'
        ],
    ]); ?>

    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5%"></th>
                <th>Category</th>
				<th width="15%">Currency</th>
                <th width="15%">Early Bird</th>
				<th width="15%">Normal</th>
                <th class="text-center" width="5%">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($fees as $i => $fee): ?>
            <tr class="date-item">
                <td class="sortable-handle text-center vcenter" style="cursor: move;">
                        <i class="fa fa-arrows-alt"></i>
                    </td>
            
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $fee->isNewRecord) {
                            echo Html::activeHiddenInput($fee, "[{$i}]id");
                        }
                    ?>
                    <?= $form->field($fee, "[{$i}]fee_name")->label(false) ?>
                </td>
				
				<td class="vcenter">
          
                    <?= $form->field($fee, "[{$i}]fee_currency")->dropDownList($curr)->label(false); ?>

                    

                </td>
                
                <td class="vcenter">
          
                    <?= $form->field($fee, "[{$i}]fee_early")->label(false); ?>

                    

                </td>
				
				<td class="vcenter">
          
                   <?= $form->field($fee, "[{$i}]fee_amount")->label(false); ?>
 
                    

                </td>

                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-date btn btn-default btn-sm"><span class="fa fa-remove"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
            <td></td>
                <td colspan="4">
                <button type="button" class="add-date btn btn-default btn-sm"><span class="fa fa-plus"></span> New Fee</button>
                
                </td>
                <td>
                
                
                </td>
            </tr>
        </tfoot>
        
    </table>
    <?php DynamicFormWidget::end(); ?>
	
    <br />
	
	
	<?php 
$plugin = [
            "advlist autolink lists link charmap",
            "searchreplace visualblocks code fullscreen",
            "paste"
        ];
$toolbar = "undo redo | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent link code | fontselect fontsizeselect styleselect ";

$options = [
        'plugins' => $plugin,
		'menubar' => false,
        'toolbar' => $toolbar
    ];

?>

<?= $form->field($model, 'payment_info')->widget(TinyMce::className(), [
    'options' => ['rows' => 10],
    'language' => 'en',
    'clientOptions' => $options
])->label('Payment Information');?>
	
	
	
    <div class="form-group">
        <?= Html::submitButton('Save Fees & Payment', ['class' => 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>
		
			
			
			</div>
</div>

</div>


<?php

$js = <<<'EOD'

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

EOD;

JuiAsset::register($this);
$this->registerJs($js);
?>

