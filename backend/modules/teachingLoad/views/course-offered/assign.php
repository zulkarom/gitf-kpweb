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
$this->params['breadcrumbs'][] = $this->title;
?>
<h4><?=$model->course->codeCourseString?></h4>


	<!-- add lecture -->
	<?php $form = ActiveForm::begin(); ?>
	<?php 
	$addLecure->lecture_number = 1;
	echo 'Add Lecture: ' . $form->field($addLecure, 'lecture_number', [
                    'template' => '{input}',
                    'options' => [
						
                        'tag' => false, // Don't wrap with "form-group" div
                    ]])->textInput(['style' => 'width:50px', 'type' => 'number', 'class' => ''])->label(false)

	
	?>
      
	<?= Html::submitButton('Go', ['class' => 'btn btn-sm btn-default']) ?>

    <?php ActiveForm::end(); ?>

	<!-- add tutorial -->
    <?php $form = ActiveForm::begin(); ?>
	<?php 
	$addTutorial->tutorial_number = 1;
	echo $form->field($addTutorial, 'lecture_json',['options' => ['tag' => false]])->hiddenInput(['value' => ''])->label(false);

	echo 'Add Tutorials: ' . $form->field($addTutorial, 'tutorial_number', [
		                    'template' => '{input}',
		                    'options' => [
								
		                        'tag' => false, // Don't wrap with "form-group" div
		                    ]])->textInput(['style' => 'width:50px', 'type' => 'number', 'class' => ''])->label(false);

	
	?>
      
	<?= Html::submitButton('Go', ['class' => 'btn btn-sm btn-default']) ?>
    <?php ActiveForm::end(); ?>


<br />


<div class="course-offered-index">

<?php $form = ActiveForm::begin(); ?>
    <div class="box">
<div class="box-body">


<div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
      	<th></th>
        <th>#</th>
        <th>Lecture</th>
		<th>No.Student</th>
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
			 echo '<tr>

			 	<td style="vertical-align: middle;"><input type="checkbox" class ="checkbxLec" name="cbkLecture" value='.$lec->id.' /></td> 
			 	<td style="vertical-align: middle;">'.$i.'. </td> 

		        <td style="vertical-align: middle;"><input name="Lecture['.$lec->id.'][lec_name]" type="text" style="width:100%" value="'.$lec->lec_name.'" /></td>
		       	<td style="vertical-align: middle;"><input name ="Lecture['.$lec->id.'][student_num]" type="text" style="width:100%" value="'.$lec->student_num.'" /></td>
		        <td style="vertical-align: middle;">';

					echo Select2::widget([
				    'name' => 'Lecture['.$lec->id.'][lecturers]',
				    'value' => ArrayHelper::map($lec->lecturers,'id','staff_id'),
				    'data' => ArrayHelper::map(Staff::activeStaffNotMe(), 'id', 'staff_name'),
				    'options' => ['multiple' => true, 'placeholder' => 'Select Staff ...']
				]);



		        echo'</td>
				<td width="50%">';


		
	
		   if($lec->tutorials){
		   	$j=1;
		   	echo '<div class="table-responsive">
				  <table class="table table-striped table-hover">
				    <thead>
				      <tr>
				        <th>Tutorial Name</th>
				        <th>No.Student</th>
				        <th>Tutor</th>
				      </tr>
				    </thead>
				    <tbody>';


		   	foreach ($lec->tutorials as $tutorial) {
		   		echo'<tr>
				    <td><input name="Lecture['.$lec->id.'][tutorial]['.$tutorial->id.'][tutorial_name]" type="text" style="width:100%" value="'.$tutorial->tutorial_name.'" /></td>
				    <td><input name ="Lecture['.$lec->id.'][tutorial]['.$tutorial->id.'][student_num]" type="text" style="width:100%" value="'.$tutorial->student_num.'" /></td>
				    <td>';

				    echo Select2::widget([
					    'name' => 'Lecture['.$lec->id.'][tutorial]['.$tutorial->id.'][tutoriallecturers]',
					    'value' => ArrayHelper::map($tutorial->lecturers,'id','staff_id'),
					    'data' => ArrayHelper::map(Staff::activeStaffNotMe(), 'id', 'staff_name'),
					    'options' => ['multiple' => true, 'placeholder' => 'Select Staff ...']
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

		
				    
				    
    	echo '</td>
		<td>
		<a href="' . Url::to(['course-offered/delete-lecture', 'id' => $lec->id]) . '" ><span class="fa fa-trash"></span></a>
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

<?= Html::submitButton('Save', ['class' => 'btn btn-sm btn-default']) ?>

<?php ActiveForm::end(); ?>
</div>

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




$('.checkbxLec ').click(function(e, data){

	arrayChk();
 
   
});


";

$this->registerJs($js);


?>
