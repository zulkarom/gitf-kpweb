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
	
	<div class="row">
<div class="col-md-6"><p>
        <?= Html::a('Create Course', ['create'], ['class' => 'btn btn-success']) ?>
    </p></div>

<div class="col-md-6" align="right">

<?=$this->render('_search', ['model' => $searchModel])?>
</div>

</div>

    

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'course_code',
			[
				'attribute' => 'course_name',
				'format' => 'html',
				'label' => 'Course Name',
				'value' => function($model){
					return $model->course_name . ' / <i>' . $model->course_name_bi . '</i>';
				}
				
			],
            [
                'label' => 'Published',
                'format' => 'html',
                'value' => function($model){
					if($model->publishedVersion){
						return $model->publishedVersion->version_name;
					}else{
						return 'NONE';
					}
                    
                }
            ],
			[
                'label' => 'UDV',
                'format' => 'html',
                
                'value' => function($model){
					if($model->developmentVersion){
						return $model->developmentVersion->labelStatus;
					}else{
						return 'NONE';
					}
                    
                }
            ],

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 9%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> Update',['/esiap/course-admin/update/', 'course' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },

                ],
            
            ],
        ],
    ]); ?></div>
</div>

</div>
