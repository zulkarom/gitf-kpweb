<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use backend\modules\conference\models\UploadFile;

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\ConfPaper */

$this->title = $model->pap_title;
$this->params['breadcrumbs'][] = ['label' => 'Papers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$model->file_controller = 'member';
?>
<div class="conf-paper-view">


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
					return Html::a('DOWNLOAD', ['paper/download-file', 'id' => $model->id, 'attr' => 'paper'], ['target' => '_blank']);
				}
			],
			[
				'label' => 'Acceptance Letter',
				'format' => 'raw',
				'value' => function($model){
					return Html::a('DOWNLOAD ACCEPTANCE LETTER', ['member/accept-letter-pdf', 'id' => $model->id], ['class' => 'btn btn-info btn-sm','target' => '_blank']);
				}
				
			],
			[
				'label' => 'Invoice',
				'format' => 'raw',
				'value' => function($model){
					return Html::a('DOWNLOAD INVOICE', ['member/invoice-pdf', 'id' => $model->id], ['class' => 'btn btn-info btn-sm','target' => '_blank']);
				}
				
			],
  
        ],
    ]) ?>



</div>

<br />
<div class="form-group"><h5>Bank Transfer Payment Method</h5>
<i>Please fill in the payment information below after you have made bank transfer.</i></div>


<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'payment_info')->textarea(['rows' => '4']) ?> 







<?=UploadFile::fileInput($model, 'payment')?>


<div class="form-group">
        
<?= Html::submitButton('Submit Payment', ['class' => 'btn btn-success']) ?>
    </div>


<?php ActiveForm::end(); ?>