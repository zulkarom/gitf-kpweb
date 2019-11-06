<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\modules\erpd\models\PubType;
use backend\modules\staff\models\Staff;
use common\models\Common;
use richardfan\widget\JSRegister;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\Publication */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="publication-form">
<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
<div class="box">
<div class="box-header"></div>
<div class="box-body">  
  


<?=$form->field($model, 'pub_type', [
                    'template' => $model->fieldTempate(),
                    'options' => [
                       // 'tag' => false, // Don't wrap with "form-group" div
                    ]])->dropDownList(
        ArrayHelper::map(PubType::find()->all(),'id', 'type_name')
    )



?>
<div class="field-publication-pub_author">
<div class="row"><div class="col-md-3" align="right"><label class="control-label" for="publication-pub_author">Author(s)</label>:</div><div class="col-md-8">


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
            'au_name',
        ],
    ]); ?>
	
	
    <table class="table table-striped">

        <tbody class="container-items">
        <?php foreach ($authors as $indexAu => $author): ?>
            <tr class="author-item">
                <td width="5%" class="sortable-handle text-center vcenter" style="cursor: move;">
                        <i class="fa fa-arrows"></i>
                    </td>
            
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $author->isNewRecord) {
                            echo Html::activeHiddenInput($author, "[{$indexAu}]id");
                        }
                    ?>
                    <?= $form->field($author, "[{$indexAu}]au_name")->label(false) ?>
                </td>
                
               

                <td width="5%" class="text-center vcenter">
                    <a class="remove-author" href="javascript:void(0)"><span class="fa fa-remove"></span></a>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
            <td></td>
                <td colspan="2">
                <button type="button" class="add-author btn btn-default btn-sm"><span class="fa fa-plus"></span> Add Author</button>
                
                </td>
 
            </tr>
        </tfoot>
        
    </table>
    
    
    
    <?php DynamicFormWidget::end(); ?>






</div></div>
</div>



<?=$form->field($model, 'pub_year', [
                    'template' => $model->fieldTempate(3),
                    'options' => [
                       // 'tag' => false, // Don't wrap with "form-group" div
                    ]])->dropDownList( $model->years() ) ?>
<?=$form->field($model, 'pub_month', [
                    'template' => $model->fieldTempate(3),
                    'options' => [
                       // 'tag' => false, // Don't wrap with "form-group" div
                    ]])->dropDownList(Common::months())?>

<?=$form->field($model, 'pub_day', [
                    'template' => $model->fieldTempate(3),
                    'options' => [
                      //  'tag' => false, // Don't wrap with "form-group" div
                    ]])->dropDownList(Common::dateth())?>

<?=$form->field($model, 'pub_date', [
                    'template' => $model->fieldTempate(3),
                    'options' => [
                       // 'tag' => false, // Don't wrap with "form-group" div
                    ]])->textInput()?>

<?=$form->field($model, 'pub_title', [
                    'template' => $model->fieldTempate(8,'*Capitalize Each Word'),
                    'options' => [
                      //  'tag' => false, // Don't wrap with "form-group" div
                    ]])->textarea(['rows' => '3']) ?>
<div class="field-publication-pub_editor">
<div class="row"><div class="col-md-3" align="right"><label class="control-label" for="publication-pub_author">Editor(s)</label>:</div><div class="col-md-8">


<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper2',
        'widgetBody' => '.container-items-editors',
        'widgetItem' => '.editor-item',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-editor',
        'deleteButton' => '.remove-editor',
        'model' => $editors[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'edit_name',
        ],
    ]); ?>
	
	
    <table class="table table-striped">

        <tbody class="container-items-editors">
        <?php foreach ($editors as $indexEd => $editor): ?>
            <tr class="editor-item">
                <td width="5%" class="sortable-handle2 text-center vcenter" style="cursor: move;">
                        <i class="fa fa-arrows"></i>
                    </td>
            
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $editor->isNewRecord) {
                            echo Html::activeHiddenInput($editor, "[{$indexEd}]id");
                        }
                    ?>
                    <?= $form->field($editor, "[{$indexEd}]edit_name")->label(false) ?>
                </td>
                
               

                <td width="5%" class="text-center vcenter">
                    <a class="remove-editor" href="javascript:void(0)"><span class="fa fa-remove"></span></a>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
            <td></td>
                <td colspan="2">
                <button type="button" class="add-editor btn btn-default btn-sm"><span class="fa fa-plus"></span> Add Editor</button>
                
                </td>
 
            </tr>
        </tfoot>
        
    </table>
    
    
    
    <?php DynamicFormWidget::end(); ?>






</div></div>
</div>
					
<?=$form->field($model, 'pub_inbook', [
                    'template' => $model->fieldTempate(6),
                    'options' => [
                    //    'tag' => false, // Don't wrap with "form-group" div
                    ]])->textInput()?>
					
<?=$form->field($model, 'pub_journal', [
                    'template' => $model->fieldTempate(),
                    'options' => [
                     //   'tag' => false, // Don't wrap with "form-group" div
                    ]])->textInput()?>

<?=$form->field($model, 'pub_volume', [
                    'template' => $model->fieldTempate(3),
                    'options' => [
//'tag' => false, // Don't wrap with "form-group" div
                    ]])->textInput()?>

