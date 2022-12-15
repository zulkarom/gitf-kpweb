<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\students\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Students';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
  $columns = [
            ['class' => 'yii\grid\SerialColumn'],
            'st_name',
            'matric_no',
            'nric',
            
            'program',
        ];
?>
<div class="form-group">

<div class="row">
<div class="col-md-10">
    <?= Html::a('Add Student', ['create'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('<i class="fa fa-edit"></i> Bulk Update', ['bulk-update'], ['class' => 'btn btn-primary']) ?>
    <?php // Html::a('Synchronize', ['synchronize'], ['class' => 'btn btn-info']) ?>


</div>




<div class="col-md-2">
    
    <?=ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
  'filename' => 'Students_' . date('Y-m-d'),
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
</div>

<div class="box">
<div class="box-header"></div>
	<div class="box-body">    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
		['class' => 'yii\grid\SerialColumn'],
		'st_name',
		'matric_no',
		'nric',
		
		'program',
		//'is_active',
		
		['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-search"></span> VIEW',['view', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>
</div>
