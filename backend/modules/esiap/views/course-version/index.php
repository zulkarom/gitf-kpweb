<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\esiap\models\CourseVersionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Course Versions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-version-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Course Version', ['course-version-create', 'course' => $course->id], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'version_name',
            'is_active',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?></div>
</div>

</div>
