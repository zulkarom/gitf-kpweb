<?php 
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'e-SIAP MODULE';
$this->params['breadcrumbs'][] = $this->title;

?>

<i>Electronic Structured and Integrated Academic Package</i>
<br /><br />


<div class="box box-primary">
<div class="box-header">
<h3 class="box-title">My Course(s)</h3>
</div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider2,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			'course.course_code',
            'course.course_name',
			'course.course_name_bi',
			'course.credit_hour',


            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 25%'],
                'template' => '{fk1} {fk2} {fk3}',
                //'visible' => false,
                'buttons'=>[
                    'fk1'=>function ($url, $model) {
						$version = $model->course->publishedVersion;
						if($version){
							return Html::a('<span class="glyphicon glyphicon-download-alt"></span> FK01',['/esiap/course/fk1/', 'course' => $model->course_id],['target' => '_blank','class'=>'btn btn-danger btn-sm']);
						}else{
							return '-';
						}
                        
                    },
					'fk2'=>function ($url, $model) {
						$version = $model->course->publishedVersion;
						if($version){
							return Html::a('<span class="glyphicon glyphicon-download-alt"></span> FK02',['/esiap/course/fk2/', 'course' => $model->course_id],['target' => '_blank','class'=>'btn btn-danger btn-sm']);
						}else{
							return '-';
						}
                        
                    },
					'fk3'=>function ($url, $model) {
						$version = $model->course->publishedVersion;
						if($version){
							return Html::a('<span class="glyphicon glyphicon-download-alt"></span> FK03',['/esiap/course/fk3/', 'course' => $model->course_id],['target' => '_blank','class'=>'btn btn-danger btn-sm']);
						}else{
							return '-';
						}
                        
                    },
                ],
            
            ],
        ],
    ]); ?></div>
</div>


<div class="box box-danger">
<div class="box-header">
<h3 class="box-title">Under Development Course(s)</h3>
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
				'attribute' => 'course.developmentVersion.labelStatus',
				'label' => 'Status',
				'format' => 'html'
				
				
			],

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 10%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
						$version = $model->course->developmentVersion;
						if($version){
							return Html::a('<span class="glyphicon glyphicon-pencil"></span> Update',['/esiap/course/update/', 'course' => $model->course_id],['class'=>'btn btn-warning btn-sm']);
						}else{
							return 'NO UDV';
						}
                        
                    },
                ],
            
            ],
        ],
    ]); ?></div>
</div>