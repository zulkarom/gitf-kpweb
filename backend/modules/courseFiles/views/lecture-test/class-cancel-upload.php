<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\UploadFile;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Upload Files';
$this->params['breadcrumbs'][] = ['label' => 'Teaching Assignment', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = ['label' => 'Course Files', 'url' => ['/course-files/default/teaching-assignment-lecture', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
$course = $model->courseOffered->course;
?>

<div><div style="font-size:14px;font-weight:bold"><?=$course->course_code?> <?=$course->course_name?></div>
<div style="margin-bottom:10px;font-size:14px">Record of Class Cancellation and Replacement (if applicable)</div>


</div>



  <div class="box box-primary">

<div class="box-body">
  <table class="table table-striped table-hover">

<tbody>
	<?php 
	if($model->lectureCancelFiles){
		foreach($model->lectureCancelFiles as $file){
			$file->file_controller = 'lecture-cancel-file';
			?>
			<tr>
				<td><?=UploadFile::fileInput($file, 'path', false, true)?></td>
			</tr>
			<?php
		}
	}
	
	?>
</tbody>
</table>
<br />
<a href="<?=Url::to(['lecture-cancel-file/add', 'id' => $model->id])?>" class="btn btn-default" ><span class="glyphicon glyphicon-plus"></span> Add Cancellation Document</a>
</div></div>

