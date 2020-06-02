<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Upload;
use backend\modules\erpd\models\Status;


$this->title = 'View Consultation';
$this->params['breadcrumbs'][] = ['label' => 'Research', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'View';

?>


<?=$this->render('_view_all', [
			'model' => $model
	])?>

<?=Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Back to Consultation List', ['/erpd/consultation'],['class'=>'btn btn-default'])?>

 <?php 
if(in_array($model->status, Status::userStatusEdit())){
	 
	 echo Html::a('<span class="glyphicon glyphicon-pencil"></span> Re-Update', ['/erpd/consultation/re-update', 'id' => $model->id],['class'=>'btn btn-default']);
 }
 
 
 
 ?>
