<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\assets\ExcelAsset;


$offer = $lecture->courseOffered;
$course = $offer->course;
/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Lecture ['.$lecture->lec_name.']';
$this->params['breadcrumbs'][] = ['label' => 'Teaching Assignment', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['teaching-assignment-lecture', 'id' => $lecture->id]];
$this->params['breadcrumbs'][] = 'Student List';
?>

<h4><?=$course->course_code . ' ' . $course->course_name?></h4>
<h4><?=$offer->semester->longFormat()?></h4>
<br />





<h4>Student List</h4>

<div class="form-group"> <input type="file" id="xlf" style="display:none;" />
<button type="button" id="btn-importexcel" class="btn btn-info"><span class="glyphicon glyphicon-import"></span> IMPORT EXCEL </button></div>

<div class="box">

<div class="box-body">

  <table class="table">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
        <th style="width:10%">Student Id</th>
        <th>Student Name</th>
      </tr>
    </thead>
   <tbody id="loaded-students">

   </tbody>
  </table>
</div>
</div>


<?php 
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
          //console.log(to_jsObject(wb)); 
          var obj = to_jsObject(wb) ;
          for (var key in obj) {
            var sheet = obj[key];
			var i = 1;
            for(var row in sheet){
				
              row = sheet[row];
              num = i - 1;
			  if(i > 1){
				  str = \'<tr><td>\'+ num +\'</td><td>\' + row[0] + \'</td><td>\' + row[1] + \'</td></tr>\';
					$("#loaded-students").append(str);
			  }
			  

			  i++;
            }
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



