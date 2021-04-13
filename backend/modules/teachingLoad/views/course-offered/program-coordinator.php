<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\teachingLoad\models\CourseOfferedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Program Coordinator';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-offered-index">



    <div class="row">

        <div class="col-md-10" align="right">

            <?= $this->render('../manager/_semester_course', [
                'model' => $semester,
            ]) ?>
        </div>
    </div>

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
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
            

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 12.7%'],
                'template' => '{assign} {update}',
                //'visible' => false,
                'buttons'=>[
					'assign'=>function ($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-user"></span> Assign', ['assign', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm'
						]) 
				;
                    },
                    'update'=>function ($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
						'class' => 'btn btn-danger btn-sm',
							'data' => [
								'confirm' => 'Are you sure you want to delete this course?',
								'method' => 'post',
							],
						]) 
				;
                    }

                ],
            
            ],

        ],
    ]); ?></div>
</div>

</div>
