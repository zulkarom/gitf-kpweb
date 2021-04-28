<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
use richardfan\widget\JSRegister;

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\ConfPaper */

$this->title = 'Update Paper';
$this->params['breadcrumbs'][] = ['label' => 'Conf Papers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.table td, .table th {
    padding: 0rem;
    border: none;
}
label{
	font-weight:bold;
}
	</style>
<div class="conf-paper-create">



<div class="card">

            <div class="card-body">
			<div class="conf-paper-form">

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

<?= $form->field($model, 'status')->dropdownlist($model->statusList()) ?>

    <?= $form->field($model, 'pap_title')->textarea(['rows' => 2]) ?>
	
	<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.author-item',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-author',
        'deleteButton' => '.remove-author',
        'model' => $authors[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'id',
            'fullname',
        ],
    ]); ?>

    
    <table class="table">
        <thead>
            <tr>
                <th colspan="3" style="border:none;padding-bottom:20px">Authors' Name</th>

            </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($authors as $i => $author): ?>
            <tr class="author-item">
                <td class="sortable-handle text-center vcenter" width="5%" style="cursor: move;">
                        <i class="fa fa-arrows-alt"></i>
                    </td>
            
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $author->isNewRecord) {
                            echo Html::activeHiddenInput($author, "[{$i}]id");
                        }
                    ?>
                    <?= $form->field($author, "[{$i}]fullname")->label(false) ?>
                </td>
                <td class="text-center vcenter" width="5%">
                    <button type="button" class="remove-author btn btn-default btn-sm"><span class="fa fa-remove"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
            <td></td>
                <td>
                <button type="button" class="add-author btn btn-default btn-sm"><span class="fa fa-plus"></span> Add authors</button>
                
                </td>
                <td>
                
                
                </td>
            </tr>
        </tfoot>
        
    </table>
    <?php DynamicFormWidget::end(); ?>

    <?= $form->field($model, 'pap_abstract')->textarea(['rows' => 6]) ?>
	
	<?= $form->field($model, 'keyword')->textarea(['rows' => 2]) ?>
	



    <div class="form-group">
        <?= Html::submitButton('UPDATE PAPER', ['id' => 'abstract-next','class' => 'btn btn-primary']) ?>
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

