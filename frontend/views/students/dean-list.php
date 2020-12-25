<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use backend\models\Semester;

$model->semester = Semester::getCurrentSemester()->id;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\proceedings\models\ProceedingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dean\'s List Certificates';
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
<?= $form->field($model, 'semester')->dropDownList(
        Semester::listSemesterArray()
    )->label(false) ?>
	
<div class="row">
<div class="col-md-5"> <?= $form->field($model, 'matric')->textInput() ?></div>

<div class="col-md-7"><?= $form->field($model, 'nric')->textInput() ?>
</div>

</div>
	
   
	
	
</div>



</div>


	
	
<div class="form-group">
        
<?= Html::submitButton('Download', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

		
		
		
		
	        </div>
    </section>

</div>
