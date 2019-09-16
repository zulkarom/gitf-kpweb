<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'Update: ' . $model->course->course_name;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Reference';
?>

 <?php $form = ActiveForm::begin(); ?>
	
<div class="box">
<div class="box-header"></div>
<div class="box-body">	


<a href="<?=Url::to(['course/course-reference-add', 'course' => $model->course->id, 'version' => $model->id])?>" id="btn-add" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> Add Reference</a>

<table class="table table-striped table-hover">
<thead>
	<tr>
		<th>No.</th>
		<th>Author(s)</th>
		<th width="10%">Year</th>
		<th>Title</th>
		<th>Others</th>
		<th>Main</th>
		<th style="text-align:center">Classic<br />Work</th>
		<th></th>
	</tr>
</thead>
<?php 
$curr = date('Y');
$min = $curr - 4;
$script="[";
if($ref){
	$i = 1;
	
	foreach($ref as $row){
		if($i==1){$comm="";}else{$comm=", ";}
		$script .= $comm.$row->id;
		$yr = $row->ref_year;
		echo '<tr>
	<td>'.$i.'. <input type="hidden" value="'. $yr .'" id="curryear-'.$row->id.'" /></td>
		<td><textarea class="form-control" name="ref['.$row->id .'][author]" id="ref-author-'.$row->id .'">'.$row->ref_author .'</textarea></td>
		<td id="con-'.$row->id .'">';
		
		echo '<input type="text" name="ref['.$row->id .'][year]" id="ref-year-'.$row->id .'" class="form-control" value="'.$row->ref_year .'" />';
		
		echo '</td>
		<td><textarea class="form-control" name="ref['.$row->id .'][title]" id="ref-title-'.$row->id .'">'.$row->ref_title .'</textarea></td>
		<td><textarea class="form-control" name="ref['.$row->id .'][others]" id="ref-others-'.$row->id .'">'.$row->ref_others .'</textarea></td>';
		$main = $row->is_main;
		$check = $main == 1 ? "checked" : "" ;
		echo '<td><input type="hidden" name="ref['.$row->id .'][main]" value="0" /><input type="checkbox" name="ref['.$row->id .'][main]" value="1" '.$check.' /></td>
		<td>
		';
		$clas = $row->is_classic;
		if($clas == 1){
			$chk = "checked";
		}else{
			$chk = "";
		}
		echo '<input type="hidden" value="0" name="ref['.$row->id .'][isclassic]" id="chk-'.$row->id .'" class="chk-classic" /><input type="checkbox" value="1" name="ref['.$row->id .'][isclassic]" id="chk-'.$row->id .'" '.$chk.' class="chk-classic" />';

		echo '</td>
		<td><a href="'. Url::to(['course/course-reference-delete', 'course' => $model->course->id, 'version' => $model->id]).'" class="rmv-ref" id="remove-'.$row->id .'"><span class="glyphicon glyphicon-remove"></span></a></td>
		
	</tr>';
	echo '<tr><td></td><td colspan="4" id="bib-'.$row->id .'"></td><td colspan="2"></td></tr>';
	$i++;
	}
	
}
$script .="]";
?>
	
</table>


    
</div>
</div>


    <div class="form-group">
        <?= Html::submitButton('Save Reference', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

<?php 

$js = '

putAllBib()

function putAllBib(){
	var arr =  ' . $script . ';
	for(i=0;i<arr.length;i++){
		putBib(arr[i]);
	}
}

function putBib(id){
	$("#bib-"+id).html(stringBib(id));
}

function stringBib(id){
	var au = $("#ref-author-"+id).val();
	var year = $("#ref-year-"+id).val();
	var title = $("#ref-title-"+id).val();
	var others = $("#ref-others-"+id).val();
	if(others=="" || title ==""){
		comma = "";
	}else{
		comma = ", ";
	}
	var bib = "<strong><span class=\'glyphicon glyphicon-book\'></span> " + au + " (" + year + ") " + "<i>" + title + "</i>"  + comma + others + "</strong>";
	
	return bib;
}

';

$this->registerJs($js);

?>