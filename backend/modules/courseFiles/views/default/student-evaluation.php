<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\UploadFile;

$model->file_controller = 'appointment';





/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Student Evaluation Upload';
$this->params['breadcrumbs'][] = ['label' => 'My Course File', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = $this->title;

?>
<h4><?=$model->staffInvolved->staff->niceName?></h4>
<h4><?=$model->courseOffered->semester->longFormat()?></h4>
<h4><?=$model->courseOffered->course->course_code?> <?=$model->courseOffered->course->course_name?></h4>
<div class="box">
<div class="box-header"></div>
<div class="box-body">

<?=UploadFile::fileInput($model, 'steva')?>

</div>
</div>




<?php  

if($controller){
    echo Html::a('<span class="glyphicon glyphicon-floppy-disk"></span> Save', ['appointment/appointment-progress', 'id' => $model->id, 'c' => $controller, 'm' => $method, 'offer' => $offer], ['class' => 'btn btn-primary']);
}else{
    echo Html::a('<span class="glyphicon glyphicon-floppy-disk"></span> Save', ['appointment/appointment-progress', 'id' => $model->id], ['class' => 'btn btn-primary']);
}



?>