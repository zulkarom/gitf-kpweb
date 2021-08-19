<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use backend\modules\courseFiles\models\Common;

$closed = Common::isDue($offer->semesterDates->open_deadline);

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */
$course = $offer->course;
$offered_id = $offer->id;
$course_version = $offer->course_version;
$this->title = 'Coordinator';
$this->params['breadcrumbs'][] = ['label' => 'My Course File', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = $this->title;

if(!$closed){
?>


<div class="row">
<div class="col-md-10"><h4><?=$course->course_code . ' ' . $course->course_name?> - <?=$offer->semester->longFormat()?></h4></div>

</div>


<?php 
$note = '';

echo '<a href="' . Url::to(['default/coordinator-view', 'id' => $offer->id]) . '" class="btn btn-primary" ><span class="glyphicon glyphicon-search"></span> Preview & Submission</a> ';

if($offer->status == 20){
    $checker = false;
	if($offer->auditor_file){
	    $checker = 'Auditor';
		echo '<a href="' . Url::to(['auditor/download-file', 'attr' => 'auditor', 'id' => $offer->id]) . '" class="btn btn-warning" target="_blank"><span class="fa fa-file"></span> Auditor\'s Report</a>';
	}
	
	if($offer->verified_file){
		$checker = 'UJAKA';
		echo ' <a href="' . Url::to(['auditor/download-file', 'attr' => 'verified', 'id' => $offer->id]) . '" class="btn btn-info" target="_blank"><span class="fa fa-file"></span> UJAKA\'s Report</a>';
	}
	if($checker){
	    $note = '<br /><br /><div class="form-group" style="color:red">Please update the course file with reference to the '.$checker.'\'s Report above. '  . Common::deadlineMessage($dates->open_deadline) . '</div>';
	}
		

}

echo $note;

?>



<h4>Course Information & Teaching Material</h4>
<div class="box">


<div class="box-body">
<?php $form = ActiveForm::begin(['id' => 'course-material-form']); ?>

<table class="table">
<thead>

<tr>
<th width="5%">No.</th>
<th width="20%">Items</th>
<th style="width:45%">Select Version/Group</th>
<th style="width:10%">View</th>
<th style="width:10%">Update</th>
<th width="10%">Progress</th>
</tr>


</thead>

<tr>
<td>1. </td>
<td><b>Course Information Version</b></td>
<td><?php  
$array = ArrayHelper::map($offer->course->versionNotArchived, 'id', 'versionNameAndStatus');
$array[-1] = ' <Manage Version> ';
echo $form->field($offer, 'course_version')->dropDownList($array, ['prompt' => 'Please Select'])->label(false) ?>

<?php 
if(!$offer->course->versionSubmit){
	echo '<i>* Please make sure the version is submitted first. Please click the Update button.</i>';
}
?>

</td>
<td><?php 
$count_doc = 0;
if($course_version > 0){
	$count_doc = 4;
}
 Modal::begin([
                      'header' => '<h5>Course Information</h5>',
                      'toggleButton' => ['label' => 'View Files ('.$count_doc.')', 'class'=>'btn btn-sm btn-default'],
                  ]);
                      echo '<table class="table">
                                <tr>
                                <th>#</th>
                                <th>File Name</th>
                                <th>Action</th>
                                </tr>';
		if($course_version > 0){
				?>
				
				<tbody><tr>
		<td width="5%">1.</td>
		<td>FK01 - PRO FORMA KURSUS / <i>COURSE PRO FORMA</i>                             </td>
		<td><a href="<?=Url::to(['/esiap/course/fk1', 'course' => $course->id, 'version' => $course_version])?>" target="_blank" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-download-alt"></span> Download</a></td>
	</tr>
	<tr>
		<td width="5%">2.</td>
		<td>FK02 - MAKLUMAT KURSUS / <i>COURSE INFORMATION </i>                               </td>
		<td><a href="<?=Url::to(['/esiap/course/fk2', 'course' => $course->id, 'version' => $course_version])?>" target="_blank"  class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-download-alt"></span> Download</a></td>
	</tr>
	<tr>
		<td width="5%">3.</td>
		<td>FK03 - PENJAJARAN KONSTRUKTIF / <i>CONSTRUCTIVE ALIGNMENT       </i>                         </td>
		<td><a href="<?=Url::to(['/esiap/course/fk3', 'course' => $course->id, 'version' => $course_version])?>" target="_blank" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-download-alt"></span> Download</a></td>
	</tr>
	
	<tr>
		<td width="5%">4.</td>
		<td>TABLE 4 - SUMMARY OF COURSE INFORMATION                               </td>
		<td>

		<a href="<?=Url::to(['/esiap/course/tbl4-pdf', 'course' => $course->id, 'version' => $course_version])?>" target="_blank"  class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-download-alt"></span> TABLE 4 v2.0</a></td>
	</tr>
	
</tbody>
				
				<?php
                   }
                                echo'</td>
                                </tr>
                                </table>';
                       
                  Modal::end();


?></td>
<td><a href="<?=Url::to(['/esiap/course/view-course', 'course' => $course->id])?>" class="btn btn-default btn-sm" ><span class="fa fa-pencil"></span> Update</a></td>
<td><?=$offer->progressCourseVersionBar?></td>
</tr>

<tr>
<td>2. </td>
<td><b>Teaching Material Group</b></td>
<td><?php echo $form->field($offer, 'material_version')->dropDownList(ArrayHelper::map($offer->course->materialSubmit, 'id', 'material_name'),['prompt' => 'Please Select', 'class' => 'form-control course-matrial-update'])->label(false);

if(!$offer->course->materialSubmit){
	echo '<i>* Please make sure the material group is submitted first. Please click the Update button.</i>';
}

 ?></td>
<td><?php 
$material = $offer->material;
$count_material = 0;
if($material){
	if($material->items){
	$count_material = count($material->items);
}
}

$this->registerJs(' 

$("#courseoffered-course_version").change(function(){
    var course = $(this).val();
    if(course == -1){
        window.location.href = "'. Url::to(["coordinator/manage-version", 'course' => $course->id]) .'";
    }else{
        $("#course-material-form").submit();
    }
    
});


$(".course-matrial-update").change(function(){
    $("#course-material-form").submit();
});


 ');



 Modal::begin([
                      'header' => '<h5>Teaching Materials</h5>',
					  'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>',
                      'toggleButton' => ['label' => 'View Files ('.$count_material.')', 'class'=>'btn btn-sm btn-default'],
                  ]);
                      echo '<table class="table table-striped">
					  <thead>
                                <tr>
                                <th>#</th>
                                <th>File Name</th>
                                <th>Action</th>
                                </tr>
							</thead>
								';
					if($material){
						if($material->items)
                      {
                        $i=1;
                        foreach ($material->items as $file) {

                          
                          echo'<tr>
                          <td>'.$i.'.</td>
                          <td>';
                          echo $file->item_name;
                          echo'</td>
                                <td>';
                            
                                echo'<a href="'.Url::to( ['/course-files/material/download-file', 'attr' => 'item','id'=> $file->id]).'" target="_blank" class="btn btn-danger btn-sm"><span class="fa fa-download"></span> Download</a>';
                                $i++;
                        }
                      }
					}		
					
	
                   
                                echo'</td>
                                </tr>
                                </table>';
                       
                  Modal::end();


?></td>
<td><a href="<?=Url::to(['material/index', 'course' => $course->id])?>" class="btn btn-default btn-sm" ><span class="fa fa-pencil"></span> Update</a></td>
<td><?=$offer->progressMaterialBar?></td>
</tr>



</table>

    
	

	
	
	

    <?php ActiveForm::end(); ?>


</div>
</div>

<h4>Assessment Materials & Rubrics</h4>
<div class="box">

<div class="box-body">

  <table class="table">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
        <th >Item</th>
        <th style="width:10%">View</th>
        <th style="width:10%">Action</th>
		<th style="width:10%">Progress</th>
      </tr>
	  
	  </thead>
    
      <?php 
    
        if($model->assessMaterials){
        $i = 1;
          
            // foreach($model->assessMaterials as $item){
            $item = $model->assessMaterials;
 echo '<tr><td>1. </td>
                  <td>'.$item[1]->item_bi.'</td>

                  <td>';
				  if($offer->na_cont_material == 1){
					 echo 'N/A';
				  }else{
                  Modal::begin([
                      'header' => '<h5>'.$item[1]->item_bi.'</h5>',
					  'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>',
                      'toggleButton' => ['label' => 'View Files ('.$offer->countAssessmentMaterialFiles.')', 'class'=>'btn btn-sm btn-default'],
                  ]);
                      
                      echo '<table class="table">
                                <tr>
                                <th>#</th>
                                <th>File Name</th>
                                <th>Action</th>
                                </tr>';
                      if($offer->coordinatorAssessmentMaterialFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorAssessmentMaterialFiles as $files) {

                          
                          echo'<tr>
                          <td>'.$i.'.</td>
                          <td>';
                          echo $files->file_name;
                          echo'</td>
                                <td>';

                                echo'<a href="'.Url::to(['coordinator-assessment-material-file/download-file', 'attr' => 'path','id'=> $files->id]).'" target="_blank" class="btn btn-danger btn-sm"><span class="fa fa-download"></span> Download</a>';

                                $i++;
                        }
                      }
                                echo'</td>
                                </tr>
                                </table>';
                  Modal::end();
			}
            echo'</td>';

                  echo'<td><a href="' . Url::to([$item[1]->upload_url.'/page','id' => $offered_id]) . '" class="btn btn-default btn-sm" ><span class="fa fa-upload"></span> Upload</a></td>
				  <td>'.$offer->progressContMaterialBar .'</td>
				  </tr>
				  ';
                echo '<tr><td>2. </td>
                  <td>'.$item[0]->item_bi.'</td>

                  <td>';
				  if($offer->na_cont_rubrics == 1){
					 echo 'N/A';
				  }else{
                  Modal::begin([
                      'header' => '<h5>'.$item[0]->item_bi.'</h5>',
					  'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>',
                      'toggleButton' => ['label' => 'View Files ('.$offer->countRubricFiles.')', 'class'=>'btn btn-sm btn-default'],
                  ]);
                      echo '<table class="table">
                                <tr>
                                <th>#</th>
                                <th>File Name</th>
                                <th>Action</th>
                                </tr>';
                      if($offer->coordinatorRubricsFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorRubricsFiles as $files) {

                          
                          echo'<tr>
                          <td>'.$i.'.</td>
                          <td>';
                          echo $files->file_name;
                          echo'</td>
                                <td>';
                            
                                echo'<a href="'.Url::to(['coordinator-rubrics-file/download-file', 'attr' => 'path','id'=> $files->id]).'" target="_blank" class="btn btn-danger btn-sm"><span class="fa fa-download"></span>  Download</a>';
                                $i++;
                        }
                      }
                                echo'</td>
                                </tr>
                                </table>';
                       
                  Modal::end();
			}
            echo'</td>';

                  echo'<td><a href="' . Url::to([$item[0]->upload_url.'/page','id' => $offered_id]) . '" class="btn btn-default btn-sm" ><span class="fa fa-upload"></span> Upload</a></td>
				  <td>'.$offer->progressContRubricsBar .'</td>
				  </tr>
				  ';

                 

                  echo '<tr><td>3. </td>
                  <td>'.$item[2]->item_bi.'</td>

                  <td>';
				  if($offer->na_sum_assess == 1){
					 echo 'N/A';
				  }else{
                  Modal::begin([
                      'header' => '<h5>'.$item[2]->item_bi.'</h5>',
					  'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>',
                      'toggleButton' => ['label' => 'View Files ('.$offer->countSummativeAssessmentFiles.')', 'class'=>'btn btn-sm btn-default'],
                  ]);
                      
                      echo '<table class="table">
                                <tr>
                                <th>#</th>
                                <th>File Name</th>
                                <th>Action</th>
                                </tr>';
                      if($offer->coordinatorSummativeAssessmentFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorSummativeAssessmentFiles as $files) {

                          
                          echo'<tr>
                          <td>'.$i.'.</td>
                          <td>';
                          echo $files->file_name;
                          echo'</td>
                                <td>';
                                
                                echo'<a href="'.Url::to(['coordinator-summative-assessment-file/download-file', 'attr' => 'path','id'=> $files->id]).'" target="_blank" class="btn btn-danger btn-sm"><span class="fa fa-download"></span>  Download</a>';

                                $i++;
                        }
                      }
                                echo'</td>
                                </tr>
                                </table>';
                       
                  Modal::end();
				  }
            echo'</td>';

                  echo'<td><a href="' . Url::to([$item[2]->upload_url.'/page','id' => $offered_id]) . '" class="btn btn-default btn-sm" ><span class="fa fa-upload"></span> Upload</a></td>
				  <td>'.$offer->progressSumAssessBar .'</td>
				  
				  ';
         
                  $i++;

          
        }
              ?>
   
   
  </table>
