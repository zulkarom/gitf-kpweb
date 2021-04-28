<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\ConfPaper */

$this->title = 'Review Payment : ' . Html::encode($model->pap_title);
$this->params['breadcrumbs'][] = ['label' => 'Papers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="conf-paper-view">

<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Review Payment</h3>
							<p class="panel-subtitle"><?=Html::encode($model->pap_title)?></p>
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
				'attribute' => 'Status',
				'format' => 'html',
				'value' => function($model){
					return $model->paperStatus;
				}
				
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
			[
				'attribute' => 'myrole',
				'label' => 'Role Selection',
				'value' => function($model){
					if($model->authorRole){
						return $model->authorRole->fee_name;
					}
					
				}
				
			],
			'pap_title:ntext',
			[
				'label' => 'Invoice',
				'format' => 'raw',
				'value' => function($model){
					if($model->payment_file){
						return '<a href="'.Url::to(['paper/invoice-pdf', 'id' => $model->id]).'" target="_blank" class="btn btn-default btn-sn"><i class="fa fa-download"></i> DOWNLOAD</a>';
					}else{
						return 'NO FILE';
					}
					
				}
				
			],
			[
				'label' => 'Invoice Amount',
				'value' => function($model){
					return $model->invoice_currency . ' ' . number_format($model->invoice_amount, 2);
					
				}
				
			],
			[
				'attribute' => 'payment_at',
				'label' => 'Submitted At',
				'format' => 'datetime'
				
			],
			'payment_info:ntext',
			[
				'attribute' => 'payment_file',
				'format' => 'raw',
				'value' => function($model){
					if($model->payment_file){
						return '<a href="'.Url::to(['paper/download-file', 'attr' => 'payment', 'id' => $model->id]).'" target="_blank" class="btn btn-warning btn-sn"><i class="fa fa-download"></i> DOWNLOAD PAYMENT</a>';
					}else{
						return 'NO FILE';
					}
					
				}
				
			],
			
	
  
        ],
    ]) ?></div>
</div>



</div>

<?php $form = ActiveForm::begin(); ?>
<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">Payment Confirmation</h3>
						</div>
						<div class="panel-body">
						
	
	
	<div class="form-group">
	<?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>
<?= Html::submitButton('<i class="fa fa-check"></i> Accept Payment & Issue Receipt', ['class' => 'btn btn-success', 'name' => 'wfaction', 'value' => '1', 'data' => [
                'confirm' => 'Are you sure to accept this payment?'
            ],
    ])?>
	
	<?= Html::submitButton(' Reject Payment', ['class' => 'btn btn-danger', 'name' => 'wfaction', 'value' => '0', 'data' => [
                'confirm' => 'Are you sure to reject this payment?'
            ],
    ])?>

    </div>
						
						
						</div>
</div>
<?php ActiveForm::end(); ?>
