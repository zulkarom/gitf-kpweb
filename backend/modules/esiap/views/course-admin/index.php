<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\esiap\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Courses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Course', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
				'attribute' => 'crs_code',
				'contentOptions' => ['style' => 'width: 12%'],
			],
            'crs_name',
            'crs_name_bi',
			[
				'attribute' => 'credit_hour',
				'contentOptions' => ['style' => 'width: 10%'],
				
			],

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 17%'],
                'template' => '{pic} {version}',
                //'visible' => false,
                'buttons'=>[
                    'pic'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-user"></span> PIC',['/esiap/course-admin/course-version', 'course' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },
					'version'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-files"></span> Version',['/esiap/course/delete/', 'course' => $model->id],['class'=>'btn btn-info btn-sm',
]);
                    }
                ],
            
            ],
        ],
    ]); ?></div>
</div>

</div>
