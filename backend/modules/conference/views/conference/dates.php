<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\Conference */

$this->title = 'IMPORTANT DATES: ' . $model->conf_abbr;
$this->params['breadcrumbs'][] = ['label' => 'Conferences', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
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
        'model' => $dates[0],
        'formId' => 'dynamic-form',
        'formFields' => [
			'id',
            'date_name',
			'date_start'
        ],
    ]); ?>

    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
			<th width="1%" align="center">#</th>
                <th>Date Label</th>
				
                <th width="25%">Date</th>
				<th width="5%">Show</td>
                <th class="text-center" style="width: 90px;">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php 
		$no = 1;
		foreach ($dates as $i => $date): ?>
            <tr class="date-item">
            <td style="vertical-align:middle"><?=$no?>. </td>
                <td class="vcenter" style="vertical-align:middle">
                    <?php
                        // necessary for update action.
                        if (! $date->isNewRecord) {
                            echo Html::activeHiddenInput($date, "[{$i}]id");
                        }
                    ?>
                    <?php
					if($date->dateName){
						echo $date->dateName->date_name;
					}
					 ?>
                </td>
				
				
                
                <td class="vcenter">
          
                    
                     <?=$form->field($date, "[{$i}]date_start")->widget(DatePicker::classname(), [
                        'removeButton' => false,
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                            
                        ],
                        
                        
                    ])->label(false);

                    ?>

                </td>
				
				<td>
				
				<?= $form->field($date, "[{$i}]published")->checkbox(['value' => '1', 'label'=> '']); ?>
				</td>

                <td class="text-center vcenter" style="width: 90px; verti">
                   
                </td>
            </tr>
         <?php 
		 $no++;
		 endforeach; ?>
        </tbody>
        

        
    </table>
    <?php DynamicFormWidget::end(); ?>
	
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

jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
	$( ".krajee-datepicker" ).each(function() {
	   $(this).removeData().kvDatepicker('destroy');
		$(this).kvDatepicker(eval($(this).attr('data-krajee-kvdatepicker')));
  });          
});


EOD;

$this->registerJs($js);
?>

