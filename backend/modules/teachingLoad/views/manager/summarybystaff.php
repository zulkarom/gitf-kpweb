<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\esiap\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Teaching Load by Staff';
$this->params['breadcrumbs'][] = $this->title;



$columns = [
            ['class' => 'yii\grid\SerialColumn'],
            
            
            [
                //'contentOptions' => ['style' => 'width: 45%'],
                //'format' => 'html',
                'label' => 'Lecturer',
                'value' => function($model){
                    return $model->staff_title . ' ' . $model->user->fullname ;
                }
                
            ],

           
            

            [
                'label' => 'Lectures',
                'format' => 'html',
				'contentOptions' => [ 'style' => 'width: 30%;' ],
                'value' => function($model) use ($semester){
            
                    return $model->getTeachLectureStr($semester);
                    
                }
            ],
            
            
            [
                'label' => 'Tutorial',
                'format' => 'html',
                'value' => function($model) use ($semester){
                    return $model->getTeachTutorialStr($semester);
                }
            ],
            
            
            [
                'label' => 'Total',
                'format' => 'html',
                'value' => function($model){
                    return $model->totalLectureTutorialHour;
                }
            ],
			[
                'label' => 'Remark',
                'format' => 'html',
                'value' => function($model){
                    return $model->labelTotalHours;
                }
            ],

        ];
?>
<div class="course-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <div class="row">

        <div class="col-md-10" align="right">

<?= $this->render('_semester_staff', [
        'model' => $semester,
    ]) ?>
</div>
        
<div class="col-md-2">
        
        <?=ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
    'filename' => 'STAFF_SUMMARY_' . date('Y-m-d'),
    'onRenderSheet'=>function($sheet, $grid){
        $sheet->getStyle('A2:'.$sheet->getHighestColumn().$sheet->getHighestRow())
        ->getAlignment()->setWrapText(true);
    },
    'exportConfig' => [
        ExportMenu::FORMAT_PDF => false,
        ExportMenu::FORMAT_EXCEL_X => false,
    ],
]);?>
        
        
        
 </div>

<div class="col-md-6" align="right">

<?php //=$this->render('_search', ['model' => $searchModel])?>
</div>

</div>

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'export' => false,
		'options' => [ 'style' => 'table-layout:fixed;' ],
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            
            [
                //'contentOptions' => ['style' => 'width: 45%'],
                //'format' => 'html',
                'label' => 'Lecturer',
                'value' => function($model){
                    return $model->staff_title . ' ' . $model->user->fullname ;
                }
                
            ],

           
            

            [
                'label' => 'Lectures',
                'format' => 'html',
				'contentOptions' => [ 'style' => 'width: 30%;' ],
                'value' => function($model) use ($semester){
            
                    return $model->getTeachLectureStr($semester,"<br />");
                    
                }
            ],
            
            
            [
                'label' => 'Tutorial',
                'format' => 'html',
                'value' => function($model) use ($semester){
                    return $model->getTeachTutorialStr($semester,"<br />");
                }
            ],
            
            [
                'label' => 'Total',
                'format' => 'html',
                'value' => function($model){
                    return $model->totalLectureTutorialHour;
                }
            ],
			[
                'label' => 'Remark',
                'format' => 'html',
                'value' => function($model){
                    return $model->labelTotalHours;
                }
            ],
            //PastExperiencesStr
            

            /* ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 9%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> Update',['/esiap/course-admin/update/', 'course' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },

                ],
            
            ], */
        ],
    ]); ?>
    
    
    * Scheduled
    </div>
</div>

</div>
