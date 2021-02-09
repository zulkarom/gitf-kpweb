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

<?php 

/* <div class="form-group"> <input type="file" id="xlf" style="display:none;" />
<button type="button" id="btn-importexcel" class="btn btn-info"><span class="glyphicon glyphicon-import"></span> IMPORT EXCEL </button>

</div>

<?php $form = ActiveForm::begin(['id' => 'form-students']); ?>
  <input type="hidden" id="json_student" name="json_student">
  <?php ActiveForm::end(); ?> */

?>
  
</div>

<div class="col-md-3" align="right">
    
    <?=ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
  'filename' => 'Student_List_' . date('Y-m-d'),
  'onRenderSheet'=>function($sheet, $grid){
    $sheet->getStyle('A2:'.$sheet->getHighestColumn().$sheet->getHighestRow())
    ->getAlignment()->setWrapText(true);
  },
  'exportConfig' => [
        ExportMenu::FORMAT_PDF => false,
    ExportMenu::FORMAT_EXCEL_X => false,
    ],
]);?>

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
                    <th>No.</th>
                    <th>Matric No.</th>
                    <th>Name</th>
                    <?php
                    if($assessment)
                    {
                      foreach ($assessment as $assess) {
                        echo'<th>'.$assess->assess_name_bi.'</th>';
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
                        echo'<tr><td>'.$i.'</td>
                          <td>'.$student->matric_no.'</td>
                          <td>'.$student->student->st_name.'</td>';
                           if($assessment)
                            {
                              foreach ($assessment as $assess) {
                                echo'<td></td>';
                              }
                            }
                        echo'</tr>';
                        $i++;
                      }

                    }


                ?>
            </table>

            </div>
              <div class="form-group">
                  <br/>
                  <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span>  Save', ['class' => 'btn btn-success']) ?>
              </div>
            <?php ActiveForm::end(); ?>
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
*/


    
    ExcelAsset::register($this); 
?>



