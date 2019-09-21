<?php 
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'e-SIAP MODULE';
$this->params['breadcrumbs'][] = $this->title;

?>

<i>Electronic Structured and Integrated Academic Package</i>
<br /><br />


<div class="box">
<div class="box-header">
<h3 class="box-title">My Course(s)</h3>
</div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			'course.course_code',
            'course.course_name',
			'course.course_name_bi',
			'course.credit_hour',
			[
				'attribute' => 'course.defaultVersion.labelStatus',
				'label' => 'Status',
				'format' => 'html'
				
				
			],

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 10%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> Update',['/esiap/course/update/', 'course' => $model->course_id],['class'=>'btn btn-warning btn-sm']);
                    },
                ],
            
            ],
        ],
    ]); ?></div>
</div>