<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\modules\courseFiles\models\Common;
use common\models\UploadFile;


/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */
$course = $modelOffer->course;
$this->title = $course->course_code . ' ' . $course->course_name;
$this->params['breadcrumbs'][] = ['label' => 'My Course File', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = ['label' => 'Coordinator', 'url' => ['/course-files/default/teaching-assignment-coordinator', 'id' => $modelOffer->id]];
$this->params['breadcrumbs'][] = 'View ';


?>



<div class="course-files-view">
	<?=$this->render('../admin/course-loads', [    
            'offer' =>$modelOffer,
           ]);
    ?>
    <!-- Plan -->
    <?=$this->render('../admin/course-files-view-plan', [    
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

<?php if(!Common::isDue($modelOffer->semesterDates->open_deadline) && in_array($modelOffer->status, [0,20])){ // draft & reupdate?>

<div class="box box-solid">
<div class="box-body">


<br />

<?php 
$form = ActiveForm::begin(); 

$modelOffer->file_controller = 'coordinator';
echo UploadFile::fileInput($modelOffer, 'coorsign', true)?>



<div class="row">
<div class="col-md-2">
    <?= $form->field($modelOffer, 'coorsign_size')->textInput(['maxlength' => true, 'type' => 'number'
                            ])->label('Adjust Size') ?>
    </div>
<div class="col-md-2">
    <?= $form->field($modelOffer, 'coorsign_adj_y')->textInput(['maxlength' => true, 'type' => 'number'
                            ])->label('Adjust Y') ?>
    </div>

</div>
<i>
* For the signature, use png format image with transparent background. You can click <a href="https://www.remove.bg/" target="_blank">Remove.bg</a> to easily remove background.<br />
* Approximate size 200 x 100 (pixel).<br />
* Increase Adjust Size to make the image bigger and vice versa.<br />
* Increase Adjust Y Size to move the image upwards and vice versa. <br />
</i>
</div>
</div>


<div class="form-group">
<?=Html::submitButton('Submit Course File', ['class' => 'btn btn-primary'])?>
</div>



<?php 
ActiveForm::end(); 
    
    }



?>