<?php

use backend\assets\ExcelAsset;
use richardfan\widget\JSRegister;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Bulk Update';
$this->params['breadcrumbs'][] = ['label' => 'Student', 'url' => ['/students/student/index']];
$this->params['breadcrumbs'][] = $this->title;

ExcelAsset::register($this); 

?>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="student-form">
First row = heading (so data start at second row)<br />
First column = number, second = fullname, third = matric number, forth = NRIC, fifth = program<br />
<?=Html::a('Download sample file', Yii::getAlias('@web') . '/download/student-bulk-update.xlsx',['target' => '_blank'])?> <br />
The uploaded data will updated NRIC & program (abbr.) base on matric number.
<br />
If matric number not found, new data will be created provided fullname available.
<br />
<br />



    <div class="form-group">
        <br/>
        <input type="file" id="xlf" style="display:none;" />
        <button type="button" id="btn-importexcel" class="btn btn-primary"><span class="fa fa-upload"></span> UPDATE STUDENT INFO </button>
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


<?php $form = ActiveForm::begin(['id' => 'form-student']); ?>
  <input type="hidden" id="json_student" name="json_student">
  <?php ActiveForm::end(); ?> 


<?php 
JSRegister::begin(); ?>
<script>

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
      //console.log(myJSON);

            $("#json_student").val(myJSON);
			$('#loadingModal').modal({
   backdrop: 'static',
   keyboard: false,
   show: true
});
            $("#form-student").submit();
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

