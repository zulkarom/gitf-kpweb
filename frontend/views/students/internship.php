<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\proceedings\models\ProceedingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Internship';
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
    <?= $form->field($model, 'matric')->textInput() ?>
	
	<?= $form->field($model, 'nric')->textInput() ?>
</div>

<div class="col-md-6">
</div>

</div>


	
	
<div class="form-group">
        
<?= Html::submitButton('Download Letter', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

		
		
		
		
	        </div>
    </section>

</div>