</div>
</div>




<h4>Students' Assessment Scripts</h4>
<div class="box">

<div class="box-body">

  <table class="table">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
        <th>Item</th>
        <th style="width:10%">View</th>
        <th style="width:10%">Action</th>
		<th style="width:10%">Progress</th>
      </tr>
	  </thead>
	  
	  <?php 

         $i = 1;
          
            $item = $model->assessScripts;
              if($item[0]->coor_upload == 1){
                
            echo '<tr><td>1. </td>
                  <td>'.$item[0]->item_bi.'</td>

                  <td>';
				  if($offer->na_cont_script == 1){
					 echo 'N/A';
				  }else{
                  Modal::begin([
                      'header' => '<h5>'.$item[0]->item_bi.'</h5>',
					  'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>',
                      'toggleButton' => ['label' => 'View Files ('.$offer->countAssessmentScriptFiles.')', 'class'=>'btn btn-sm btn-default'],
                  ]);
                      echo '<table class="table">
                                <tr>
                                <th>#</th>
                                <th>File Name</th>
                                <th>Action</th>
                                </tr>';
                      if($offer->coordinatorAssessmentScriptFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorAssessmentScriptFiles as $files) {

                          
                          echo'<tr>
                          <td>'.$i.'.</td>
                          <td>';
                          echo $files->file_name;
                          echo'</td>
                                <td>';
                            
                                echo'<a href="'.Url::to(['coordinator-assessment-script-file/download-file', 'attr' => 'path','id'=> $files->id]).'" target="_blank" class="btn btn-danger btn-sm"><span class="fa fa-download"></span>  Download</a>';
                                $i++;
                        }
                      }
                                echo'</td>
                                </tr>
                                </table>';
                       
                  Modal::end();
			  }
            echo'</td>';

                  echo'<td><a href="' . Url::to([$item[0]->upload_url.'/page','id' => $offered_id]) . '" class="btn btn-default btn-sm" ><span class="fa fa-upload"></span> Upload</a></td>
				   <td>'.$offer->progressContScriptBar .'</td>
				   
				   </tr>
				  
				  ';

                  echo '<tr><td>2. </td>
                  <td>'.$item[1]->item_bi.'</td>

                  <td>';
				  if($offer->na_script_final == 1){
					 echo 'N/A';
				  }else{
					   Modal::begin([
                      'header' => '<h5>'.$item[1]->item_bi.'</h5>',
					  'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>',
                      'toggleButton' => ['label' => 'View Files ('.$offer->countScripts.')', 'class'=>'btn btn-sm btn-default'],
                  ]);
                      echo '<table class="table">
                                <tr>
                                <th>#</th>
                                <th>File Name</th>
                                <th>Action</th>
                                </tr>';
					echo rowFile($offer, 'best');
					echo rowFile($offer, 'mod');
					echo rowFile($offer, 'low');
                     
                                echo'
                                </table>';
                       
                  Modal::end();
				  }
                 
            echo'</td>';

                  echo'<td><a href="' . Url::to([$item[1]->upload_url.'/page','id' => $offered_id]) . '" class="btn btn-default btn-sm" ><span class="fa fa-upload"></span> Upload</a></td>
				  <td>'.$offer->progressSumScriptBar .'</td>
				  </tr>
				  
				  ';
         
                  $i++;
              }        
    ?>


    
      
   
   
  </table>
