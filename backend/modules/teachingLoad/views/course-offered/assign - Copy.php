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
	echo Select2::widget([
				    'name' => 'coordinator',
				    'value' => $model->coordinator,
				    'data' => ArrayHelper::map(Staff::getAcademicStaff(), 'id', 'user.fullname'),
				    'options' => ['placeholder' => 'Select Coordinator ...'],
				    'pluginOptions' => [
                		'allowClear' => true
            		],
				]);
?>
		
		</td><td></td>
		<td width="10%">
		</td>
      </tr>
      
    </tbody>
  </table>


<div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
      	<th><input type="checkbox" class ="checkAll" name="cbkLecture" value='' /></th>
        <th>#</th>
        <th width="10%">Lecture Name
		<br/><span class="font-weight:normal:font-style:italic">(e.g. L1,K2,H3)</span></th>
		<th width="10%">No.Student</th>
        <th>Lecturers</th>
		 <th>Tutorials</th>
		 <th></th>
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
			 
		colum_2_first($form,$clo->cloAssessments, $assess, $model);
		
		echo '<td width="50%">';
		   if($lec->tutorials){
		   	$j=1;
		   	echo '<div class="table-responsive">
				  <table class="table table-striped table-hover">
				    <thead>
				      <tr>
				        <th width="20%">Tutorial Name</th>
				        <th width="20%">No.Student</th>
				        <th>Tutor</th>
				      </tr>
				    </thead>
				    <tbody>';


		   	foreach ($lec->tutorials as $tutorial) {
		   		echo'<tr>
				    <td><input name="Lecture['.$lec->id.'][tutorial]['.$tutorial->id.'][tutorial_name]" type="text" class="form-control" value="'.$tutorial->tutorial_name.'" /></td>
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
				    <a href="' . Url::to(['course-offered/delete-tutorial', 'id' => $tutorial->id, 'offered' => $model->id,'']) . '" >
					<span class="fa fa-trash"></span></a>
					</td>
					</tr>';
				   
		   	}
		   	 	echo'</tbody>
				   </table>
				   </div>';
		   }

		
				    
				    
    	echo '</td>';
		
		
		//delete lecture - kena confirm ni
		echo '<td '.$rowspan_1.'>
		<a href="' . Url::to(['course-offered/delete-lecture', 'id' => $lec->id]) . '"><span class="fa fa-trash"></span></a>
		</td>
      </tr>';

      $i++;
		 } 
	  }
	  
	  
	  
	  ?>
      
    </tbody>
  </table>
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
		$kira = count($clo_as) + 1;
		return "rowspan='".$kira."'";
		
	}else{
		return "";
	}
}
function colum_2_first($form,$clo_as, $assess, $model){
	if($clo_as){
		
		$cloAs = $clo_as[0];
		colum_2_td($form,$cloAs, $assess,$model);
	}else{
		empty_cell(2);
	}
	
}
function colum_2($form,$clo_as, $assess, $model){
	if($clo_as){
		$i=1;
			foreach($clo_as as $cloAs){
				if($i > 1){
					echo '<tr>';
					colum_2_td($form,$cloAs, $assess,$model);
					echo '</tr>';
				}
			$i++;
			}
		}
}

function colum_2_td($form,$cloAs, $assess,$model){
	$index = $cloAs->id;
	$clo_id = $cloAs->clo_id;
	echo '<td>' . Html::activeHiddenInput($cloAs, "[{$index}]id") . $form->field($cloAs, "[{$index}]assess_id", [
					'options' => [
						'tag' => false, // Don't wrap with "form-group" div
					]])->dropDownList(
        ArrayHelper::map($assess,'id', "assess_name"), ['prompt' => 'Please Select' ]
    )
->label(false) . '</td>';
				
					echo '<td>' . $form->field($cloAs, "[{$index}]percentage", [
					'addon' => ['append' => ['content'=>'%']],
					'options' => [
						'tag' => false, // Don't wrap with "form-group" div
					]])->textInput()->label(false) . '</td>
					<td class="text-center vcenter" style="width: 90px;">
                    <a href="'.Url::to(['delete-assessment-clo', 'course' => $model->course->id, 'id' => $cloAs->id]).'" class="remove-item btn btn-default btn-sm"><span class="fa fa-remove"></span></a></td>';
				
}

function empty_cell($colum){
	switch($colum){
		case 2:
		$x = 2;
		break;
		break;
	}
	$str = "";
	for($i=1;$i<=$x;$i++){
		echo "<td></td>";
	}
}


?>
