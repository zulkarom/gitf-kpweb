<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\esiap\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Course Resources';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-index">



<?= $this->render('semester-form', [
        'model' => $semester,
    ]) ?>
    
    



<?=$this->render('course-files-view', [    
            'model' => $model,
            'offer' =>$offer,
           ]);
    ?>
    

</div>
