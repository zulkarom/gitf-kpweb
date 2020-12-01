<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\esiap\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Selection by Course';
$this->params['breadcrumbs'][] = $this->title;



$columns = [
            ['class' => 'yii\grid\SerialColumn'],
			
			'course_code',
			'course_name',
			[

				'label' => 'Lecturers',
				'format' => 'html',
				'value' => function($model){
					return $model->staffStr ;
				}
				
			]

        ];
?>
<div class="course-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	
	<div class="row">
<div class="col-md-6">
		
		<?=ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
	'filename' => 'COURSE_TEACHING_' . date('Y-m-d'),
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
<br />

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

				'label' => 'Lecturers',
				'format' => 'html',
				'value' => function($model){
					return $model->getStaffStr("<br />") ;
				}
				
			]
	
        ],
    ]); ?></div>
</div>

</div>
