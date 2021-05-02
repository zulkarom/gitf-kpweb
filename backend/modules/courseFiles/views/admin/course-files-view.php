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
$this->params['breadcrumbs'][] = ['label' => 'Course Files', 'url' => ['/course-files/admin/index']];
$this->params['breadcrumbs'][] = $this->title;

?>



<div class="course-files-view">

<?php echo $this->render('course-loads', [    
            'offer' =>$modelOffer,
           ]);
	
	
	echo $this->render('course-files-view-plan', [    
            'model' => $model,
            'modelOffer' =>$modelOffer,
           ]);
    ?>

    <!-- Do -->
    <?=$this->render('course-files-view-do', [    
            'model' => $model,
            'modelOffer' =>$modelOffer,
           ]);
    ?>

    <!-- Check -->
    <?=$this->render('course-files-view-check', [    
            'model' => $model,
            'modelOffer' =>$modelOffer,
           ]);
    ?>

    <!-- Act -->
    <?=$this->render('course-files-view-act', [    
            'model' => $model,
            'modelOffer' =>$modelOffer,
           ]);
    ?>
	
	</div>
	
	
<?php $form = ActiveForm::begin(); ?>

<div class="box">
<div class="box-header">
<h3 class="box-title">Course File Verification</h3>
</div>
<div class="box-body">

<div class="row">
<div class="col-md-6">
<?php 
if($modelOffer->auditor_file){
	?>
	<div class="form-group">
<label>Auditor's Report: <a href="<?=Url::to(['auditor/download-file', 'attr' => 'auditor', 'id' => $modelOffer->id])?>" target="_blank">Download</a></label>
</div>
	<?php
	
}

?>


<?php 
$modelOffer->status = 50;
echo $form->field($modelOffer, 'status')->dropDownList( $modelOffer->statusArray, ['prompt' => 'Please Select' ])->label('Status') ?>


</div>

</div>



<div class="form-group"><?=UploadFile::fileInput($modelOffer, 'verified')?></div>




<div class="form-group">
<?php echo $form->field($model, 'course_id')->hiddenInput(['value' => $modelOffer->course_id])->label(false)?>
<?php 


echo Html::submitButton('SAVE', 
    ['class' => 'btn btn-warning', 'name' => 'wfaction', 'value' => 'btn-verify', 'data' => [
                'confirm' => 'Are you sure to store the status?'
            ],
    ])?>

</div>
</div>
</div>




    <?php ActiveForm::end(); ?>
	


