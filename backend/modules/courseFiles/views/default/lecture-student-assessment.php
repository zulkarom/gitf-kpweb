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

$course = $offer->course;
$listClo = $offer->listClo();
/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Lecture ['.$lecture->lec_name.']';
$this->params['breadcrumbs'][] = ['label' => 'Teaching Assignment', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['teaching-assignment-lecture', 'id' => $lecture->id]];
$this->params['breadcrumbs'][] = 'Student Assessment';
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
<br />
 <div class="form-group"> 
<a href=<?=Url::to(['default/export-excel', 'id' => $lecture->id])?> class="btn btn-success btn-sm" target="_blank"><span class="glyphicon glyphicon-download-alt"></span> DOWNLOAD TEMPLATE</a> 

<input type="file" id="xlf" style="display:none;" />
<button type="button" id="btn-importexcel" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-import"></span> IMPORT MARKS </button>

<a href=<?=Url::to(['default/clo-analysis-pdf', 'id' => $lecture->id])?> class="btn btn-danger btn-sm" target="_blank"><span class="glyphicon glyphicon-download-alt"></span> DOWNLOAD ANALYSIS</a> 



</div>



</div>

</div>



<div class="box">
        <div class="box-header">
      
            <div class="box-title"><b>Student Assessment</b></div>
     
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
							$header_clo .= '<td><span class="label label-primary">CLO'.$clo.'</span></td>';
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
                        echo'<td><span class="label label-primary">CLO'.$assess->cloNumber.'</span>
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
					 if($assessment)
                    {
                      
                      foreach ($assessment as $assess) {
                        echo'<td align="center">'.$assess->assess_name_bi.'
                        </td>';

                      }
                   
                    }
					echo $header_clo;
                  ?>
				  
				  
				  
				  
				  
				  
                  </tr>
                </thead>
                <tr>
                  <?php
                    $i=1;
                    if($lecture->students){

                      foreach ($lecture->students as $student) {
                        
                        

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
                             echo'<td align="center">'.$value.'</td>';

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
		  


         <!-- Group by Clo -->
        
 *Purata markah (jumlah markah/ bil. pelajar) dibahagikan dengan pemberat setiap HPK didarab dengan 4.0/ Average mark (total marks/no. of students) divided by weightage of each CLO multiplied by 4.0.<br />
 **0.00-0.99 (Sangat Lemah/ Very Poor), 1.00-1.99 (Lemah/ Poor), 2.00-2.99 (Baik/ Good), 3.00-3.69 (Sangat Baik/ Very Good), 3.70-4.00 (Cemerlang/ Excellent). 

      
<?php $form = ActiveForm::begin(['id' => 'form-assessment']); ?>
  <input type="hidden" id="json_assessment" name="json_assessment">
  <?php ActiveForm::end(); ?> 


<?php 
 
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


JSRegister::begin(); ?>
<script>
var save = <?=$save?>;

if(save == 1){
	//alert(achived);
	saveClos();
}

function saveClos(){
	var achived = '<?=json_encode($arr_achieve)?>';
	$.ajax({url: "<?=Url::to(['/course-files/default/save-clos', 'id' => $lecture->id])?>", 
	timeout: 2000,     // timeout milliseconds
	type: 'POST',  // http method
	data: { 
		achived: achived,
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
            $("#form-assessment").submit();
            break;
          }
          
      };
      reader.readAsArrayBuffer(f);
	
    
  }

  if(xlf.addEventListener){
  
  xlf.addEventListener('change', handleFile, false);

  }

  
</script>
<?php JSRegister::end(); ?>





