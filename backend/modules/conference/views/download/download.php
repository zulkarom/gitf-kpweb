<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
use kartik\date\DatePicker;
use backend\modules\conference\models\UploadFile;
use common\models\UploadFileFirewall;

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\Conference */

$this->title = 'DOWNLOADS: ' . $model->conf_abbr;
$this->params['breadcrumbs'][] = ['label' => 'Conferences', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Download';
?>
<div class="conference-update">

<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title"><?=$this->title?></h3>
						</div>
						<div class="panel-body">
<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

<?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>


    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
              
                <th>Download Label</th>
                <th width="55%">File</th>
      
            </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($downloads as $i => $d): ?>
            <tr class="date-item">
     
            
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
				
					<?php $d->file_controller = 'download';?>
          
                    <?=UploadFileFirewall::fileInput($d, 'download', false, true)?>
  

                </td>

          
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
       
                <td colspan="2">
                <a href="<?=Url::to(['download/create','conf' => $model->id])?>" class="add-date btn btn-default btn-sm"><span class="fa fa-plus"></span> New Download</a>
                
                </td>
         
            </tr>
        </tfoot>
        
    </table>


    <br />
    <div class="form-group">
        <?= Html::submitButton('Save Download', ['class' => 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>
		
			
			
			</div>
</div>

</div>



