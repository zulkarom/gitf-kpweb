<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;


/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Course Files View';
$this->params['breadcrumbs'][] = ['label' => 'Course Files', 'url' => ['/course-files/default/index']];
$this->params['breadcrumbs'][] = $this->title;
$course = $modelOffer->course; 
?>

<style>
#course {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#course td, #course th {
  border: 1px solid #ddd;
  padding: 8px;
}

#course tr:nth-child(even){background-color: #f2f2f2;}

#course tr:hover {background-color: #ddd;}

#course th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #3c8dbc;
  color: white;
}
</style>

<div class="course-files-view">
<?php $form = ActiveForm::begin(); ?>

    <!-- Plan -->
    <?=$this->render('course-files-view-plan', [    
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
<?php ActiveForm::end(); ?>

