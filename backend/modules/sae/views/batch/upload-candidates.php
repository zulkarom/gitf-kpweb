<?php
use richardfan\widget\JSRegister;

ExcelAsset::register($this); 
?>

<div style="text-align:center">
<div class="form-group">   
<input type="file" id="xlf" style="display:none;" />
<button type="button" id="btn-importexcel" class="btn btn-info">Select Excel File</button>

<div align="center" id="uploadmsg">testtt</div>

</div>
</div>


<?php JSRegister::begin(); ?>
<script>

$("#btn-importexcel").click(function(){
  
  // if(confirm("Are you sure to import this excel file? Please note that this action will override all data in this table.")){
  document.getElementById("xlf").click();
// }
        
});

var X = XLSX;
  
  function fixdata(data) {
    var o = "", l = 0, w = 10240;
    for(; l<data.byteLength/w; ++l) o+=String.fromCharCode.apply(null,new Uint8Array(data.slice(l*w,l*w+w)));
    o+=String.fromCharCode.apply(null, new Uint8Array(data.slice(l*w)));
    return o;
  }

  function showWaiting(f){
		var tt ="";
		var ext = f.split('.').pop();
		if(ext == "xls" || ext == "xlsx"){
			tt="Sila Tunggu...";
		}else{
			tt="Jenis file salah ("+f+")";
		}
		$("#uploadmsg").text(tt);
	}
  
  function to_csv(workbook) {
    var result = [];
    var tetapan="";
    var baik = 0;
    workbook.SheetNames.forEach(function(sheetName) {
      var csv = X.utils.sheet_to_csv(workbook.Sheets[sheetName]);
      if(csv.length > 0){
        if(sheetName=="workSheet"){
          var baik = 1;
          var user = $('#upuserid').text();
          saveAllAnswers(user, csv);
          //alert(user);
          //alert(csv); 
            //alert(baik);
        }
      }
    });
    
    if(baik ==0){
      //$("#uploadmsg").html("Maaf, jawapan tidak berjaya direkod!");
    }
    
  }

  var xlf = document.getElementById('xlf');
  
  function handleFile(e) {
    var files = e.target.files;
    var f = files[0];
  
    {
      var reader = new FileReader();
      reader.onload = function(e) {
        var data = e.target.result;
        var wb;
        var arr = fixdata(data);
          wb = X.read(btoa(arr), {type: 'base64'});
          //console.log(to_jsObject(wb)); 
          var obj = to_jsObject(wb) ;
          for (var key in obj) {
            var sheet = obj[key];
            for(var row in sheet){
              var row = sheet[row];
              console.log(row);
              // $("#"+row[1]+"-total_student").val(row[5]);
              // $("#"+row[1]+"-max_lecture").val(row[6]);
              // $("#"+row[1]+"-prefix_lecture").val(row[7]);
              // $("#"+row[1]+"-max_tutorial").val(row[8]);
              // $("#"+row[1]+"-prefix_tutorial").val(row[9]);
            }
            break;
          }
          
      };
      reader.readAsArrayBuffer(f);
    }
    
  }

  if(xlf.addEventListener){
  
  xlf.addEventListener('change', handleFile, false);

  }

</script>
<?php JSRegister::end(); ?>