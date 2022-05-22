<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use backend\modules\downloads\models\DownloadCategory;


/* @var $this yii\web\View */
/* @var $searchModel backend\modules\proceedings\models\ProceedingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'E-certificate';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="proceeding-index">

   
<section class="contact-page spad pt-0">
        <div class="container">
		
	<h3><?= Html::encode($this->title) ?></h3>	
	<br />
	
<?php $form = ActiveForm::begin(); ?>

<div class="row">
<div class="col-md-7">
<?= $form->field($model, 'category')->dropDownList(
        DownloadCategory::activeCategories(), ['prompt' => 'Select a category']
    ) ?>
	
<div class="row">

<div class="col-md-12"><?= $form->field($model, 'nric')->textInput() ?>
</div>

</div>
	
   
	
	
</div>



</div>


	
	
<div class="form-group">
        
<?= Html::submitButton('<i class="fa fa-download"></i> Download', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

		
		
		
		
	        </div>
    </section>

</div>
