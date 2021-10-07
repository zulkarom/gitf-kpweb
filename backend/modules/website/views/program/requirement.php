<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
use dosamigos\tinymce\TinyMce;



/* @var $this yii\web\View */
/* @var $model backend\modules\website\models\Program */

$this->title = 'Requirement';
$this->params['breadcrumbs'][] = ['label' => 'Programs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Views', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Requirement';

?>
<div class="conference-update">



<div class="box">
<div class="box-header">
<div class="box-title">
<?=$typeName?> for <?=$model->program->program_code?>
</div>
</div>
<div class="box-body">
<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

<?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>

<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.requirement-item',
        'limit' => 100,
        'min' => 1,
        'insertButton' => '.add-requirement',
        'deleteButton' => '.remove-requirement',
        'model' => $requirements[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'id',
            'req_text',
        ],
    ]); ?>

    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5%"></th>
                <th>Requirements</th>
                <th class="text-center" style="width: 90px;">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($requirements as $i => $requirement): ?>
            <tr class="requirement-item">
                <td class="sortable-handle text-center vcenter" style="cursor: move;">
                        <i class="fa fa-arrows-alt"></i>
                    </td>
            
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $requirement->isNewRecord) {
                            echo Html::activeHiddenInput($requirement, "[{$i}]id");
                        }
                    ?>
                 
					
					<?=$form->field($requirement, "[{$i}]req_text")->widget(TinyMce::className(), [
    'options' => ['rows' => 6],
    'language' => 'en',
    'clientOptions' => [
        'plugins' => [
            "advlist autolink lists link charmap",
            "searchreplace visualblocks code fullscreen",
            "paste"
        ],
        'menubar' => false,
        'toolbar' => "undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent"
    ]
])->label(false)  ?>
                </td>


                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-requirement btn btn-default btn-sm"><span class="fa fa-remove"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
            <td></td>
                <td colspan="2">
                <button type="button" class="add-requirement btn btn-default btn-sm"><span class="fa fa-plus"></span> New Requirement</button>
                
                </td>
                <td>
                
                
                </td>
            </tr>
        </tfoot>
        
    </table>
    <?php DynamicFormWidget::end(); ?>
    
    <br />
    <div class="form-group">
        <?= Html::submitButton('Save Requirements', ['class' => 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>
        
            
            
            </div>
</div>

</div>


<?php

$js = <<<'EOD'

jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    tinyMCE.init({selector: 'textarea'});
});
jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    tinyMCE.remove();
    tinyMCE.init({selector: 'textarea'});
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

EOD;

JuiAsset::register($this);
$this->registerJs($js);
?>

