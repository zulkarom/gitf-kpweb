<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


$offer = $lecture->courseOffered;
$course = $offer->course;

$this->title = 'Student Attendance ['.$lecture->lec_name.']';
$this->params['breadcrumbs'][] = ['label' => 'My Course File', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = ['label' => 'Lecture['.$lecture->lec_name.']', 'url' => ['teaching-assignment-lecture', 'id' => $lecture->id]];
$this->params['breadcrumbs'][] = 'Student Attendance';

if($lecture->students){
?>



<?php /* <div class="form-group"><?= Html::a('Manage Class Date', ['/course-files/default/lecture-student-attendance-date', 'id' => $lecture->id], ['class' => 'btn btn-success']) ?></div> */?>
<div class="row">
  <div class="col-md-6">
  
  <h4><?=$course->course_code . ' ' . $course->course_name?></h4>
<h4><?=$offer->semester->longFormat()?></h4>
  </div>
  <div class="col-md-6" align="right">
  <br />

   

   <div class="form-group" align="right">
	<?php 
	
	$attendance = json_decode($lecture->attendance_header);
	if($attendance){
		?>
		<a href="<?=Url::to(['attendance-summary-pdf', 'id' => $lecture->id])?>" class="btn btn-danger btn-sm" target="_blank"><i class="fa fa-download"></i> Download</a>

		<a href="<?=Url::to(['attendance-sync', 'id' => $lecture->id])?>" class="btn btn-success btn-sm"><i class="fa fa-refresh"></i> Re-Sync</a>
		<?php
	}else{
		echo '<p>To get started, kindly click the button below to load attendance data from UMK Portal</p>
		<div class="form-group"><a href="'.Url::to(['attendance-sync', 'id' => $lecture->id]).'" class="btn btn-success">Load Attendance Data</a></div>
		';
	}
	
	
	?>
    

</div>


  </div>
</div>

<div class="box">

          <div class="box-body">
           
            <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Matric No.</th>
                    <th>Student Name</th>
                  
                      <?php 
					  $kira = 0;
                      $attendance = json_decode($lecture->attendance_header);
                      if($attendance){
						
                        foreach($attendance as $attend){
                          echo'<th><center>'. date('d-m', strtotime($attend)) .'</center></th>';
						  $kira++;
                        }
                      }
                  ?>
			<th>%</th>
			</tr>
				   </thead>
                     <?php
                    $x=1;
                    $st_arr = '';
					$input_html = '';
                      foreach ($lecture->students as $student) {
                        if($student->lecture_id == $lecture->id){
							$comma = $x == 1 ? '': ',';
                          $st_arr .= $comma.  "'" . $student->matric_no . "'";
                          echo'<tr><td>'.$x.'. </td>
                          <td>'.$student->matric_no.'
						  
						  </td>
                          <td>'.$student->student->st_name.'</td>';

                            $attendance = json_decode($student->attendance_check);
							
                            if($attendance){
                              $count = 0;
							  $i = 1;
							  $all=count($attendance);
							  $str = '[';
                              foreach($attendance as $attend){
								$comma = $i == 1 ? '':',';
								

                               if($attend == 1)
                               {
								$str .= $comma. '1';
                                $check = 'checked';
                                $count++;
                               }else{
                                $check ='';
								$str .= $comma. '0';
                               }

                                echo'<td><center>
								<input type="hidden" name="cb_'.$student->matric_no .'[]" value ="0" />
                                  <input type="checkbox" class ="checkbxAtt" name="cb_'.$student->matric_no .'[]" id="cb_'.$student->matric_no.'_'.$i.'" value="1" '.$check.'/></center>
                                </td>';
								$i++;
                              }
							  $str .= ']';
                              echo '<td id="per_'. $student->matric_no .'">
							  
							  '.round(($count / $all)*100).'%
							  
							  
							  </td>';
							  
							  $input_html .= '<input type="hidden" name="con_'. $student->matric_no .'" id="con_'. $student->matric_no .'" value="'.$str.'" />';
                             
                            }else
                            {
                                $column = json_decode($lecture->attendance_header);
								$str = '[';
                                if($column){
									$iv = 1;
                                    foreach($column as $col){
										$comma = $iv == 1 ? '':',';
										$str .= $comma. '0';
                                        echo'<td></td>';
									$iv++;
                                    }
                                    echo'<td></td>';
                                }
								$str .= ']';
								
                               $input_html .= '<input type="hidden" name="con_'. $student->matric_no .'" id="con_'. $student->matric_no .'" value="'.$str.'" />';
							   echo '<td></td>';
                            }

                          $x++;
                        }
                        
            echo '</tr>';
                      }
                    

              ?>
              </table>
            </div>
            <?php /*  =$form->field($model, 'attendance_json',['options' => ['tag' => false]])->hiddenInput(['value' => ''])->label(false) */?>
             

           
          </div>
        </div>
		
		
		
		
<?php $form = ActiveForm::begin() ?>
<div class="form-group">
<?php 
$check = $lecture->prg_attend_complete == 1 ? 'checked' : ''; ?>
<label>
<input type="checkbox" id="complete" name="complete" value="1" <?=$check?> /> Mark as complete
</label></div>
		 <div class="form-group">
		 <?=$input_html?>
                  <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span>  Save Attendance', ['class' => 'btn btn-success', 'id' => 'btn-save']) ?>
              </div>
		
 <?php ActiveForm::end(); ?>

<?php
$js = "

$('#btn-save').click(function(){
	//calcAll();
});

$('.checkbxAtt').click(function(){
	var id = $(this).attr('id');
	var arr = id.split('_');
	var matric = arr[1];
	//alert(calcAttend(matric));
	$('#per_' + matric).text(calcPercent(matric));
	$('#con_' + matric).val(JSON.stringify(calcAttend(matric)));
});

function calcAll(){
	var arr = [".$st_arr."];
	var matric;
	for(i=0;i<arr.length;i++){
		matric = arr[i];
		$('#con_' + matric ).val(JSON.stringify(calcAttend(matric)));

	}
}

function calcPercent(matric){
	var arr = calcAttend(matric);
	//alert(arr);
	var attend = 0;
	for(i=0;i<arr.length;i++){
		if(arr[i] == 1){
			attend++;
		}
	}
	var per = attend / arr.length * 100;
	return Math.round(per) + '%';
}

function calcAttend(matric){
	var cnt = ".$kira."  ;
	var cb;var val;
	var arrAtt = [];
	
	for(i=1;i<=cnt;i++){
		cb = 'cb_' + matric + '_' + i;
		val = $('#'+ cb).prop('checked');
		if(val){
			arrAtt.push( 1 );
			
		}else{
			arrAtt.push( 0 );
		}
	}
	return arrAtt;
}

/* function arrayChk(){ 
 
    var arrAn = [];  
  
    var m = $('.checkbxAtt'); 
 
    var arrLen = $('.checkbxAtt').length; 
      
    for ( var i= 0; i < arrLen ; i++){  
        var  w = m[i];                     
         if (w.checked == true){  
          arrAn.push( w.value );  
          console.log('Checkbox is checked.' ); 
        }
        if (w.checked == false){
          console.log('Checkbox is unchecked.' );
        }  
      }   
    
    var myJsonString = JSON.stringify(arrAn);  //convert javascript array to JSON string   

    $('#model-attendance_json').val(myJsonString);
   
   }


$('.checkbxAtt ').click(function(e, data){

  arrayChk();
 
   
});
 */

";

$this->registerJs($js);



}else{
    
	echo '<h4>To properly view this page, kindly load <a href="'. Url::to(['default/lecture-student-list', 'id' => $lecture->id]) .'">student list</a> first.</h4>';
	
}
?>




