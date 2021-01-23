<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\staff\models\Staff;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\modules\aduan\models\Aduan */

$this->title = 'Aduan Setting';
$this->params['breadcrumbs'][] = ['label' => 'Aduan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;






?>
Emel notifikasi dihantar ke email pegawai penyelia.
<br /><br />
 <?php $form = ActiveForm::begin(); ?>
<div class="row">
		<div class="col-md-8">
		
<?php 


echo $form->field($model, 'penyelia')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Staff::activeStaff(),'id','nameAndEmail'), 
    'options' => ['placeholder' => 'Select a staff ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);

?>
		
		
		</div>

	</div>   


<h3 class="timeline-header">
	
	<?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>


</h3>

<?php ActiveForm::end(); ?>