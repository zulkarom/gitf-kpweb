<?php

use yii\helpers\Html;
use yii\helpers\Url;



/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Course Resources';
$this->params['breadcrumbs'][] = ['label' => 'My Course File', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = $this->title;
$version = $offer->courseVersion;
?>
<h4><?=$offer->semester->longFormat()?></h4>
<h4><?=$course->course_code?> <?=$course->course_name?></h4>


<div class="row">
	<div class="col-md-6">
	
	<div class="form-group">
	<div class="row">
	<div class="col-md-6"><h4 style="font-size:22px">Course Information</h4></div>
	<div class="col-md-6" align="right">
	
	
	<?php 
	if($version){
	    echo $course->reportList('View Doc Report', $version->id);
	}
	
	
	?>
	

</div>
	
	</div>
</div>
	
	
	<?php  
	if($version){
	    
	    ?>
	    
	    	<div class="box">
<div class="box-header"><div class="box-title">Synopsis</div></div>
<div class="box-body">
<?=$version->profile->synopsis?>
<br /><br />
<i><?=$version->profile->synopsis_bi?></i>


</div>
</div>
	    
	    
	    	    
	    	<div class="box">
<div class="box-header"><div class="box-title">Syllabus</div></div>
<div class="box-body">

<table class='table'>
	<thead>
	<tr>
	<th width="5%">WEEK</th>
	<th>TOPICS</th>
	
	
	
	</tr>

	</thead>
<?php 
$syll = $version->syllabus;
$arr_syll = "";
$i=1;
$week_num = 1;
$total = 0;
foreach($syll as $row){ ?>
	<tr>
	<td>
	<?php 
	$show_week = '';
	if($row->duration > 1){
		$end = $week_num + $row->duration - 1;
		$show_week = $week_num . '-' . $end;
	}else{
		$show_week = $week_num;
	}
	$arr_week[$week_num] = 'WEEK ' . $show_week;
	
	echo $show_week;
	
	$week_num = $week_num + $row->duration;
	
	
	
	
	?>

	</td>
	<td>
	
		<?php 
		$arr_syll .= $i == 1 ? $row->id : ", " . $row->id ;
		$arr_all = json_decode($row->topics);
		if($arr_all){
		foreach($arr_all as $rt){
		echo $rt->top_bm ." / <i>". $rt->top_bi . "</i>";
		if($rt->sub_topic){
		echo "<ul>";
			foreach($rt->sub_topic as $rst){
			echo "<li>".$rst->sub_bm . " / <i>" . $rst->sub_bi . "</i></li>";
			}
		echo "</ul>";
		}
		} 
		} 
		?>
		
	</td>
	
	</tr>
<?php 
$i++;
}
?>

</table>


</div>
</div>



	    	<div class="box">
<div class="box-header"><div class="box-title">Assessment</div></div>
<div class="box-body">

<table class="table">
<thead>
	<tr> 
	<th>#</th>
		<th>Name</th>
		<th>Percentage</th>
	</tr>
</thead>
<?php

$form = $version->courseAssessmentFormative;
$sum = $version->courseAssessmentSummative;
$i=1;
if($form){
    foreach($form as $rhead){
        echo "<tr>
            <td>" . $i . ". </td>
            <td>".$rhead->assess_name ." / <i>".$rhead->assess_name_bi ."</i></td>
			<td>" . $rhead->as_percentage . "%</td>
		
			</tr>
			";
        $i++;
    }
}

if($sum){
    foreach($sum as $rhead){
        echo "<tr>
            <td>" . $i . ". </td>
            <td>".$rhead->assess_name ." / <i>".$rhead->assess_name_bi ."</i></td>
			<td>" . $rhead->as_percentage . "%</td>
	    
			</tr>
			";
        $i++;
    }
}


?>
</table>

</div></div>

	 <?php   
	}else{
	    echo 'The coordinator have not set the course information for this semester';
	}
	
	
	?>

	
	
	</div>
	<div class="col-md-6">
	<h4 style="font-size:22px">Course Materials</h4>
	
	
	<?php  
	
	if($course->activeMaterials){
	    foreach($course->activeMaterials as $material){
	        ?> 
	        
	        	<div class="box">
<div class="box-header"><div class="box-title"><?php echo $material->material_name ?></div></div>
<div class="box-body">

  <table class="table table-striped table-hover">
  <thead>
  <tr>
  <th width="5%">#</th>
  <th width="50%">Document Name</th>
  <th>Uploaded Files</th>
  </tr>
</thead>
<tbody>
	<?php 
	if($material->items){
		$i = 1;
		foreach($material->items as $x => $item){
			?>
			<tr>
			<td><?=$i?>. </td>
			<td>
			<?=$item->item_name?>
			
			</td>
				<td><?php 
				
				if($item->item_file){
					echo Html::a('<span class="glyphicon glyphicon-download-alt"></span>', ['download-file', 'attr'=> 'item', 'id' => $item->id] , ['class' => 'btn btn-sm btn-danger', 'target' => '_blank']);
				}else{
					echo 'No File';
				}
				
				
				
				?></td>
			</tr>
			<?php
		$i++;
		}
	}
	
	?>
</tbody>
</table>


</div></div>
	        
	        <?php 
	    }
	}else{
	    echo 'There is no active course material for this course';
	}
	
	
	?>

	
	</div>
</div>






