<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;


/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\Conference */

$this->title = 'SCOPES: ' . $model->conf_abbr;
$this->params['breadcrumbs'][] = ['label' => 'Conferences', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="conference-update">

<?php

$model->file_controller = 'setting';

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\Conference */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title"><?=$model->conf_name?></h3>
						
						</div>
						<div class="panel-body">
			
			
			
			<div class="conference-form">
			


            <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

<?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>

<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.date-item',
        'limit' => 200,
        'min' => 1,
        'insertButton' => '.add-date',
        'deleteButton' => '.remove-date',
        'model' => $scopes[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'id',
            'scope_name',
        ],
    ]); ?>

    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5%"></th>
                <th>Scopes</th>
                <th class="text-center" style="width: 90px;">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($scopes as $i => $scope): ?>
            <tr class="date-item">
                <td class="sortable-handle text-center vcenter" style="cursor: move;">
                        <i class="fa fa-arrows-alt"></i>
                    </td>
            
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $scope->isNewRecord) {
                            echo Html::activeHiddenInput($scope, "[{$i}]id");
                        }
                    ?>
                    <?= $form->field($scope, "[{$i}]scope_name")->label(false) ?>
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
                <button type="button" class="add-date btn btn-default btn-sm"><span class="fa fa-plus"></span> New Scope</button>
                
                </td>
 
            </tr>
        </tfoot>
        
    </table>
    <?php DynamicFormWidget::end(); ?>
    
    <br />


    <div class="form-group">
        <?= Html::submitButton('Save Scopes', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div></div>
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


jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    var first = $(item).find("input")[0];
    first.setAttribute("value", "");
});

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

