<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;


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

