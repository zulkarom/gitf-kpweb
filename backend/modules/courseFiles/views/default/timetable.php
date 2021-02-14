<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\UploadFile;

$model->file_controller = 'staff';





/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Timetable Upload';
$this->params['breadcrumbs'][] = ['label' => 'Teaching Assignment', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="box">
<div class="box-header"></div>
<div class="box-body">

<?=UploadFile::fileInput($model, 'timetable')?>

</div>
</div>


