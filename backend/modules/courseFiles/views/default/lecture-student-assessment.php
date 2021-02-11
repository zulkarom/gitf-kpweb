<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\grid\GridView;
use backend\assets\ExcelAsset;
use kartik\export\ExportMenu;


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

<h4><?=$course->course_code . ' ' . $course->course_name?></h4>
<h4><?=$offer->semester->longFormat()?></h4>


  <?php
  $columns = [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Student Id',
                'format' => 'html',
                'value' => function($model){
                    return $model->matric_no;
                }
            ],
          [
                'label' => 'Name',
                'format' => 'html',
                'value' => function($model){
                    return $model->student->st_name;
                }
            ],


        ];
?>

<div class="row">

<div class="col-md-8">



 <div class="form-group"> <input type="file" id="xlf" style="display:none;" />
<button type="button" id="btn-importexcel" class="btn btn-info"><span class="glyphicon glyphicon-import"></span> IMPORT EXCEL </button>

<a href=<?=Url::to(['default/export-excel', 'id' => $lecture->id])?> class="btn btn-success"><span class="glyphicon glyphicon-download-alt"></span> EXPORT EXCEL</a>

</div>

<?php $form = ActiveForm::begin(['id' => 'form-assessment']); ?>
  <input type="hidden" id="json_assessment" name="json_assessment">
  <?php ActiveForm::end(); ?> 

</div>

</div>

<br/>


<div class="box">
        <div class="box-header">
          <div class="a">
            <div class="box-title"><b>Student Assessment</b></div>
          </div>
        </div>
          <div class="box-body">
            <?php $form = ActiveForm::begin() ?>
            <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <td></td>
                    <td></td>
                    <td style="float: right;"><b>Assessment Name :</b></td>
                    <?php
                    if($assessment)
                    {
                      $cloSet = array();
                      foreach ($assessment as $assess) {
                        $cloSet[] = $assess->cloNumber;
                        echo'<td>'.$assess->assess_name_bi.'
                        </td>';

                      }
                    
                    echo'</tr> 
                    <tr>
                    <td></td>
                    <td></td>
                    <td style="float: right;"><b>CLO :</b></td>';
                    
                      foreach ($assessment as $assess) {
                        $cloSet[] = $assess->cloNumber;
                        echo'<td>CLO'.$assess->cloNumber.'
                        </td>';

                      }
                    
                    echo'</tr> 

                    <tr>
                    <td></td>
                    <td></td>
                    <td style="float: right;"><b>Weightage :</b></td>'; 
                      foreach ($assessment as $assess) {
                        $cloSet[] = $assess->cloNumber;
                        echo'<td>'.$assess->assessmentPercentage.'%
                        </td>';

                      }
                    
                  
                  echo'</tr> 

                  <tr>
                    <td><b>No.</b></td>
                    <td><b>Matric No.</b></td>
                    <td><b>Name <font style="float: right">Total :</font></font></td>';
                    foreach ($assessment as $assess) {
                        $cloSet[] = $assess->cloNumber;
                        echo'<td>'.$assess->assessmentPercentage.'
                        </td>';

                      }
                    }
                  ?>
                  </tr>
                </thead>
                <tr>
                  <?php
                    $i=1;
                    if($lecture->students){

                      foreach ($lecture->students as $student) {
                        $result = json_decode($student->assess_result);
                        
                        $array_matric = $student->matric_no;
                        $$array_matric = array();

                        if($listClo){
                          foreach ($listClo as $clo) {
                            $$array_matric[$clo] = cloValue($clo,$result,$cloSet);
                          }
                        }

                        echo'<tr><td>'.$i.'</td>
                          <td>'.$student->matric_no.'</td>
                          <td>'.$student->student->st_name.'</td>';
                          

                           if($assessment)
                            {
                              $x = 0;
                              foreach ($assessment as $assess) {
                                
                                if($result){
                                  if(array_key_exists($x, $result)){
                                    $mark = $result[$x];
                                    echo'<td>'.$mark.'</td>';
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

                        
                        echo'</tr>';
                        $i++;
                      }

                    }


                ?>
            </table>

            </div>
            <?php ActiveForm::end(); ?>
          </div>
        </div>

         <!-- Group by Clo -->
        <div class="box">
        <div class="box-header">
          <div class="a">
            <div class="box-title"><b>Student Assessment<br/>(Group by CLO)</b></div>
          </div>
        </div>
          <div class="box-body">
            <?php $form = ActiveForm::begin() ?>
            <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Matric No.</th>
                    <th>Name</th>
                    <?php
                        if($listClo){
                          foreach ($listClo as $clo) {
                            echo'<th>
                            (CLO'.$clo.')
                            </th>';
                          }
                        }
                    ?>
                  </tr>
                </thead>

                
                  <?php
                    $i=1;
                    if($listClo){
                      foreach ($listClo as $clo) {
                        $strtotal = 'clo'.$clo.'_total';
                        $strcount = 'clo'.$clo.'_count';
                        $$strtotal = 0;
                        $$strcount = 0;

                      }
                    }

                    if($lecture->students){

                      foreach ($lecture->students as $student) {
                        $result = json_decode($student->assess_result);
                        
                        $array_matric = $student->matric_no;
                        $$array_matric = array();

                       
                        echo'<tr><td>'.$i.'</td>
                          <td>'.$student->matric_no.'</td>
                          <td>'.$student->student->st_name.'</td>';
                          
                          if($listClo){
                            foreach ($listClo as $clo) {
                              $value = cloValue($clo,$result,$cloSet);

                              $$array_matric[$clo] = $value ;
                              echo'<td>'.$$array_matric[$clo].'</td>';

                              $strtotal = 'clo'.$clo.'_total';
                              $strcount = 'clo'.$clo.'_count';
                              
                              if(!empty($value)){
                                $$strcount++;
                              }
                              
                              $$strtotal += $value;


                            }
                            // $average = $$strtotal/$$strcount;

                          }
                       

                        
                        echo'</tr>';
                        $i++;
                      }

                    }


                ?>

                <tr><td><td></td><td><b>AVERAGE</b></td>
                  <?php
                    if($listClo){
                      foreach ($listClo as $clo) {
                        $strtotal = 'clo'.$clo.'_total';
                        $strcount = 'clo'.$clo.'_count';
                       
                        if($$strcount > 0){
                           $average = $$strtotal/$$strcount;
                            echo'<td>'.$average.'</td>';
                        }else{
                            echo'<td></td>';
                        }
                       
                      }
                    }
                  ?>
                </tr>
            </table>

            </div>
            <?php ActiveForm::end(); ?>
          </div>
        </div>

      



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

function cloAverage(){
  
}



$this->registerJs('


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

  var xlf = document.getElementById(\'xlf\');
  
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
          wb = X.read(btoa(arr), {type: \'base64\'});
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
  
  xlf.addEventListener(\'change\', handleFile, false);

  }

  
');

?>



<?php
    ExcelAsset::register($this); 
?>



