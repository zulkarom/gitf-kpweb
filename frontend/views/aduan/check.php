<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\proceedings\models\ProceedingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Check Status';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="proceeding-index">

   
<section class="contact-page spad pt-0">
    <div class="container">
		
	<h3><?= Html::encode($this->title) ?></h3>	
	<br />
	
<?php $form = ActiveForm::begin(); ?>

<div class="row">
<div class="col-md-6">
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>
</div>

<div class="col-md-6">
</div>

</div>



<div class="form-group">
        
	<?= Html::submitButton('Check Status', ['class' => 'btn btn-success']) ?>
</div>

<div class="row">
<div class="col-md-6">
<div class="box box-primary">
<div class="box-body">
  	
		<?php
		if($modelAduan){

			echo'<table class="table table-striped table-hover">
				<tbody>
				<tr>
				<th>Aduan Id</th>
				<th>Email</th>
				<th>Status</th>
				<th>Action</th>';

			foreach ($modelAduan as $list) {
				echo'<tr>
					<td>'.$list->id.'</td>
					<td>'.$list->email.'</td>
					<td>'.$list->progress->progress.'</td>
					<td>'.Html::a('Update', ['update', 'id' => $list->id]).'</td>
					</tr>
				';	
			}
		}

		?>
	</tbody>
	</table>
</div>
</div>
</div>
</div>

    <?php ActiveForm::end(); ?>

	</div>
</section>

</div>
