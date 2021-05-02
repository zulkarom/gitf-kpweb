<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use common\models\UploadFile;

$modelOffer->file_controller = 'auditor';


/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */
$this->title = $modelOffer->course->course_name;
$this->params['breadcrumbs'][] = ['label' => 'Internal Auditor', 'url' => ['/course-files/auditor/index']];
$this->params['breadcrumbs'][] = $this->title;

?>



<div class="course-files-view">

<?php echo $this->render('../admin/course-loads', [    
            'offer' =>$modelOffer,
           ]);
	
	
	echo $this->render('../admin/course-files-view-plan', [    
            'model' => $model,
            'modelOffer' =>$modelOffer,
           ]);
    ?>

    <!-- Do -->
    <?=$this->render('../admin/course-files-view-do', [    
            'model' => $model,
            'modelOffer' =>$modelOffer,
           ]);
    ?>

    <!-- Check -->
    <?=$this->render('../admin/course-files-view-check', [    
            'model' => $model,
            'modelOffer' =>$modelOffer,
           ]);
    ?>

    <!-- Act -->
    <?=$this->render('../admin/course-files-view-act', [    
            'model' => $model,
            'modelOffer' =>$modelOffer,
           ]);
    ?>

</div>

<?php 
if($modelOffer->status == 0 or $modelOffer->status == 10){
	?>
	
<?php $form = ActiveForm::begin(); ?>

<div class="box">
<div class="box-header">
<h3 class="box-title">Audit Review</h3>
</div>
<div class="box-body">

<div class="row">
<div class="col-md-6">

<?= $form->field($modelOffer, 'option_review')->dropDownList( [20 => 'REUPDATE - Ask coordinator to update and resubmit' , 30 => 'COMPLETE - No update required'], ['prompt' => 'Please Select' ])->label('Auditor\'s Review Result') ?>

<?= $form->field($modelOffer, 'option_course')->dropDownList( [1 => 'YES' , 0 => 'NO'], ['prompt' => 'Please Select' ])->label('Reupdate Course Information') ?>


</div>

</div>


<div class="form-group"><?=UploadFile::fileInput($modelOffer, 'auditor')?></div>




<div class="form-group">
<?=$form->field($model, 'course_id')->hiddenInput(['value' => $modelOffer->course_id])->label(false)?>
<?php 


echo Html::submitButton('Submit Audit Review', 
    ['class' => 'btn btn-warning', 'name' => 'wfaction', 'value' => 'btn-verify', 'data' => [
                'confirm' => 'Are you sure to submit this audit review?'
            ],
    ])?>

</div>
</div>
</div>




    <?php ActiveForm::end(); ?>
	
	<?php
}

?>


