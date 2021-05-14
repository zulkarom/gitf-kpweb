<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\widgets\ActiveForm;
use richardfan\widget\JSRegister;
use kartik\select2\Select2;
use backend\modules\staff\models\Staff;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\ConfPaper */

$this->title = $model->pap_title;
$this->params['breadcrumbs'][] = ['label' => 'Conf Papers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="conf-paper-view">

<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">View Full Paper</h3>
							<p class="panel-subtitle"><?=$this->title?></p>
						</div>
						<div class="panel-body">
			<style>
table.detail-view th {
    width:17%;
}
</style>

			
			<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
				'attribute' => 'user_id',
				'label' => 'Submitted By',
				'value' => function($model){
					return $model->user->fullname;
				}
			],
			[
				'attribute' => 'created_at',
				'label' => 'Submitted Time',
				'format' => 'datetime'
			]
			,
            'pap_title:ntext',
			[
				'label' => 'Authors',
				'format' => 'html',
				'value' => function($model){
					return $model->authorString();
				}
				
			],
            'pap_abstract:ntext',
			'keyword:ntext',
			[
				'attribute' => 'myrole',
				'label' => 'Role Selection',
				'value' => function($model){
					if($model->authorRole){
						return $model->authorRole->fee_name;
					}
					
				}
				
			],
			[
				'attribute' => 'paper_file',
				'label' => 'Uploaded Full Paper',
				'format' => 'raw',
				'value' => function($model){
					return Html::a('<span class="glyphicon glyphicon-download-alt"></span> DOWNLOAD FILE', ['paper/download-file', 'id' => $model->id, 'attr' => 'paper'], ['class' => 'btn btn-default','target' => '_blank']);
				}
			]
  
        ],
    ]) ?></div>
</div>





<?php $form = ActiveForm::begin(); ?>
<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title"></h3>
							<p class="panel-subtitle"></p>
						</div>
						<div class="panel-body"> 

<?php 
	
	echo $form->field($model, 'full_paper_decide')->radioList($model->fullPaperOptions, [ 'separator' => ''])->label('Choose One:');


	?>
</div>
</div>
<?php ActiveForm::end(); ?>
<?php $form = ActiveForm::begin(); ?>
<div class="panel panel-headline" id="con-review">

						<div class="panel-body">
 

