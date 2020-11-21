<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\esiap\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Teaching Assignment by Course';
$this->params['breadcrumbs'][] = $this->title;



$columns = [
            ['class' => 'yii\grid\SerialColumn'],
			
			'course_code',
			'course_name',

            [
                'label' => 'Coordinator',
                'format' => 'html',
                'value' => function($model){
                    return $model->coordinatorStr();
                }
            ],

			

			[
                'label' => 'Lectures',
                'format' => 'html',
                'value' => function($model){
                    return $model->teachLectureStr;
                }
            ],

            [
                'label' => 'Lectures Assignment',
                'value' => function($model){
                    //return $model->lecture;
                }
                
            ],
           
           
            
            [
                'label' => 'Tutorials',
                'format' => 'html',
                'value' => function($model){
                    return $model->teachTutorialStr;
                }
            ],

            [
                'label' => 'Tutorials Assigment',
                'format' => 'html',
               
            ],
            
            
            [
                'label' => 'Total',
                'format' => 'html',
                'value' => function($model){
                    return $model->totalLectureTutorial;
                }
            ],

        ];
?>
<div class="course-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	
	<div class="row">
	
	<div class="col-md-10" align="right">

<?= $this->render('_semester_course', [
        'model' => $semester,
    ]) ?>
</div>
<div class="col-md-2">
		
		<?=ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
	'filename' => 'COURSE_SUMMARY_' . date('Y-m-d'),
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



</div>

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
		'export' => false,
       // 'filterModel' => $searchModel,
        'columns' => [
	
            ['class' => 'yii\grid\SerialColumn'],
			
			'course_code',
			'course_name',

			[
                'label' => 'Coordinator',
                'format' => 'html',
                'value' => function($model) use ($semester){
            
                    return $model->getCoordinatorStr($semester->semester_id);
                    
                }
            ],

			[
                'label' => 'Lectures',
                'format' => 'html',
                'value' => function($model) use ($semester){
            
                    return $model->getTeachLectureStr($semester, "<br />");
                    
                }
            ],
            

            /* [
                'label' => 'Lectures Assigment',
                'format' => 'html',
                'value' => function($model){
            
//return $model->getLecture("<br />");
                    
                }
                
            ], */
            
            [
                'label' => 'Tutorial',
                'format' => 'html',
                'value' => function($model){
                    return $model->getTeachTutorialStr("<br />");
                }
            ],
            
            /* [
                'label' => 'Tutorial Assigment',
                'format' => 'html',
                
            ], */

            /* [
                'label' => 'Total',
                'format' => 'html',
                'value' => function($model){
                    return $model->getTotalLectureTutorial("<br />");
                }
            ], */
	
        ],
    ]); ?></div>
</div>

</div>
