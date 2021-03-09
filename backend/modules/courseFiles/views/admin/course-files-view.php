<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;


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

if($modelOffer->status == 10){  
    ?>
<div class="form-group"><a href="<?=Url::to(['course-files-view', 'id' => $modelOffer->id, 'revert' => 1])?>" class="btn btn-warning" data-confirm="This action will change the status of course file to draft, click ok to proceed.">Revert Status to Draft</a></div>
    <?php 
}	
	
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

