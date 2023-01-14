<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\grid\GridView;
use backend\assets\ExcelAsset;
use kartik\export\ExportMenu;
use richardfan\widget\JSRegister;

ExcelAsset::register($this); 


$offer = $lecture->courseOffered;
$assessment = $offer->assessment;

if($offer->course_version2 > 0){
	$assessment2 = $offer->assessment2;
}


$course = $offer->course;
$listClo = $offer->listClo();
$listClo2 = $offer->listClo2();
/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Lecture ['.$lecture->lec_name.']';
$this->params['breadcrumbs'][] = ['label' => 'My Course File', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['teaching-assignment-lecture', 'id' => $lecture->id]];
$this->params['breadcrumbs'][] = 'Student Assessment';

if($lecture->students){
?>


<style>
.label{
	font-size:12px;
}
</style>

<div class="row">

<div class="col-md-4">
<h4><?=$course->course_code . ' ' . $course->course_name?></h4>
<h4><?=$offer->semester->longFormat()?></h4>

</div>

<div class="col-md-8" align="right">

<?php 
if($assessment){
?>
<br />
 <div class="form-group"> 
<a href=<?=Url::to(['default/export-excel', 'id' => $lecture->id])?> class="btn btn-success btn-sm" target="_blank"><span class="glyphicon glyphicon-download-alt"></span> DOWNLOAD TEMPLATE</a> 

<input type="file" id="xlf" style="display:none;" />
<button type="button" id="btn-importexcel" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-import"></span> IMPORT MARKS </button>

<?php 
if($offer->course_version2 > 0 && $lecture->studentGroup2 ){
	?>
	<a href=<?=Url::to(['default/clo-analysis-pdf', 'id' => $lecture->id, 'group' => 1])?> class="btn btn-danger btn-sm" target="_blank"><span class="glyphicon glyphicon-download-alt"></span> ANALYSIS 1</a>  <a href=<?=Url::to(['default/clo-analysis-pdf', 'id' => $lecture->id, 'group' => 2])?> class="btn btn-danger btn-sm" target="_blank"><span class="glyphicon glyphicon-download-alt"></span> ANALYSIS 2</a> 
	<?php
}else{
	?>
	<a href=<?=Url::to(['default/clo-analysis-pdf', 'id' => $lecture->id])?> class="btn btn-danger btn-sm" target="_blank"><span class="glyphicon glyphicon-download-alt"></span> DOWNLOAD ANALYSIS</a> 
	<?php
}

?>



</div>

<?php 




}else{
	echo '<p style="color:red">In order to make this page function properly, <br />the coordinator needs to set the course version for this semester.</p>';
}

?>



</div>

</div>

<?php  

if(!$lecture->clo_achieve){
    ?>
    <br />
   <div class="form-group">   
   
   <strong>STEPS TO UPLOAD STUDENT RESULT : </strong>
   
   <ol>
   		<li>Download excel template</li>
   		<li>Fill in the mark in the excel
   			<ul> 
   				<li>The assessment column should not be changed</li>
   				<li>The different sorting of the students is allowed</li>
   				<li>You are allowed to change the total mark in the template header to suit your data. The system will convert the mark to the weighted value</li>
   			</ul>
   		
   		</li>
   		
   		<li>Clik Import button to import the mark from the excel</li>
   		<li>Make sure all students have the mark. If there are extra students, kindly make adjustment on student list page</li>
   </ol>
   
   
   
    </div>
    <?php 
}
$group1 = '';
if($offer->course_version2 > 0 && $lecture->studentGroup2 ){
	$group1 = '(Group 1)';
}
?>

<div class="box">
        <div class="box-header">

            <div class="box-title"><b>Student Assessment <?=$group1?></b></div>
     
        </div>
          <div class="box-body">
            <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
          
                    <?php
					
					$empty_clo = '';
					$header_clo = '';
					if($listClo){
                          foreach ($listClo as $clo) {
                            $empty_clo .= '<td></td>';
							$header_clo .= '<td align="center"><span class="label label-primary">CLO'.$clo.'</span></td>';
							$strtotal = 'clo'.$clo.'_total';
							$strcount = 'clo'.$clo.'_count';
							$$strtotal = 0;
							$$strcount = 0;
                          }
                    }
					
					 echo'</tr> 
                    <tr align="center">
                   
                    <td colspan="3" align="right">Course Learning Outcome</td>';
					$cloSet = array();
					$count_assess = count($assessment);
					foreach ($assessment as $assess) {
                        $cloSet[] = $assess->cloNumber;
                        echo'<td align="center" style="text-align:center"><span class="label label-primary">CLO'.$assess->cloNumber.'</span>
                        </td>';
						

                      }
                   echo $empty_clo;
                    
                    echo'</tr> 
					
                    <tr align="center">
                    <td colspan="3" align="right"><b>Weightage</b></td>';
					$weightage = array();
					   foreach ($assessment as $assess) {
                        echo'<td>'.$assess->assessmentPercentage.'%
                        </td>';
						$weightage[] = $assess->assessmentPercentage;
                      }
					  echo $empty_clo;
                    echo'</tr> ';

                  /*  echo ' <tr align="center">
                    <td colspan="3" align="right"><b>Total Mark</b></td>'; 
                      foreach ($assessment as $assess) {
                        echo'<td>'.$assess->assessmentPercentage.'
                        </td>';

                      }
					  echo $empty_clo;
                  echo'</tr>',  */

                  echo '<tr >
                    <td><b>No.</b></td>
                    <td><b>Matric No.</b></td>
                    <td><b>Name</b></td>';
                      foreach ($assessment as $assess) {
                        echo'<td align="center">'.$assess->assess_name_bi.'
                        </td>';

                      }
					echo $header_clo;
                  ?>
				  
				  
				  
				  
				  
				  
                  </tr>
                </thead>
                <tr>
                  <?php
                    $i=1;
                    $student1 = $offer->course_version2 > 0 ? $lecture->studentGroup1 : $lecture->students;

                      foreach ($student1 as $student) {
                        
                        

                        echo'<tr><td>'.$i.'</td>
                          <td>'.$student->matric_no.'</td>
                          <td>'.$student->student->st_name.'</td>';
						  
                          
                          $result = json_decode($student->assess_result);

                           if($assessment)
                            {
                              $x = 0;
                              foreach ($assessment as $assess) {
                                
                                if($result){
                                  if(array_key_exists($x, $result)){
                                    $mark = $result[$x];
                                    echo'<td align="center">'.$mark.'</td>';
                                  }
                                  else{
                                    echo'<td></td>';
                                  }
                                  
                                }
                                else{
                                   echo'<td></td>';
                                }
                               
                                $x++;
                              }
                            }
							

                          if($listClo){
                            foreach ($listClo as $clo) {
                              $value = cloValue($clo,$result,$cloSet);
							  $show_value = $value == 0 ? '':$value;
                             echo'<td align="center">'.$show_value.'</td>';

                              $strtotal = 'clo'.$clo.'_total';
                              $strcount = 'clo'.$clo.'_count';
                              
                              if(!empty($value)){
                                $$strcount++;
                              }
                              
                              $$strtotal += $value;


                            }
                          }

                        
                        echo'</tr>';
                        $i++;
                      }

                    

				$colspan = 3 + $count_assess;
                ?>
				
				
                <tr><td colspan="<?=$colspan?>" align="right"><b>AVERAGE</b></td>
                  <?php
				  $weightage_html = '';
				  $percent = '';
				  $achievement = '';
				  $html_analysis = '';
				  $arr_achieve = [];
				  $arr_achieve2 = [];
                    if($listClo){
                      foreach ($listClo as $clo) {
                        $strtotal = 'clo'.$clo.'_total';
                        $strcount = 'clo'.$clo.'_count';
						$average = 0;
                        if($$strcount > 0){
                           $average = $$strtotal/$$strcount;
                            echo'<td align="center">'.number_format($average,2).'</td>';
                        }else{
                            echo'<td></td>';
                        }
						
						$value = cloValue($clo,$weightage,$cloSet);
                        $weightage_html .= '<td align="center" style="border-bottom:1px #000000 solid">'.$value.'</td>';
						if($value == 0){
							$percentage = 0;
						}else{
							$percentage = $average / $value;
						}
						
						$percent .= '<td align="center">'.number_format($percentage,2).'</td>';
						$achieve = $percentage * 4;
						$arr_achieve[] = number_format($achieve,2);
						$achievement .= '<td align="center"><span class="label label-primary" >'.number_format($achieve,2).'</span></td>';
						$analysis = analysis($achieve);
						$html_analysis .= '<td align="center">'.$analysis.'</td>';
                       
                      }
                    }
                  ?>
                </tr>
				<tr><td colspan="<?=$colspan?>"  align="right"><b>CLO WEIGHTAGE</b></td>
                  <?php
				  echo $weightage_html;
                  ?>
                </tr>
				<tr><td colspan="<?=$colspan?>"  align="right"><b></b></td>
                  <?php
				  echo $percent;
                  ?>
                </tr>
				
				<tr><td colspan="<?=$colspan?>"  align="right"><b>STUDENT ACHIEVEMENT(0-4) *</b></td>
                  <?php
				  echo $achievement;
                  ?>
                </tr>
				
				<tr><td colspan="<?=$colspan?>"  align="right"><b>ACHIEVEMENT ANALYSIS **</b></td>
                  <?php
				  echo $html_analysis;
                  ?>
                </tr>
				
            </table>

            </div>

          </div> </div>

<?php 
if($offer->course_version2 > 0 && $lecture->studentGroup2 ){
?>

<div class="box">
        <div class="box-header">

            <div class="box-title"><b>Student Assessment (Group 2)</b></div>
     
        </div>
          <div class="box-body">
            <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
          
                    <?php
					
					$empty_clo = '';
					$header_clo = '';
					if($listClo2){
                          foreach ($listClo2 as $clo) {
                            $empty_clo .= '<td></td>';
							$header_clo .= '<td align="center"><span class="label label-primary">CLO'.$clo.'</span></td>';
							$strtotal = 'clo'.$clo.'_total';
							$strcount = 'clo'.$clo.'_count';
							$$strtotal = 0;
							$$strcount = 0;
                          }
                    }
					
					 echo'</tr> 
                    <tr align="center">
                   
                    <td colspan="3" align="right">Course Learning Outcome</td>';
					$cloSet = array();
					$count_assess = count($assessment2);
					foreach ($assessment2 as $assess) {
                        $cloSet[] = $assess->cloNumber;
                        echo'<td align="center" style="text-align:center"><span class="label label-primary">CLO'.$assess->cloNumber.'</span>
                        </td>';
						

                      }
                   echo $empty_clo;
                    
                    echo'</tr> 
					
                    <tr align="center">
                    <td colspan="3" align="right"><b>Weightage</b></td>';
					$weightage = array();
					   foreach ($assessment2 as $assess) {
                        echo'<td>'.$assess->assessmentPercentage.'%
                        </td>';
						$weightage[] = $assess->assessmentPercentage;
                      }
					  echo $empty_clo;
                    echo'</tr> ';

                  /*  echo ' <tr align="center">
                    <td colspan="3" align="right"><b>Total Mark</b></td>'; 
                      foreach ($assessment as $assess) {
                        echo'<td>'.$assess->assessmentPercentage.'
                        </td>';

                      }
					  echo $empty_clo;
                  echo'</tr>',  */

                  echo '<tr >
                    <td><b>No.</b></td>
                    <td><b>Matric No.</b></td>
                    <td><b>Name</b></td>';
                      foreach ($assessment2 as $assess) {
                        echo'<td align="center">'.$assess->assess_name_bi.'
                        </td>';

                      }
					echo $header_clo;
                  ?>
				  
				  
				  
				  
				  
				  
                  </tr>
                </thead>
                <tr>
                  <?php
                    $i=1;
                    

                      foreach ($lecture->studentGroup2 as $student) {
                        
                        

                        echo'<tr><td>'.$i.'</td>
                          <td>'.$student->matric_no.'</td>
                          <td>'.$student->student->st_name.'</td>';
						  

                          $result = json_decode($student->assess_result);

                           if($assessment2)
                            {
                              $x = 0;
                              foreach ($assessment2 as $assess) {
                                
                                if($result){
                                  if(array_key_exists($x, $result)){
                                    $mark = $result[$x];
                                    echo'<td align="center">'.$mark.'</td>';
                                  }
                                  else{
                                    echo'<td></td>';
                                  }
                                  
                                }
                                else{
                                   echo'<td></td>';
                                }
                               
                                $x++;
                              }
                            }
							

                          if($listClo2){
                            foreach ($listClo2 as $clo) {
                              $value = cloValue($clo,$result,$cloSet);
							  $show_value = $value == 0 ? '':$value;
                             echo'<td align="center">'.$show_value.'</td>';

                              $strtotal = 'clo'.$clo.'_total';
                              $strcount = 'clo'.$clo.'_count';
                              
                              if(!empty($value)){
                                $$strcount++;
                              }
                              
                              $$strtotal += $value;


                            }
                          }

                        
                        echo'</tr>';
                        $i++;
                      }

                    

				$colspan = 3 + $count_assess;
                ?>
				
				
                <tr><td colspan="<?=$colspan?>" align="right"><b>AVERAGE</b></td>
                  <?php
				  $weightage_html = '';
				  $percent = '';
				  $achievement = '';
				  $html_analysis = '';
				  
                    if($listClo2){
                      foreach ($listClo2 as $clo) {
                        $strtotal = 'clo'.$clo.'_total';
                        $strcount = 'clo'.$clo.'_count';
						$average = 0;
                        if($$strcount > 0){
                           $average = $$strtotal/$$strcount;
                            echo'<td align="center">'.number_format($average,2).'</td>';
                        }else{
                            echo'<td></td>';
                        }
						
						$value = cloValue($clo,$weightage,$cloSet);
                        $weightage_html .= '<td align="center" style="border-bottom:1px #000000 solid">'.$value.'</td>';
						if($value == 0){
							$percentage = 0;
						}else{
							$percentage = $average / $value;
						}
						
						$percent .= '<td align="center">'.number_format($percentage,2).'</td>';
						$achieve = $percentage * 4;
						$arr_achieve2[] = number_format($achieve,2);
						$achievement .= '<td align="center"><span class="label label-primary" >'.number_format($achieve,2).'</span></td>';
						$analysis = analysis($achieve);
						$html_analysis .= '<td align="center">'.$analysis.'</td>';
                       
                      }
                    }
                  ?>
                </tr>
				<tr><td colspan="<?=$colspan?>"  align="right"><b>CLO WEIGHTAGE</b></td>
                  <?php
				  echo $weightage_html;
                  ?>
                </tr>
				<tr><td colspan="<?=$colspan?>"  align="right"><b></b></td>
                  <?php
				  echo $percent;
                  ?>
                </tr>
				
				<tr><td colspan="<?=$colspan?>"  align="right"><b>STUDENT ACHIEVEMENT(0-4) *</b></td>
                  <?php
				  echo $achievement;
                  ?>
                </tr>
				
				<tr><td colspan="<?=$colspan?>"  align="right"><b>ACHIEVEMENT ANALYSIS **</b></td>
                  <?php
				  echo $html_analysis;
                  ?>
                </tr>
				
            </table>

            </div>

          </div> </div>

<?php	
}

?>
		  


         <!-- Group by Clo -->
        
 *Purata markah (jumlah markah/ bil. pelajar) dibahagikan dengan pemberat setiap HPK didarab dengan 4.0/ Average mark (total marks/no. of students) divided by weightage of each CLO multiplied by 4.0.<br />
 **0.00-0.99 (Sangat Lemah/ Very Poor), 1.00-1.99 (Lemah/ Poor), 2.00-2.99 (Baik/ Good), 3.00-3.69 (Sangat Baik/ Very Good), 3.70-4.00 (Cemerlang/ Excellent). 
 
 
 <div class="modal" id="loadingModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-body" align="center">
        <h3>LOADING DATA...</h3>
      </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


      
<?php $form = ActiveForm::begin(['id' => 'form-assessment']); ?>
  <input type="hidden" id="json_assessment" name="json_assessment">
  <?php ActiveForm::end(); ?> 


<?php 
JSRegister::begin(); ?>
<script>
var save = <?=$save?>;

if(save == 1){
	//alert(achived);
	saveClos();
}

function saveClos(){
	var achived = '<?=json_encode($arr_achieve)?>';
	var achived2 = '<?=json_encode($arr_achieve2)?>';
	$.ajax({url: "<?=Url::to(['/course-files/default/save-clos', 'id' => $lecture->id])?>", 
	timeout: 2000,     // timeout milliseconds
	type: 'POST',  // http method
	data: { 
		achived: achived,
		achived2: achived2,
	},
	success: function(result){
		//alert(result);
		//$("#result-submit").html(result);
	},
	error: function (jqXhr, textStatus, errorMessage) { // error callback 
		alert('There is problem saving the clo achievement! Error Message : ' + errorMessage);
		//$('#result-submit').append('Error: ' + errorMessage);
	}
  });
}


$("#btn-importexcel").click(function(){
	document.getElementById("xlf").click();     
});


var X = XLSX;
  
  function fixdata(data) {
    var o = "", l = 0, w = 10240;
    for(; l<data.byteLength/w; ++l) o+=String.fromCharCode.apply(null,new Uint8Array(data.slice(l*w,l*w+w)));
    o+=String.fromCharCode.apply(null, new Uint8Array(data.slice(l*w)));
    return o;
  }
  
  function to_jsObject(workbook) {
    var result = {};
    workbook.SheetNames.forEach(function(sheetName) {
      var roa = X.utils.sheet_to_json(workbook.Sheets[sheetName], {header:1});
      if(roa.length) result[sheetName] = roa;
    });
    return result;

  }

  var xlf = document.getElementById('xlf');
  
  function handleFile(e) {
	var str;
	var row;
    var files = e.target.files;
    var f = files[0];
  
      var reader = new FileReader();
      reader.onload = function(e) {
        var data = e.target.result;
        var wb;
        var arr = fixdata(data);
          wb = X.read(btoa(arr), {type: 'base64'});
          // console.log(to_jsObject(wb)); 
          var obj = to_jsObject(wb) ;
          for (var key in obj) {
            var sheet = obj[key];
			var i = 1;
      var myJSON = JSON.stringify(sheet);
      console.log(myJSON);

            $("#json_assessment").val(myJSON);
			$('#loadingModal').modal({
   backdrop: 'static',
   keyboard: false,
   show: true
});
            $("#form-assessment").submit();
            break;
          }
          
      };
      reader.readAsArrayBuffer(f);
	
    
  }

  if(xlf.addEventListener){
  
  xlf.addEventListener('change', handleFile, false);

  }


$('#testLoad').click(function(){

});



  
</script>
<?php JSRegister::end(); 


}else{
	echo '<h4>To properly view this page, kindly load <a href="'. Url::to(['default/lecture-student-list', 'id' => $lecture->id]) .'">student list</a> first.</h4>';
}


function cloValue($clo,$result,$cloSet)
{
  $i =0;
  $mark=0;
  if($cloSet && $result)
  {
    foreach($cloSet as $cs)
    {
      if($cs == $clo){
        if(array_key_exists($i, $result))
        {
          $mark += $result[$i];
        }
        
      }
      
      $i++;
    }
    
  }

  return $mark;
}

function analysis($point){
	if($point >= 3.7 and $point <= 4){
		return 'Cemerlang/ Excellent';
	}else if($point >= 3 and $point < 3.7){
		return 'Sangat Baik/ Very Good';
	}else if($point >= 2 and $point < 3){
		return 'Baik/ Good';
	}else if($point >= 1 and $point < 2){
		return 'Lemah/ Poor';
	}else if($point >= 0 and $point < 1){
		return 'Sangat Lemah/ Very Poor';
	}else{
		return '';
	}
}



?>





