<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\UploadFile;

$model->file_controller = 'staff';





/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Staff Timetable';
$this->params['breadcrumbs'][] = ['label' => 'My Course File', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = $this->title;

?>
<h4><?=$model->semester->longFormat()?></h4>
<div class="box">
<div class="box-header"></div>
<div class="box-body">

<?=UploadFile::fileInput($model, 'timetable')?>

</div>
</div>

<?=Html::a('<span class="glyphicon glyphicon-floppy-disk"></span> Save', ['default/timetable', 's' => $model->semester->id, 'back' => 1], ['class' => 'btn btn-primary'])?>