<?=$form->field($model, 'pub_issue', [
                    'template' => $model->fieldTempate(3),
                    'options' => [
                     //   'tag' => false, // Don't wrap with "form-group" div
                    ]])->textInput()?>

<?=$form->field($model, 'pub_page', [
                    'template' => $model->fieldTempate(3),
                    'options' => [
                      //  'tag' => false, // Don't wrap with "form-group" div
                    ]])->textInput()?>

<?=$form->field($model, 'pub_city', [
                    'template' => $model->fieldTempate(6),
                    'options' => [
                      //  'tag' => false, // Don't wrap with "form-group" div
                    ]])->textInput()?>

<?=$form->field($model, 'pub_state', [
                    'template' => $model->fieldTempate(6),
                    'options' => [
                     //   'tag' => false, // Don't wrap with "form-group" div
                    ]])->textInput()?>

<?=$form->field($model, 'pub_publisher', [
                    'template' => $model->fieldTempate(6),
                    'options' => [
                     //   'tag' => false, // Don't wrap with "form-group" div
                    ]])->textInput()?>

<?=$form->field($model, 'pub_isbn', [
                    'template' => $model->fieldTempate(6),
                    'options' => [
                      //  'tag' => false, // Don't wrap with "form-group" div
                    ]])->textInput()?>
<?=$form->field($model, 'pub_organizer', [
                    'template' => $model->fieldTempate(6),
                    'options' => [
                     //   'tag' => false, // Don't wrap with "form-group" div
                    ]])->textInput()?>





<?=$form->field($model, 'pub_index', [
                    'template' => $model->fieldTempate(6),
                    'options' => [
                     //   'tag' => false, // Don't wrap with "form-group" div
                    ]])->textInput()?>
					
				
					
<div class="field-publication-pub_tag">
<div class="row"><div class="col-md-3" align="right"><label class="control-label" for="publication-pub_tag">Tagged Staff</label>:</div><div class="col-md-8">

<?php 
echo Select2::widget([
    'name' => 'tagged_staff',
    'value' => ArrayHelper::map($model->pubTagsNotMe,'id','staff_id'),
    'data' => ArrayHelper::map(Staff::activeStaffNotMe(), 'id', 'staff_name'),
    'options' => ['multiple' => true, 'placeholder' => 'Select '.Yii::$app->params['faculty_abbr'].' Staff ...']
]);

?>

</div>
</div>
</div>



   </div>
</div>

 <div class="form-group">
 
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE AS DRAFT', ['class' => 'btn btn-default', 'name' => 'wfaction', 'value' => 'save']) ?> 
		
		
		
		 <?= Html::submitButton('NEXT <span class="glyphicon glyphicon-arrow-right"></span>', ['class' => 'btn btn-warning', 'name' => 'wfaction', 'value' => 'next']) ?> 
		 
    </div>


    <?php ActiveForm::end(); ?>

</div>


<?php JSRegister::begin(); ?>
<script>
var type = <?php echo $model->pub_type ? $model->pub_type : 0;?>;
manageFields(type);

$("#publication-pub_type").change(function(){
	var showfields = ["month","day","inbook","editor","journal","volume", "issue","page", "city","state","publisher","index","date","organizer","isbn"];
	for (i = 0; i < showfields.length; i++) {
		var element = ".field-publication-pub_" + showfields[i];
		$(element).show();
	}
	
	var pub_type = $(this).val();
	manageFields(pub_type);
	

});

function manageFields(type){
	type = type ? parseInt(type) : 0 ;
	var hidefields = [0];
	var journalhide = ["month","day","inbook","editor","city","state","publisher","date","organizer","isbn"];
	switch (type) {
	case 1:case 0: //journal
		hidefields = journalhide;
		break;
	case 2: //book
		hidefields = ["month","day","inbook","editor","journal","volume", "issue","page","volume", "issue","index","date","organizer","city","state"];
		break;
	case 3: //chapter
		hidefields = ["month","day","volume", "issue","journal","index","date","organizer","isbn"];
		$(".field-publication-pub_inbook div div label").text("Book");
		break;
	case 4: //proceedings
		hidefields = ["month","day","city","journal","volume","editor","issue","index","publisher"];
		$(".field-publication-pub_inbook div div label").text("Proceedings");
		break;
	case 5: //magazine
		hidefields = ["day","city","state","publisher","editor","journal","volume", "issue","index","date","organizer","isbn"];
		$(".field-publication-pub_inbook div div label").text("Magazine");
		break;
	case 6: //newspaper
		hidefields = ["city","state","publisher","editor","journal","volume", "issue","index","date","organizer","isbn"];
		$(".field-publication-pub_inbook div div label").text("Newspaper");
		break;
	}
	
	for (i = 0; i < hidefields.length; i++) {
		var element = ".field-publication-pub_" + hidefields[i];
		$(element).hide();
	}
}



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
$(".container-items-editors").sortable({
    items: "tr",
    cursor: "move",
    opacity: 0.6,
    axis: "y",
    handle: ".sortable-handle2",
    helper: fixHelperSortable,
    update: function(ev){
        $(".dynamicform_wrapper2").yiiDynamicForm("updateContainer");
    }
}).disableSelection();

</script>
<?php JSRegister::end(); 

JuiAsset::register($this);
?>


