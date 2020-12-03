<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\assets\ExcelAsset;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Bulk Session';
$this->params['breadcrumbs'][] = ['label' => 'Courses Offered', 'url' => ['/teaching-load/course-offered/index']];
$this->params['breadcrumbs'][] = $this->title;
?>



<?= $this->render('_form_session', [
        'model' => $semester,
    ]) ?>
    
<div class="course-offered-session">
<?php $form = ActiveForm::begin([
'id' => 'form-bulksession'
]);
 ?>

<div class="form-group">   
<button type="button" class="btn btn-primary" id="btn-save"><span class="glyphicon glyphicon-floppy-save"></span>  SAVE BULK SESSION</button>

<button type="button" id="btn-run" class="btn btn-warning"><span class="fa fa-gears"></span> RUN BULK SESSION </button>

<button type="button" id="btn-delete" class="btn btn-danger" ><span class="glyphicon glyphicon-trash"></span> DELETE BULK SESSION </button>

<button type="button" id="btn-excel" class="btn btn-success" ><span class="glyphicon glyphicon-export"></span> EXPORT EXCEL </button>

<input type="file" id="xlf" style="display:none;" />
<button type="button" id="btn-importexcel" class="btn btn-info"><span class="glyphicon glyphicon-import"></span> IMPORT EXCEL </button>


</div>

<input type="hidden" name="btn-action" id="btn-action" value="" />

<div class="box">
<div class="box-body">



<div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>#</th>
        <th>Course Code</th>
    		<th>Course Name (BM)</th>
        <th>Current Lectures</th>
        <th>Current Tutorials</th>
        <th>Total Number of Students</th>
    		<th>Maximum Student of a Lecture</th>
    		<th>Prefix Lecture Name</th>
    		<th>Maximum Student of a Tutorial</th>
    		<th>Prefix Tutorial Name</th>
      </tr>
    
        <?php 
    
        if($model->course){
        $i = 1;
          foreach($model->course as $course){
        	echo '<tr><td>'.$i.'</td>
              	<td>'.$course->course->course_code.'</td>
              	<td>'.$course->course->course_name.'</td>
                <td>'.$course->countLectures.'</td>
                <td>'.$course->countTutorials.'</td>
              	<td><input id="'.$course->course->course_code.'-total_student" name="Course['.$course->id.'][total_student]" type="text" style="width:100%" value="'.$course->total_students.'" />
                </td>
              	<td><input id="'.$course->course->course_code.'-max_lecture" name="Course['.$course->id.'][max_lecture]" type="text" style="width:100%" value="'.$course->max_lec.'" /></td>
              	<td><input id="'.$course->course->course_code.'-prefix_lecture" name="Course['.$course->id.'][prefix_lecture]" type="text" style="width:100%" value="'.$course->prefix_lec.'" /></td>
                <td><input id="'.$course->course->course_code.'-max_tutorial" name="Course['.$course->id.'][max_tutorial]" type="text" style="width:100%" value="'.$course->max_tut.'" /></td>
                <td><input id="'.$course->course->course_code.'-prefix_tutorial" name="Course['.$course->id.'][prefix_tutorial]" type="text" style="width:100%" value="'.$course->prefix_tut.'" /></td>';
       
                $i++;
          }
        }
              ?>

      </tr>
    </thead>
    <tbody>
      <tr>
      	
      </tr>
	</tbody>
  </table>
</div>
</div>

</div>

</div>




</div>
<?php ActiveForm::end(); ?>

<?php 
$this->registerJs('
$("#btn-save").click(function(){
  $("#btn-action").val(0);
  $("#form-bulksession").submit();
});

$("#btn-run").click(function(){
  $("#btn-action").val(1);
  if(confirm("Are you sure to run this bulk session? Please note that this action cannot be undone.")){
    $("#form-bulksession").submit();
  }
});

$("#btn-delete").click(function(){
  $("#btn-action").val(2);
  if(confirm("Are you sure to delete this bulk session? Please note that this action cannot be undone.")){
    $("#form-bulksession").submit();
  }
});

$("#btn-excel").click(function(){
  $("#btn-action").val(3);
  $("#form-bulksession").submit();
});

$("#btn-importexcel").click(function(){
  
  if(confirm("Are you sure to import this excel file? Please note that this action will override all data in this table.")){
  document.getElementById("xlf").click();
}
        
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
    var files = e.target.files;
    var f = files[0];
  
    {
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
            for(var row in sheet){
              var row = sheet[row];
              //console.log(row);
              $("#"+row[1]+"-total_student").val(row[5]);
              $("#"+row[1]+"-max_lecture").val(row[6]);
              $("#"+row[1]+"-prefix_lecture").val(row[7]);
              $("#"+row[1]+"-max_tutorial").val(row[8]);
              $("#"+row[1]+"-prefix_tutorial").val(row[9]);
            }
          }
          
      };
      reader.readAsArrayBuffer(f);
    }
    
  }

  if(xlf.addEventListener){
  
  xlf.addEventListener(\'change\', handleFile, false);

  }

');

?>

<?php
    
    ExcelAsset::register($this);
?>

</div>
