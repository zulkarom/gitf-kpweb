<?php

use richardfan\widget\JSRegister;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

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
							<h3 class="panel-title">Review Abstract</h3>
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
  
        ],
    ]) ?>
	
</div>
</div>





<?php $form = ActiveForm::begin(); ?>


<div class="panel panel-headline">

						<div class="panel-body">

<?php 
$model->abstract_decide = null;
	echo $form->field($model, 'abstract_decide')->radioList($model->abstractOptions, [ 'separator' => '<br />'])->label('Choose One:');


	?>


</div>
</div>

<?php ActiveForm::end(); ?>

<?php $form = ActiveForm::begin(); ?>
<div class="panel panel-headline" id="con-accept" style="display:none">

						<div class="panel-body">
 

<div class="row">
<div class="col-md-6">
<?=$form->field($accept, 'abstract_decide')->hiddenInput(['value' => 1])->label(false)?>
</div>
</div>
<div class="form-group">
<?= Html::submitButton('Accept Paper', ['class' => 'btn btn-primary', 'name' => 'wfaction', 'value' => 'reject', 'data' => [
                'confirm' => 'Are you sure to accept this abstract?'
            ],
    ])?>

    </div>
	
	
	
</div>
</div>



<?php ActiveForm::end(); ?>



<?php $form = ActiveForm::begin(); ?>
<div class="panel panel-headline" id="con-reject" style="display:none">

						<div class="panel-body">
 

<div class="row">
<div class="col-md-6">
<?=$form->field($reject, 'abstract_decide')->hiddenInput(['value' => 0])->label(false)?>
<?= $form->field($reject, 'reject_note')->textarea(['rows' => '3']) ?></div>
</div>
<div class="form-group">
<?= Html::submitButton('Reject Paper', ['class' => 'btn btn-danger', 'name' => 'wfaction', 'value' => 'reject', 'data' => [
                'confirm' => 'Are you sure to reject this abstract?'
            ],
    ])?>

    </div>
	
	
	
</div>
</div>



<?php ActiveForm::end(); ?>



</div>



<?php JSRegister::begin(); ?>
<script>
$("input[name='ConfPaper[abstract_decide]']").click(function(){
	if($(this).val() == 1){
		$('#con-accept').slideDown();
		$('#con-reject').slideUp();
	}else if($(this).val() == 0){
		$('#con-accept').slideUp();
		$('#con-reject').slideDown();
	}
});
</script>
<?php JSRegister::end(); ?>
