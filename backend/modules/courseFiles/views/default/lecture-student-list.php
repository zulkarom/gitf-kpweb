<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\grid\GridView;
use backend\assets\ExcelAsset;
use kartik\export\ExportMenu;


$offer = $lecture->courseOffered;
$course = $offer->course;
/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Lecture ['.$lecture->lec_name.']';
$this->params['breadcrumbs'][] = ['label' => 'My Course File', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['teaching-assignment-lecture', 'id' => $lecture->id]];
$this->params['breadcrumbs'][] = 'Student List';
?>

<h4><?=$course->course_code . ' ' . $course->course_name?> - <?=$offer->semester->longFormat()?></h4>

  <?php
if($lecture->students){

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
<h4>Student List</h4>

<?php 

/* <div class="form-group"> <input type="file" id="xlf" style="display:none;" />
<button type="button" id="btn-importexcel" class="btn btn-info"><span class="glyphicon glyphicon-import"></span> IMPORT EXCEL </button>

</div>

<?php $form = ActiveForm::begin(['id' => 'form-students']); ?>
  <input type="hidden" id="json_student" name="json_student">
  <?php ActiveForm::end(); ?> */

?>
  
</div>

<div class="col-md-4" align="right">

<a href="<?=Url::to(['resync-student', 'id' => $lecture->id])?>" class="btn btn-success"><i class="fa fa-refresh"></i> Re-Sync</a>

<a href="<?=Url::to(['lecture-student-list-pdf', 'id' => $lecture->id])?>" class="btn btn-danger" target="_blank"><i class="fa fa-download"></i> Download Pdf</a>
    

    
    
    
 </div>



</div>



<div class="box">

<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'export' => false,
        'columns' => [
            
            ['class' => 'yii\grid\SerialColumn'],
            
            
            [
                'label' => 'Student Id',
                'value' => function($model){
                    return $model->matric_no;
                }
                
            ],

            [
                'label' => 'Name',
                'value' => function($model){
                    return $model->student->st_name;
                }
                
            ],
            
        ],
    ]); ?>
    </div>
</div>




<?php 
/* 
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
      var myJSON = JSON.stringify(sheet);
      // console.log(myJSON);

            $("#json_student").val(myJSON);
            $("#form-students").submit();
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
    
    ExcelAsset::register($this); */
}else{
	echo '<p>Click the button below to load student list.</p>';
	echo '<div class="form-group"><a href="'. Url::to(['resync-student', 'id' => $lecture->id]) .'" class="btn btn-success">Load Student List</a></div>';
}


?>



