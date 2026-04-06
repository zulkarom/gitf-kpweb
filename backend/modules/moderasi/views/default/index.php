<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\moderasi\models\CourseChecker;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\teachingLoad\models\CourseOfferedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $semester backend\models\SemesterForm */

$this->title = 'Moderasi - Offered Courses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="moderasi-default-index">

    <div class="row">
        <div class="col-md-10" align="right">
            <?= $this->render('@backend/modules/teachingLoad/views/manager/_semester_course_program', [
                'model' => $semester,
            ]) ?>
        </div>
    </div>

    <div class="box">
        <div class="box-header"></div>
        <div class="box-body"><?php
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'course.codeCourseString',
                        'label' => 'Course',
                    ],
                    [
                        'attribute' => 'coor.user.fullname',
                        'label' => 'Coordinator',
                    ],
                    [
                        'label' => 'Level',
                        'value' => function ($model) {
                            return $model->course ? $model->course->study_level : '';
                        },
                    ],
                    [
                        'label' => 'Checker/Vetter 1',
                        'value' => function ($model) {
                            $cc = CourseChecker::findByOfferedId($model->id);
                            if ($cc && $cc->checker1 && $cc->checker1->user) {
                                return $cc->checker1->user->fullname;
                            }
                            return '';
                        },
                    ],
                    [
                        'label' => 'Checker/Vetter 2',
                        'value' => function ($model) {
                            $cc = CourseChecker::findByOfferedId($model->id);
                            if ($cc && $cc->checker2 && $cc->checker2->user) {
                                return $cc->checker2->user->fullname;
                            }
                            return '';
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'width: 12.7%'],
                        'template' => '{assign}',
                        'buttons' => [
                            'assign' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span> Assign', ['assign', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']);
                            },
                        ],
                    ],
                ],
            ]);
        ?></div>
    </div>

</div>