</div>
</div>


<h4>Students' Final Result Assessment </h4>
<div class="box">

<div class="box-body">

  <table class="table">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
        <th>Item</th>
        <th style="width:10%">View</th>
        <th style="width:10%">Action</th>
		<th style="width:10%">Progress</th>
      </tr>
	  </thead>
	  
	  <?php 

         $i = 1;
          
            $item = $model->assessResults;
              if($item[0]->coor_upload == 1){
                
            echo '<tr><td>'.$i.'. </td>
                  <td>'.$item[0]->item_bi.'</td>

                  <td>';
				  if($offer->na_result_final == 1){
					 echo 'N/A';
				  }else{
                  Modal::begin([
                      'header' => '<h5>'.$item[0]->item_bi.'</h5>',
					  'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>',
                      'toggleButton' => ['label' => 'View Files ('.$offer->countResultFinalFiles.')', 'class'=>'btn btn-sm btn-default'],
                  ]);
                      echo '<table class="table">
                                <tr>
                                <th>#</th>
                                <th>File Name</th>
                                <th>Action</th>
                                </tr>';
                      if($offer->coordinatorResultFinalFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorResultFinalFiles as $files) {

                          
                          echo'<tr>
                          <td>'.$i.'.</td>
                          <td>';
                          echo $files->file_name;
                          echo'</td>
                                <td>';
                            
                                echo'<a href="'.Url::to(['coordinator-result-final-file/download-file', 'attr' => 'path','id'=> $files->id]).'" target="_blank" class="btn btn-danger btn-sm"><span class="fa fa-download"></span> Download</a>';
                                $i++;
                        }
                      }
                                echo'</td>
                                </tr>
                                </table>';
                       
                  Modal::end();
			  }
            echo'</td>';

                  echo'<td><a href="' . Url::to([$item[0]->upload_url.'/page','id' => $offered_id]) . '" class="btn btn-default btn-sm" ><span class="fa fa-upload"></span> Upload</a></td>
				  <td>'.$offer->progressResultFinalBar .'</td>
				  
				  ';

                 
         
                  $i++;
              }        
    ?>


    
      
   
   
  </table>
