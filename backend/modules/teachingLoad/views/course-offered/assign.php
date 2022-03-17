<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use backend\modules\staff\models\Staff;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\teachingLoad\models\CourseOfferedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Course Assignment';
$this->params['breadcrumbs'][] = ['label' => 'Courses Offered', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h4><?=$model->course->codeCourseString?></h4>
<h4><?=$model->semester->longFormat()?></h4>

<div class="row">
<div class="col-md-3">	<!-- add lecture -->
	<?php 
	
	$form = ActiveForm::begin(); 
	$addLecure->lecture_number = 1;
	echo $form->field($addLecure, 'lecture_number', [
                    'template' => 'Add Lectures: {input}',
                    'options' => [
                        'tag' => false, // Don't wrap with "form-group" div
                    ]])->textInput(['style' => 'width:50px', 'type' => 'number', 'class' => ''])->label(false);

	echo Html::submitButton('Go', ['class' => 'btn btn-sm btn-default']);
	ActiveForm::end(); ?>
</div>

<div class="col-md-6">
<?php 

if($model->course->tut_hour == 0){
	echo '* There is no tutorial for this course';
}else{
	$form = ActiveForm::begin(); 
	$addTutorial->tutorial_number = 1;
	echo $form->field($addTutorial, 'tutorial_number', [
		                    'template' => 'Add Tutorials : {input}',
		                    'options' => [
								
		                        'tag' => false, // Don't wrap with "form-group" div
		                    ]])->textInput(['style' => 'width:50px', 'type' => 'number', 'class' => ''])->label(false);

	echo Html::submitButton('Go', ['class' => 'btn btn-sm btn-default']);
	echo $form->field($addTutorial, 'lecture_json',['options' => ['tag' => false]])->hiddenInput(['value' => ''])->label(false);
	ActiveForm::end(); 
}	
	?>


</div>

</div>
    <?php $form = ActiveForm::begin(); ?>

<div class="course-offered-index">
    <div class="box">
<div class="box-body">

  <table class="table table-striped">
    <tbody>
      <tr>
	   
        <td width="20%"> Select Course Coordinator: </td>
        <td>
		<?php
		echo $form->field($model, 'coordinator')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Staff::getAcademicStaff(), 'id', 'user.fullname'),
    'options' => ['placeholder' => 'Select a Coordinator ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label(false);

?>
		
		</td><td></td>
		<td width="20%"><?= $form->field($model, "coor_access")->checkbox(['value' => '1', 'label'=> 'Coordinator have all access']); ?>
		</td>
      </tr>
      
    </tbody>
  </table>


<div class="table-responsive">
  <table class="table">
    <thead>
      <tr>
      	<th><input type="checkbox" class ="checkAll" name="cbkLecture" value='' /></th>
        <th>#</th>
        <th width="10%">Lecture Name
		<br/><span class="font-weight:normal:font-style:italic">(e.g. L1, K2, H3)</span></th>
		<th width="10%">No.Students</th>
        <th>Lecturers</th>
		
		 <th width="10%">Tutorial Name<br/><span class="font-weight:normal:font-style:italic">(e.g. T1,T2,T3)</span></th>
		 <th width="10%">Lecture Prefix*<br/><span class="font-weight:normal:font-style:italic">(if any)</span></th>
		 <th width="3%">Scheduled</th>
		 <th width="10%">No.Students</th>
		 <th>Tutors</th>
		
      </tr>
    </thead>
    <tbody>
      
	  <?php 
	  
	  if($lectures){
		  $i = 1;
		 foreach($lectures as $lec){
			 echo '<tr>';
			$rowspan_1 = rowspan_1($lec->tutorials);
			echo '<td '.$rowspan_1.'>
			<input type="checkbox" class ="checkbxLec" name="cbkLecture" value='.$lec->id.' /></td> 
			 <td '.$rowspan_1.'>'.$i.'. </td> 

		   <td '.$rowspan_1.'>
		   <input name="Lecture['.$lec->id.'][lec_name]" type="text" class="form-control"  value="'.$lec->lec_name.'" /></td>
				
		  <td '.$rowspan_1.'>
			<input name ="Lecture['.$lec->id.'][student_num]" type="number" class="form-control" value="'.$lec->student_num.'" />
			</td>
			
		  <td '.$rowspan_1.'>';

					echo Select2::widget([
				    'name' => 'Lecture['.$lec->id.'][lecturers]',
				    'value' => ArrayHelper::map($lec->lecturers,'id','staff_id'),
				    'data' => ArrayHelper::map(Staff::getAcademicStaff(), 'id', 'user.fullname'),
				    'options' => ['multiple' => true, 'placeholder' => 'Select']
				]);



		     echo'</td>';
			 
		colum_2_first($lec->tutorials,$model->id, $lec);
		 
		
		//delete lecture - kena confirm ni
	 	echo '<td '.$rowspan_1.'>
		<a href="' . Url::to(['course-offered/delete-lecture', 'id' => $lec->id]) . '"><span class="fa fa-trash"></span></a>
		</td>
      '; 
	  
	  echo '</tr>';
	  
	  
	  colum_2($lec->tutorials,$model->id, $lec);
	 
      $i++;
		 }
	  }
	  
	  
	  
	  ?>
      
    </tbody>
  </table>
  <i>*Put lecture prefix only if it is different with lecture name</i>
</div>

</div>

</div>

<?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Save Teaching Assignment', ['class' => 'btn btn-primary']) ?>


</div>
<?php ActiveForm::end(); ?>

<?php
$js = "



function arrayChk(){ 
 
    var arrAn = [];  
  
    var m = $('.checkbxLec'); 
 
    var arrLen = $('.checkbxLec').length; 
      
    for ( var i= 0; i < arrLen ; i++){  
        var  w = m[i];                     
         if (w.checked){  
          arrAn.push( w.value );  
          console.log(w.value ); 
        }  
      }   
    
    var myJsonString = JSON.stringify(arrAn);  //convert javascript array to JSON string
   
 
 	$('#addtutorialform-lecture_json').val(myJsonString);
  
   }

    $('.checkAll').click(function() {
        $('.checkbxLec').prop('checked', this.checked);
        arrayChk();
    });



$('.checkbxLec ').click(function(e, data){

	arrayChk();
 
   
});


";

$this->registerJs($js);



function rowspan_1($clo_as){
	if($clo_as){
		$kira = count($clo_as) ;
		return "rowspan='".$kira."'";
		
	}else{
		return "";
	}
}
function colum_2_first($tutorial,$offer, $lec){
	if($tutorial){
		$tutorial = $tutorial[0];
		colum_2_td($tutorial,$offer, $lec);
	}else{
		empty_cell(4);
	}
	
}
function colum_2($tutorials,$offer, $lec){
	if($tutorials){
		$i=1;
			foreach($tutorials as $tutorial){
				if($i > 1){
					echo '<tr>';
					colum_2_td($tutorial,$offer, $lec);
					echo '</tr>';
				}
			$i++;
			}
		}
}

function colum_2_td($tutorial,$offer, $lec){
    if($tutorial->is_scheduled == 1){
        $check = 'checked';
    }else{
        $check = '';
    }
	echo'
	
	<td><input name="Lecture['.$lec->id.'][tutorial]['.$tutorial->id.'][tutorial_name]" type="text" class="form-control" value="'.$tutorial->tutorial_name.'" /></td>
	<td><input name="Lecture['.$lec->id.'][tutorial]['.$tutorial->id.'][lec_prefix]" type="text" class="form-control" value="'.$tutorial->lec_prefix.'" /></td>
    <td>
<input type="hidden" name="Lecture['.$lec->id.'][tutorial]['.$tutorial->id.'][is_scheduled]" value="0" />
<input type="checkbox" name="Lecture['.$lec->id.'][tutorial]['.$tutorial->id.'][is_scheduled]" value="1" '. $check .' /></td>
	<td><input name ="Lecture['.$lec->id.'][tutorial]['.$tutorial->id.'][student_num]" class="form-control" type="number"  value="'.$tutorial->student_num.'" /></td>
	<td>';

	echo Select2::widget([
		'name' => 'Lecture['.$lec->id.'][tutorial]['.$tutorial->id.'][tutoriallecturers]',
		'value' => ArrayHelper::map($tutorial->tutors,'id','staff_id'),
		'data' => ArrayHelper::map(Staff::getAcademicStaff(), 'id', 'user.fullname'),
		'options' => ['multiple' => true, 'placeholder' => 'Select']
	]);

	echo'</td>
	<td>
	<a href="' . Url::to(['course-offered/delete-tutorial', 'id' => $tutorial->id, 'offered' => $offer,'']) . '" >
	<span class="fa fa-remove"></span></a>
	</td>
	';
				
}

function empty_cell($colum){
	$str = "";
	for($i=1;$i<=$colum;$i++){
		echo "<td></td>";
	}
}


?>
