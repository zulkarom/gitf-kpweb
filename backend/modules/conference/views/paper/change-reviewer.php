<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\modules\staff\models\Staff;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\ConfPaper */

$this->title =  'Change Reviewer';
$this->params['breadcrumbs'][] = ['label' => 'Conf Papers', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Change Reviewer';
\yii\web\YiiAsset::register($this);
?>
<div class="conf-paper-view">

<div class="panel panel-headline">
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
<?= Html::submitButton('Change Reviewer', ['class' => 'btn btn-primary', 'name' => 'wfaction', 'value' => 'reject'
    ])?>

    </div>
	
	
	
</div>
</div>
<?php ActiveForm::end(); ?>




</div>


