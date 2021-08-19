<?php 
use common\models\UploadFile;
use yii\helpers\Html;



$this->title = 'Manual Upload of Appointment Letter';
$model->file_controller = 'appointment-letter';

$this->params['breadcrumbs'][] = ['label' => 'Appointment Letter', 'url' => ['/teaching-load/staff-inv/index']];
$this->params['breadcrumbs'][] = ['label' => 'Generate Reference', 'url' => ['/teaching-load/staff-inv/generate-reference']];
$this->params['breadcrumbs'][] = 'Manual Upload';
?>



<div class="box">
<div class="box-header"></div>
<div class="box-body">


<p><?php echo $model->courseOffered->semester->longFormat();?></p>
<p><?php echo $model->staffInvolved->staff->staff_title . ' ' . $model->staffInvolved->staff->user->fullname ;?></p>
<?php echo $model->courseOffered->course->codeCourseString ?>
<br /><br />
<?=UploadFile::fileInput($model, 'manual')?>

</div>
</div>

<?=Html::a('<span class="glyphicon glyphicon-floppy-disk"></span> Save', ['/teaching-load/appointment-letter/appointment-progress', 'id' => $model->id], ['class' => 'btn btn-primary'])?>