</div>
</div>

<h4>Continuous Quality Improvement (CQI)</h4>
<div class="box">


<div class="box-body">

  <table class="table">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
        <th>Item</th>
        <th style="width:10%">View</th>
		<th style="width:10%">Action</th>
		<th style="width:10%">Progress</th>
      </tr>
    
        
        <tr>
        <?php 
                echo '<td>1. </td>
                  <td>Plan for Course Improvement (if any)</td>
				  <td>';
				  if($offer->na_cqi == 1){
					 echo 'N/A';
				  }else{
					 Modal::begin([
                      'header' => '<h5>Continuous Quality Improvement</h5>',
					  'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>',
                      'toggleButton' => ['label' => 'View', 'class'=>'btn btn-sm btn-default'],
                  ]); 
				  echo $offer->course_cqi;
				  
				  Modal::end();
				  }
				   
                     
                       
                  
				  
				  echo '</td>
                  <td><a href="' . Url::to(['coordinator/course-cqi','id' => $offered_id]) . '" class="btn btn-default btn-sm" ><span class="glyphicon glyphicon-pencil"></span> Update</a></td>
				  <td>'.$offer->progressCqiBar .'</td>
				  ';
         
              ?>
      </tr>
    </thead>
   
  </table>
</div>
</div>




<?php 


		}
		
		
function rowFile($offer, $type){
	$name ='';
	$i = 1;
	switch($type){
		case 'best':
		$name = 'BEST';
		$i = 0;
		break;
		case 'mod':
		$name = 'MEDIUM';
		$i = 3;
		break;
		case 'low':
		$name = 'LOWEST';
		$i = 6;
		break;
	}
	$html = '';
	for($s=1;$s<=3;$s++){
		$sc = 'script'.$type. $s;
		$col = $sc . '_file';
		
			$x = $i + $s;
			$html .= '<tr><td>'.$x.'. </td><td>'.$name.' ANSWER SCRIPT '.$s.'</td><td>';
			
			if($offer->$col){
				$html .= '<a href="' . Url::to(['/course-files/coordinator-upload/download-file', 'attr' => $sc, 'id' => $offer->id]) . '" target="_blank" class="btn btn-danger btn-sm">
			
			<span class="glyphicon glyphicon-download-alt" ></span>  Download</a>';
			}
			
			
			
			$html .= '</td></tr>';
			$x++;
	
		
	}
	return $html;
}
?>