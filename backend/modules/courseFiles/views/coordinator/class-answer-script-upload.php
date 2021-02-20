<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\UploadFile;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Upload Files';
$this->params['breadcrumbs'][] = ['label' => 'Teaching Load', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = ['label' => 'Course Files', 'url' => ['/course-files/default/teaching-assignment-coordinator', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
$course = $model->course;
$model->file_controller = 'coordinator-upload';
?>

<div><div style="font-size:14px;font-weight:bold"><?=$course->course_code?> <?=$course->course_name?></div>
<div style="margin-bottom:10px;font-size:14px">Nine (9) Copies of Student’s Final Exam Answer Scripts<br/>

</div>

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