<div class="row">
<div class="col-md-6">

		<?php
		echo $form->field($reviewer, 'full_paper_decide')->hiddenInput()->label(false);
		echo $form->field($reviewer, 'reviewer_user_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Staff::getAcademicStaff(), 'user_id', 'user.fullname'),
    'options' => ['placeholder' => 'Select a reviewer ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);

?>

</div>
</div>
<div class="form-group">
<?= Html::submitButton('Assign Reviewer', ['class' => 'btn btn-primary', 'name' => 'wfaction', 'value' => 'reject'
    ])?>

    </div>
	
	
	
</div>
</div>
<?php ActiveForm::end(); ?>

<?php $form = ActiveForm::begin(); ?>
<div class="panel panel-headline" id="con-invoice" style="display:none">

						<div class="panel-body">

<?php
if($model->conference->commercial == 1){
	$local = $model->conference->currency_local;
	$int = $model->conference->currency_int;
	$curr = [$local => $local, $int=>$int];

	if($model->myrole){
		if(!$model->invoice_currency){
			$model->invoice_currency = $model->authorRole->fee_currency;
		}
		if($model->invoice_amount == 0){
			$model->invoice_amount = $model->authorRole->fee_amount;
		}
		if($model->invoice_final == 0){
			$model->invoice_final = $model->authorRole->fee_amount;
		}
		if($model->invoice_early == 0){
			$model->invoice_early = $model->authorRole->fee_early;
		}
		
	}

	echo $form->field($accept, "invoice_currency")->dropDownList($curr);


 
 
?>

<div class="row">
<div class="col-md-3"><?= $form->field($accept, 'invoice_amount'); ?></div>

</div>

<div class="row">
<div class="col-md-4"><?= $form->field($accept, 'invoice_final'); ?></div>
</div>

<div class="row">
<div class="col-md-4"><?= $form->field($accept, 'invoice_early'); ?></div>
</div>

<?php } ?>
	
<div class="form-group">
<?php
if($model->conference->commercial == 1){
	
	echo Html::submitButton('Save', ['class' => 'btn btn-default', 'name' => 'wfaction', 'value' => 'save'
    ]);
$btn_text = 'Accept Full Paper & Issue Invoice';
}else{
$btn_text = 'Accept Full Paper';	
}
?>

	
<?php 
echo $form->field($accept, 'full_paper_decide')->hiddenInput(['value' => 1])->label(false);
echo Html::submitButton($btn_text, ['class' => 'btn btn-primary', 'name' => 'wfaction', 'value' => 'accept', 'data' => [
                'confirm' => 'Are you sure to accept this paper?'
            ],
    ])?>

    </div>
	
	<div class="form-group">
	<i>
	<?php 
	if($model->conference->commercial == 1){
	echo Html::a('<span class="glyphicon glyphicon-search"></span> Preview Invoice', ['paper/invoice-pdf', 'id' => $model->id], ['target' => '_blank']);
	}
	?>   

<?= Html::a('<span class="glyphicon glyphicon-search"></span> Preview Acceptance Notice', ['paper/accept-letter-pdf', 'id' => $model->id], ['target' => '_blank'])?></i>
	
	</div>
	
	
</div>
</div>
<?php ActiveForm::end(); ?>
<?php $form = ActiveForm::begin(); ?>
<div class="panel panel-headline" id="con-reject" style="display:none">

						<div class="panel-body">
 

<div class="row">
<div class="col-md-6">
<?=$form->field($reject, 'full_paper_decide')->hiddenInput()->label(false)?>
<?= $form->field($reject, 'reject_note')->textarea(['rows' => '3']) ?></div>
</div>
<div class="form-group">
<?= Html::submitButton('Reject Paper', ['class' => 'btn btn-danger', 'name' => 'wfaction', 'value' => 'reject', 'data' => [
                'confirm' => 'Are you sure to reject this paper?'
            ],
    ])?>

    </div>
	
	
	
</div>
</div>



<?php ActiveForm::end(); ?>

</div>


<?php 
	if($model->conference->commercial == 1){
	?>
	
	
<p>
* Early Bird Date: <?=$model->conference->earlyBirdDate?><br />
<b>* Payment Table</b></p>

<div class="table-responsive">
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Categories</th>
        <th>Early Bird</th>
        <th>Normal</th>
      </tr>
    </thead>
    <tbody>
	
	<?php 
	$fees = $model->conference->confFees;
	if($fees ){
		foreach($fees as $fee){
			echo '<tr>
        <td>'.$fee->fee_name .'</td>
        <td>'.$fee->fee_currency .' '.$fee->fee_early .'</td>
        <td>'.$fee->fee_currency .' '.$fee->fee_amount .'</td>
      </tr>';
		}
		
	}
	
	
	?>
      
    </tbody>
  </table>
</div>
	
	<?php
	}
	?>


<?php JSRegister::begin(); ?>
<script>
$("input[name='ConfPaper[full_paper_decide]']").click(function(){
	if($(this).val() == 1){
		$('#con-invoice').slideDown();
		$('#con-review').slideUp();
		$('#con-reject').slideUp();
	}else if($(this).val() == 0){
		$('#con-invoice').slideUp();
		$('#con-review').slideUp();
		$('#con-reject').slideDown();
	}else if($(this).val() == 2){
		$('#con-invoice').slideUp();
		$('#con-reject').slideUp();
		$('#con-review').slideDown();
	}
});
</script>
<?php JSRegister::end(); ?>