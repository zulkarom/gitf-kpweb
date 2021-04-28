<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\Conference */

$this->title = 'DOWNLOADS: ' . $model->conf_abbr;
$this->params['breadcrumbs'][] = ['label' => 'Conferences', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Download';
?>
<div class="conference-update">

<div class="card">

            <div class="card-body">
<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

<?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>


    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5%"></th>
                <th>Download Label</th>
                <th width="25%">File</th>
                <th class="text-center" style="width: 90px;">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($downloads as $i => $d): ?>
            <tr class="date-item">
                <td class="sortable-handle text-center vcenter" style="cursor: move;">
                        <i class="fas fa-arrows-alt"></i>
                    </td>
            
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $d->isNewRecord) {
                            echo Html::activeHiddenInput($d, "[{$i}]id");
                        }
                    ?>
                    <?= $form->field($d, "[{$i}]download_name")->label(false) ?>
                </td>
                
                <td class="vcenter">
          
                    
  

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
                <td colspan="2">
                <button type="button" class="add-date btn btn-default btn-sm"><span class="fa fa-plus"></span> New Download</button>
                
                </td>
                <td>
                
                
                </td>
            </tr>
        </tfoot>
        
    </table>

	
    <br />
    <div class="form-group">
        <?= Html::submitButton('Save Dates', ['class' => 'btn btn-primary']) ?>
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
    }
}).disableSelection();

EOD;

JuiAsset::register($this);
$this->registerJs($js);
?>

