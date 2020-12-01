<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

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
<?php $form = ActiveForm::begin([
'id' => 'form-bulksession'
]);
 ?>

<div class="form-group">   
<button type="button" class="btn btn-primary" id="btn-save"><span class="glyphicon glyphicon-floppy-save"></span>  SAVE BULK SESSION</button>

<button type="button" id="btn-run" class="btn btn-warning"><span class="fa fa-gears"></span> RUN BULK SESSION </button>

<button type="button" id="btn-delete" class="btn btn-danger" ><span class="glyphicon glyphicon-trash"></span> DELETE BULK SESSION </button>
</div>

<input type="hidden" name="btn-action" id="btn-action" value="" />

<div class="box">
<div class="box-body">



<div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>#</th>
        <th>Course Code</th>
    		<th>Course Name (BM)</th>
        <th>Current Lectures</th>
        <th>Current Tutorials</th>
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
                <td>'.$course->countLectures.'</td>
                <td>'.$course->countTutorials.'</td>
              	<td><input name="Course['.$course->id.'][total_student]" type="text" style="width:100%" value="'.$course->total_students.'" />
                </td>
              	<td><input name="Course['.$course->id.'][max_lecture]" type="text" style="width:100%" value="'.$course->max_lec.'" /></td>
              	<td><input name="Course['.$course->id.'][prefix_lecture]" type="text" style="width:100%" value="'.$course->prefix_lec.'" /></td>
                <td><input name="Course['.$course->id.'][max_tutorial]" type="text" style="width:100%" value="'.$course->max_tut.'" /></td>
                <td><input name="Course['.$course->id.'][prefix_tutorial]" type="text" style="width:100%" value="'.$course->prefix_tut.'" /></td>';
       
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




</div>
<?php ActiveForm::end(); ?>

<?php 
$this->registerJs('
$("#btn-save").click(function(){
  $("#btn-action").val(0);
  $("#form-bulksession").submit();
});

$("#btn-run").click(function(){
  $("#btn-action").val(1);
  if(confirm("Are you sure to run this bulk session? Please note that this action cannot be undone.")){
    $("#form-bulksession").submit();
  }
});

$("#btn-delete").click(function(){
  $("#btn-action").val(2);
  if(confirm("Are you sure to delete this bulk session? Please note that this action cannot be undone.")){
    $("#form-bulksession").submit();
  }
});



');

?>
</div>
