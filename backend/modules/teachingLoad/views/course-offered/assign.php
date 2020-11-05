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

			 	<td style="vertical-align: middle;"><input type="checkbox" class ="checkbxLec" name="cbkLecture" value="'.$lec->id.'" /></td> 
			 	<td style="vertical-align: middle;">'.$i.'. </td> 

		        <td style="vertical-align: middle;"><input name="Lecture['.$lec->id.'][lec_name]" type="text" style="width:100%" value="'.$lec->lec_name.'" /></td>
		       	<td style="vertical-align: middle;"><input name ="Lecture['.$lec->id.'][student_num]" type="text" style="width:100%" value="'.$lec->student_num.'" /></td>
		        <td style="vertical-align: middle;">';

					echo Select2::widget([
				    'name' => 'tagged_staff',
				    //'value' => ArrayHelper::map($model->pubTagsNotMe,'id','staff_id'),
				    'data' => ArrayHelper::map(Staff::activeStaffNotMe(), 'id', 'staff_name'),
				    'options' => ['multiple' => true, 'placeholder' => 'Select Staff ...']
				]);



		        echo'</td>
				<td width="50%">';


		// add tutorial
		// $form = ActiveForm::begin();
		// 	$addTutorial->tutorial_number = 1;
		// 	echo $form->field($addTutorial, 'lecture_id',['options' => ['tag' => false]])->hiddenInput(['value' => $lec->id ])->label(false);
		// 	echo 'Add Tutorials: ' . $form->field($addTutorial, 'tutorial_number', [
		//                     'template' => '{input}',
		//                     'options' => [
								
		//                         'tag' => false, // Don't wrap with "form-group" div
		//                     ]])->textInput(['style' => 'width:50px', 'type' => 'number', 'class' => ''])->label(false);

		// 	echo Html::submitButton('Go', ['class' => 'btn btn-sm btn-default']);

		//    ActiveForm::end();

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
				    <td><input type="text" style="width:100%" value="" /></td>
				    <td><input type="text" style="width:100%" value="" /></td>
				    <td>';

				    echo Select2::widget([
					    'name' => 'tagged_staff',
					    //'value' => ArrayHelper::map($model->pubTagsNotMe,'id','staff_id'),
					    'data' => ArrayHelper::map(Staff::activeStaffNotMe(), 'id', 'staff_name'),
					    'options' => ['multiple' => true, 'placeholder' => 'Select Staff ...']
					]);

				    echo'</td>
				    <td>
				    <a href="' . Url::to(['course-offered/delete-tutorial', 'id' => $tutorial->id, 'offered' => $model->id]) . '" >
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

$('.checkbxLec ').click(function(e, data){
	var id = $(this).val();
    
    var myJSON = JSON.stringify(id);
 
    $('#addtutorialform-lecture_json').val(myJSON);
});

";

$this->registerJs($js);

?>

