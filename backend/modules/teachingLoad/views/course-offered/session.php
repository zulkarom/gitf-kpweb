<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Bulk Session';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="course-offered-session">
<?php $form = ActiveForm::begin(); ?>


<br/>
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
      <tr>
      	<td></td>
      	<td></td>
      	<td></td>
      	<td></td>
      	<td></td>
      	<td></td>
      	<td></td>
      	<td></td>
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
