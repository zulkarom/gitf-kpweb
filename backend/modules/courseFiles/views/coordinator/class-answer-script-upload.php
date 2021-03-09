<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\UploadFile;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */
$course = $model->course;
$this->title = $course->course_code . ' '  . $course->course_name;
$this->params['breadcrumbs'][] = ['label' => 'Teaching Load', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = ['label' => 'Coordinator', 'url' => ['/course-files/default/teaching-assignment-coordinator', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Student’s Final Exam Answer Scripts';

$model->file_controller = 'coordinator-upload';
?>

<h4><?=$model->semester->longFormat()?></h4>
<h4>Nine (9) Copies of Student’s Final Exam Answer Scripts</h4>

  <div class="box box-primary">

<div class="box-body">


<table class="table">
<thead>
<tr>
	<th width="5%">#</th>
	<th width="30%">Document Title</th>
	<th>Upload File</th>
</tr>
<thead>
<tbody>
	<tr>
		<td>1. </td>
		<td>Best Answer Script 1</td>
		<td>
<?=UploadFile::fileInput($model, 'scriptbest1', false, false, 'single-simple')?>
</td>
	</tr>
	
	<tr>
		<td>2. </td>
		<td>Best Answer Script 2</td>
		<td><?=UploadFile::fileInput($model, 'scriptbest2', false, false, 'single-simple')?></td>
	</tr>
	
	<tr>
		<td>3. </td>
		<td>Best Answer Script 3</td>
		<td><?=UploadFile::fileInput($model, 'scriptbest3', false, false, 'single-simple')?></td>
	</tr>
	
	<tr>
		<td>4. </td>
		<td>Moderate Answer Script 1</td>
		<td><?=UploadFile::fileInput($model, 'scriptmod1', false, false, 'single-simple')?></td>
	</tr>
	
	<tr>
		<td>5. </td>
		<td>Moderate Answer Script 2</td>
		<td><?=UploadFile::fileInput($model, 'scriptmod2', false, false, 'single-simple')?></td>
	</tr>
	
	<tr>
		<td>6. </td>
		<td>Moderate Answer Script 3</td>
		<td><?=UploadFile::fileInput($model, 'scriptmod3', false, false, 'single-simple')?></td>
	</tr>
	
	<tr>
		<td>7. </td>
		<td>Lowest Answer Script 1</td>
		<td><?=UploadFile::fileInput($model, 'scriptlow1', false, false, 'single-simple')?></td>
	</tr>
	
	<tr>
		<td>8. </td>
		<td>Lowest Answer Script 2</td>
		<td><?=UploadFile::fileInput($model, 'scriptlow2', false, false, 'single-simple')?></td>
	</tr>
	
	<tr>
		<td>9. </td>
		<td>Lowest Answer Script 3</td>
		<td><?=UploadFile::fileInput($model, 'scriptlow3', false, false, 'single-simple')?></td>
	</tr>
	
</tbody>
</table>
<br />

</div></div>

