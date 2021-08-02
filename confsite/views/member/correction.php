<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use backend\modules\conference\models\ReviewForm;
use confsite\models\UploadFile;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
use yii\helpers\ArrayHelper;
use confsite\models\UploadPaperFile;


/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\ConfPaper */

$this->title = 'Upload Paper: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Conf Papers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$model->file_controller = 'member';
?>
<style>
.table td, .table th {
    border: none;
}
label{
	font-weight:bold;
}
	</style>
<div class="conf-paper-update">

    <h4 class="m-text23 p-b-34">Paper Correction</h4>


    <h4><?=$model->pap_title ?></h4>
    <br />
  <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'pap_title:ntext',
            'pap_abstract:ntext',
			'keyword:ntext',
			
			[
				'attribute' => 'paper_file',
				'label' => 'Uploaded Full Paper',
				'format' => 'raw',
				'value' => function($model){
					return Html::a('<span class="glyphicon glyphicon-download-alt"></span> DOWNLOAD FILE', ['member/download-file', 'id' => $model->id, 'confurl' => $model->conference->conf_url, 'attr' => 'paper'], ['class' => 'btn btn-warning','target' => '_blank']);
				}
			]
  
        ],
    ]) ?>
	<br /><br />

     <h4 class="m-text23 p-b-34">Reviewer's Remark</h4>
<table class="table table-striped table-hover">
<thead>
<tr>
	<th width="3%">#</th>
	<th width="35%">Review Items</th>
	<th>Remark</th>
</tr>
</thead>
<tbody>
	
	<?php 
	
	$i =1;
	foreach(ReviewForm::find()->all() as $f){
	    $attr = 'q_'. $i . '_note';
	    echo '<tr>
		<td>'.$i.'. </td>
		<td>'.$f->form_quest.'</td>
	
		<td> ' . $review->$attr .' </td>
	</tr>';
	$i++;
	}
	
	
	if($review->reviewed_file){
	    echo '<tr>
	<td>#</td>
	<td>Reviewer\'s Uploaded File</td>
	<td>'. Html::a('Download', ['reviewer/download-file', 'attr' => 'reviewed', 'id' => $review->id, 'confurl' => $model->conference->conf_url], ['class' => 'btn btn-primary'] ) .'</td>
	</tr>';
	}
	?>
	
	
</tbody>
</table>

   <br /><br />
     <h4 class="m-text23 p-b-14">Resubmit Form</h4>
     Kindly make correction at this section
     <br /><br />
<div class="conf-paper-form">

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>


	
	
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

 


	<br />
    
    
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

<br />
	
	
	<?=UploadPaperFile::fileInput($model, 'repaper', $model->conference->conf_url)?>
	
	


<br />
    <div class="form-group">
        <?= Html::submitButton('SUBMIT PAPER', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


</div>

