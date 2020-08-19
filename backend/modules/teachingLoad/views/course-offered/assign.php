<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\teachingLoad\models\CourseOfferedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Course Assignment';
$this->params['breadcrumbs'][] = $this->title;
?>
<h4><?=$model->course->codeCourseString?></h4>



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


<br />


<div class="course-offered-index">

    <div class="box">
<div class="box-body">

<div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
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
			 <td>'.$i.'. </td> 
        <td><input type="text" style="width:50px" value="'.$lec->lec_name.'" /></td>
       <td><input type="text" style="width:50px" value="" /></td>
        <td><input type="text" style="width:100%" value="" /></td>
		<td width="40%">


  <table class="table">
      <tr>
        <td><input type="text" style="width:80px" value="" /></td>
		<td><input type="text" style="width:50px" value="" /></td>
        <td><input type="text" style="width:100%" value="" /></td>
      </tr>
  </table>
		
		
		</td>
		<td><span class="fa fa-trash"></span?</td>
      </tr>';
		 } 
	  }
	  
	  
	  
	  ?>
      
    </tbody>
  </table>
</div>


</div>
</div>


</div>
