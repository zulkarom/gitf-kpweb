<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module $module
 */

$this->title = 'TAUGHT COURSES BY ACADEMIC STAFF';
$this->params['breadcrumbs'][] = $this->title;

?>
<?php $form = ActiveForm::begin([]) ?>							

			
<div class="row">
<div class="col-md-3"></div>
<div class="col-md-5">
Due Date: <?=date('d M Y' , strtotime($setting->date_end))?>
<br />
Time Remaining: <span style="color:red">
<?php 
if(strtotime($setting->date_end) < time()){
	echo '---';
}else{
	$now = new \DateTime();
$future_date = new \DateTime($setting->date_end . ' 11:59:59');
//$future_date->modify('+ 8 hours');
$interval = $future_date->diff($now);

echo $interval->format("%a days, %h hours");
}


?>
</span>
<br />

* fill in your staff number below and click next.	
<br /><br />
<?= $form->field($staff, 'staffno')->textInput(); ?>


<div class="form-group">
        
<?= Html::submitButton('NEXT', ['class' => 'btn btn-success']) ?>
    </div>


</div>

</div>
				
 

<?php ActiveForm::end(); ?>

