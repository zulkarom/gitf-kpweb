<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
use backend\modules\esiap\models\AssessmentCat;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'Update: ' . $model->course->course_name;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>


<div class="box">
<div class="box-header"></div>
<div class="box-body">

<?php

$plo_num = $model->plo_num;


$form = ActiveForm::begin(['id' => 'form-clo-plo']);

echo $form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false);

if($clos){
	echo '<table class="table">
	<thead>
	<tr>
		<th width="6%">#</th>
		<th width="50%">CLO</th>';
	
	for($i=1;$i<=$plo_num;$i++){
		echo '<th>PLO'.$i.'</th>';
	}
		
	echo '</tr>
	</thead>
	';
	$x = 1;
	
	foreach($clos as $index => $clo){
		echo '<tr>';
		echo '<td style="vertical-align:middle;" >CLO'.$x.'</td>';
		echo '<td style="vertical-align:middle;">' . $clo->clo_text . '<br /><i>'.$clo->clo_text_bi.'</i></td>';
		
		for($i=1;$i<=$plo_num;$i++){
			$prop = 'PLO'.$i;
			$check = $clo->{$prop} == 1 ? 'checked' : '';
			echo '<td>';
			echo '<input type="hidden" name="plo['.$clo->id .'][PLO'.$i.']" value="0" />';
			echo '<input type="checkbox" name="plo['.$clo->id .'][PLO'.$i.']" value="1" '.$check.' />';
			echo '</td>';
		}
		
		echo '</tr>';
		
		$x++;
	}
	echo '</table>';
}
?>
<div class="form-group">
        <?= Html::submitButton('SAVE CLO PLO', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end()?>


</div>
</div>

