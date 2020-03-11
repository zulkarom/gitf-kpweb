<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\modules\questbank\models\QuestionType;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;


/* @var $this yii\web\View */
/* @var $model backend\modules\questbank\models\Question */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="question-form">

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    
	
	
<div class="row">
<div class="col-md-3"><?= $form->field($model, 'qtype_id')->dropDownList(
        ArrayHelper::map(QuestionType::find()->all(),'id', 'code_text'), ['prompt' => 'Please Select' ]
    ) ?></div>
<div class="col-md-3"><?= $form->field($model, 'category_id')->dropDownList(
        ArrayHelper::map($model->categoryList,'id', 'cat_text'), ['prompt' => 'Please Select' ]
    ) ?>

</div>
<div class="col-md-3"><?= $form->field($model, 'level')->dropDownList( [1 => 'EASY' , 2 => 'MEDIUM', 3 => 'HARD'], ['prompt' => 'Please Select' ] ) ?>

</div>
</div>
	
	
	<div class="row">
<div class="col-md-6"><?= $form->field($model, 'qtext')->textarea(['rows' => 6]) ?></div>

<div class="col-md-6"> <?= $form->field($model, 'qtext_bi')->textarea(['rows' => 6]) ?>
</div>

</div>

    
<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.option-item',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-option',
        'deleteButton' => '.remove-option',
        'model' => $options[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'id',
        ],
    ]); ?>

    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5%"></th>
                <th>Option (BM)</th>
                <th>Option (EN)</th>
				<th>Answer</th>
                <th class="text-center" style="width: 90px;">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($options as $i => $option): ?>
            <tr class="option-item">
                <td class="sortable-handle text-center vcenter" style="cursor: move;">
                        <i class="fa fa-arrows-alt"></i>
                    </td>
            
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $option->isNewRecord) {
                            echo Html::activeHiddenInput($option, "[{$i}]id");
                        }
                    ?>
                    <?= $form->field($option, "[{$i}]option_text")->label(false) ?>
                </td>
                
                <td class="vcenter">
          
                    
                    <?= $form->field($option, "[{$i}]option_text_bi")->label(false) ?>

                </td>
				
				 <td class="vcenter">
				<?= $form->field($option, "[{$i}]is_answer")->checkbox(['value' => '1', 'label'=> '']); ?>
				 </td>

                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-option btn btn-default btn-sm"><span class="fa fa-remove"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
            <td></td>
                <td colspan="2">
                <button type="button" class="add-option btn btn-default btn-sm"><span class="fa fa-plus"></span> New Option</button>
                
                </td>
                <td>
                
                
                </td>
            </tr>
        </tfoot>
        
    </table>
    <?php DynamicFormWidget::end(); ?>

    

   

    

    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div></div>
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
