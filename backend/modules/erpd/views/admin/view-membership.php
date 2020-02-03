<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\Publication */

$this->title = 'Verify Membership';
$this->params['breadcrumbs'][] = ['label' => 'Membership', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Verify';

?>


<?=$this->render('../membership/_view_all', ['model' => $model])?>





<?php $form = ActiveForm::begin(); ?>

<?=$form->field($model, 'reviewed_at')->hiddenInput(['value' => time()])->label(false)?>


<div class="form-group">

<?=Html::a('<span class="glyphicon glyphicon-arrow-left"></span> BACK', ['/erpd/admin/membership'],['class'=>'btn btn-default'])?>  


	
	<?php 
	
	
	
	if(in_array($model->status, \backend\modules\erpd\models\Status::adminStatusAction())){
		echo Html::submitButton('<span class="glyphicon glyphicon-ok"></span> VERIFY', 
		['class' => 'btn btn-primary', 'name' => 'wfaction', 'value' => 'verify', 'data' => [
					'confirm' => 'Are you sure to verify the membership?'
				],
		]);
	
	?>



<br /><br />
    </div>
<div class="row">
<div class="col-md-6"><?= $form->field($model, 'review_note')->textarea(['rows' => '6']) ?></div>

</div>

	
	<?=Html::submitButton('<span class="glyphicon glyphicon-pencil"></span> MODIFY', 
    ['class' => 'btn btn-warning', 'name' => 'wfaction', 'value' => 'correction', 'data' => [
                'confirm' => 'Are you sure to request the staff to correct the membership?'
            ],
    ])?>


<?php 

	}
?>


    <?php ActiveForm::end(); ?>


