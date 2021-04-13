<?php

use yii\helpers\Html;
use yii\helpers\Url;



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


<div class="form-group">
<a href="<?=Url::to(['submit-course-file', 'id' =>$modelOffer->id ])?>" class="btn btn-primary" data-confirm="Are you sure to submit this course file?">Submit Course File</a>
</div>