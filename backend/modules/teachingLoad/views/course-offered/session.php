<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Bulk Session';
$this->params['breadcrumbs'][] = ['label' => 'Courses Offered', 'url' => ['/teaching-load/course-offered/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_form_session', [
        'model' => $semester,
    ]) ?>
    
<div class="course-offered-session">
<?php $form = ActiveForm::begin(); ?>


<div class="box">
<div class="box-body">



<div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>#</th>
        <th>Course Code</th>
    		<th>Course Name (BM)</th>
        <th>Total Number of Students</th>
    		<th>Maximum Student of a Lecture</th>
    		<th>Prefix Lecture Name</th>
    		<th>Maximum Student of a Tutorial</th>
    		<th>Prefix Tutorial Name</th>
      </tr>
    
        <?php 
    
        if($model->course){
        $i = 1;
          foreach($model->course as $course){
        	echo '<tr><td>'.$i.'</td>
              	<td>'.$course->course->course_code.'</td>
              	<td>'.$course->course->course_name.'</td>
              	<td><input name="Course['.$course->id.'][total_student]" type="text" style="width:100%" value="0" />
                </td>
              	<td><input name="Course['.$course->id.'][max_lecture]" type="text" style="width:100%" value="0" /></td>
              	<td><input name="Course['.$course->id.'][prefix_lecture]" type="text" style="width:100%" value="L" /></td>
                <td><input name="Course['.$course->id.'][max_tutorial]" type="text" style="width:100%" value="0" /></td>
                <td><input name="Course['.$course->id.'][prefix_tutorial]" type="text" style="width:100%" value="T" /></td>';
       
                $i++;
          }
        }
              ?>

      </tr>
    </thead>
    <tbody>
      <tr>
      	
      </tr>
	</tbody>
  </table>
</div>
</div>

</div>

</div>

<?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Save Bulk Session', ['class' => 'btn btn-primary']) ?>


</div>
<?php ActiveForm::end(); ?>


</div>
