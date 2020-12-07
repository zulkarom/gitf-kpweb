<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\UploadFile;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Upload Files';
$this->params['breadcrumbs'][] = $this->title;
$course = $model->courseOffered->course;
?>

<div><div style="font-size:14px;font-weight:bold"><?=$course->course_code?> <?=$course->course_name?></div>
<div style="margin-bottom:10px;font-size:14px">Record of Student’s Medical Checkup/ Class Exemption</div>


</div>



  <div class="box box-primary">

<div class="box-body">
  <table class="table table-striped table-hover">

<tbody>
	<?php 
	if($model->lectureExemptFiles){
		foreach($model->lectureExemptFiles as $file){
			$file->file_controller = 'lecture-exempt-file';
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
<a href="<?=Url::to(['lecture-exempt-file/add', 'id' => $model->id])?>" class="btn btn-default" ><span class="glyphicon glyphicon-plus"></span> Add Exemption Document</a>
</div></div>

