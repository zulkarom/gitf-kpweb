<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'New Course Offered';
$this->params['breadcrumbs'][] = ['label' => 'Course Offereds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-offered-create">

<div class="box">
<div class="box-header"></div>
<div class="box-body">    <?= $this->render('_form', [
        'model' => $model,
    ]) ?></div>
</div>


</div>
