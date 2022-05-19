<?php
use backend\assets\ExcelAsset;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$offer = $lecture->courseOffered;
$course = $offer->course;
/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Lecture [' . $lecture->lec_name . ']';
$this->params['breadcrumbs'][] = [
    'label' => 'My Course File',
    'url' => [
        '/course-files/default/teaching-assignment'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $this->title,
    'url' => [
        'teaching-assignment-lecture',
        'id' => $lecture->id
    ]
];
$this->params['breadcrumbs'][] = 'Student List';
ExcelAsset::register($this);
?>

<h4><?=$course->course_code . ' ' . $course->course_name?> - <?=$offer->semester->longFormat()?></h4>

  <?php

$columns = [
    [
        'class' => 'yii\grid\SerialColumn'
    ],

    [
        'label' => 'Student Id',
        'format' => 'html',
        'value' => function ($model) {
            return $model->matric_no;
        }
    ],
    [
        'label' => 'Name',
        'format' => 'html',
        'value' => function ($model) {
            return $model->student->st_name;
        }
    ]
];
?>

<div class="row">

<div class="col-md-8">
<h4>Student List</h4>





<?php

$form = ActiveForm::begin([
    'id' => 'form-students',
    'action' => Url::to([
        '/course-files/default/import-student-list-excel',
        'id' => $lecture->id
    ])
]);
?>
  <input type="hidden" id="json_student" name="json_student">
  <?php

ActiveForm::end();
?>



</div>

<div class="col-md-4" align="right">

<div class="form-group">

<?php

$lvl = $lecture->courseOffered->course->study_level;

if ($lvl == 'PG' or $offer->student_upload) {
    ?>
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#import-excel"><span class="glyphicon glyphicon-import"></span> IMPORT EXCEL </button>
<?php

} else {
    ?>
<a href="<?=Url::to(['resync-student','id' => $lecture->id])?>" class="btn btn-success"><i class="fa fa-refresh"></i> LOAD STUDENT</a>
<?php

}
?>

<a href="<?=Url::to(['lecture-student-list-pdf','id' => $lecture->id])?>" class="btn btn-danger" target="_blank"><i class="fa fa-download"></i> PDF</a>


</div>


 </div>
</div>

<div id="import-excel" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Import Student Using Excel File</h4>
      </div>
      <div class="modal-body">


        <p><b>The Instruction:</b></p>

        <ul>
	<li>The first colum is for student matric number and the second colum is for student name.</li>
	<li>The first row is for the header, so the first student shoud start at second row.</li>
	<li>The system will match the excel data with the current student in the list. Hence, the additional
	student in the excel will add to the list and students that not exist in the excel will be deleted from the list.
	</li>
	<li> <a href="<?=Url::to(['default/export-excel-student','id' => $lecture->id])?>" target="_blank">Download the template here.</a></li>

</ul>

 <p><b>WARNING:</b> Importing empty template will delete all the student with all related data.</p>
 <br />

<input type="file" id="xlf" style="display:none;" />
<button type="button" id="btn-importexcel" class="btn btn-success"><span class="fa fa-upload"></span> SELECT EXCEL FILE</button>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

 <div class="modal" id="loadingModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-body" align="center">
        <h3>LOADING DATA...</h3>
      </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




<div class="box">

<div class="box-body">


<?php

$more_group = false;
if ($lecture->courseOffered->course_version2 > 0) {
    $more_group = true;
}

if ($more_group) {
    $colums[] = [
        'class' => 'yii\grid\CheckboxColumn'
    ];
}

$colums[] = [
    'class' => 'yii\grid\SerialColumn'
];

$colums[] = [
    'label' => 'Student Id',
    'value' => function ($model) {
        return $model->matric_no;
    }
];

$colums[] = [
    'label' => 'Name',
    'value' => function ($model) {
        return $model->student->st_name;
    }
];

if ($more_group) {
    $colums[] = [

        'label' => 'Group',
        'value' => function ($model) {
            return 'Group ' . $model->stud_group;
        }
    ];
}

$colums[] = [
    'class' => 'yii\grid\ActionColumn',
    'contentOptions' => [
        'style' => 'width: 10%'
    ],
    'template' => '{delete}',
    // 'visible' => false,
    'buttons' => [
        'delete' => function ($url, $model) {
            return Html::a('<span class="glyphicon glyphicon-trash"></span>', [
                'delete-student-lecture',
                'id' => $model->id,
                'lec' => $model->lecture_id
            ], [
                'data' => [
                    'confirm' => 'Are you sure to remove this student (' . $model->student->st_name . ') from this lecture class?'
                ]
            ]);
        }
    ]
];

?>



<?php
$lecture->assign_group = 0;

$form = ActiveForm::begin([
    'id' => 'assign-group-form'
]);
?>
<?=GridView::widget(['dataProvider' => $dataProvider,'export' => false,'columns' => $colums]);?>




    <?php
    if ($more_group) {

        ?>
    <div class="row">
	<div class="col-md-6"> <?=$form->field($lecture, 'assign_group')->dropDownList([1 => 'Group 1',2 => 'Group 2'], ['prompt' => 'Select Group'])?></div>

</div>



    <?php
    }
    ActiveForm::end();

    ?>






    </div>
</div>




<?php

$this->registerJs('

$("#courselecture-assign_group").change(function(){
    $("#assign-group-form").submit();

});

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
            $("#import-excel").modal("hide");

            	$("#loadingModal").modal({
                   backdrop: "static",
                   keyboard: false,
                   show: true
                });
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



