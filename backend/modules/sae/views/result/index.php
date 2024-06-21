<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use yii\bootstrap4\Modal;
use kartik\export\ExportMenu;
use yii\grid\GridView;
use yii\helpers\Url;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ResultSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Overall Result - ' . $batch->bat_text;
$this->params['breadcrumbs'][] = ['label' => 'Participants', 'url' => ['answer/index']];
$this->params['breadcrumbs'][] = 'Overall Result';

$col1[] = array();
$col2[] = array();
$col3[] = array();
$col4[] = array();
$col5[] = array();
$col6[] = array();

 $grid_columns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'others',
                        'label' => 'NAME',
                        'contentOptions' => ['cellFormat' => DataType::TYPE_STRING], 
                        'value' => function($model){
                            return $model->can_name;
                        }
                    ],
					
					[
                        'attribute' => 'others',
                        'label' => 'NRIC',
						'contentOptions' => ['cellFormat' => DataType::TYPE_STRING], 
                        'value' => function($model){
                            return $model->username;
                        }
                    ],
                    
                                                   

                ];
                foreach($domains as $domain){
                    if($domain->grade_cat)
                    {
						if($domain->grade_cat == 99){
							$grid_columns[] = 'total';
							
						}else{
							$grid_columns[] = 'c'.$domain->grade_cat;
						}
                        
                    }
                }
                foreach($demos as $demo){
                    if($demo->column_id == 1)
                    {
                        $grid_columns[] =[  
                            'label' => $batch->column1,
                            'value' => function($model){
                                return $model->column1;
                            }
                        ];
                    }else if($demo->column_id == 2)
                    {
                        $grid_columns[] =[  
                            'label' => $batch->column2,
                            'value' => function($model){
                                return $model->column2;
                            }
                        ];
                    }else if($demo->column_id == 3)
                    {
                        $grid_columns[] =[  
                            'label' => $batch->column3,
                            'value' => function($model){
                                return $model->column3;
                            }
                        ];
                    }else if($demo->column_id == 4)
                    {
                        $grid_columns[] =[  
                            'label' => $batch->column4,
                            'value' => function($model){
                                return $model->column4;
                            }
                        ];
                    }
                }
?>

<div class="result-index">

    <div class="row">

        <div class="col-md-6">
            <?= $this->render('_form_search', [
                'model' => $searchModel,
            ]) ?>
        </div>
		<?php
        /* <div class="col-md-2">
		<div class="form-group"><?= Html::a('ANALYSE', ['/result/analysis', "id" => $searchModel->bat_id], ['class' => 'btn btn-info btn-block']) ?></div>
		</div>
		
		<div class="col-md-1">
		<div class="form-group"><?= Html::a('RESET', ['/result/analysis', "id" => $searchModel->bat_id, 'reset' => 1, 'redirect' => 1], ['class' => 'btn btn-warning btn-block']) ?></div>
		</div> */
        ?>
		

        <div class="col-md-2">
<div style="display:none">
            <?=
            ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $grid_columns,
            'columnSelectorOptions'=>[
                'label' => 'Columns',
                'class' => 'btn btn-danger',
                'style'=> 'display:none;', 
            ],
            'fontAwesome' => true,
            'dropdownOptions' => [
                'label' => 'DOWNLOAD',
                'class' => 'btn btn-danger',
                'style'=> 'color:white;',
            ],
            'filename' => 'ALL RESULT' . date('Y-m-d'),
            'clearBuffers' => true,
            'onRenderSheet'=>function($sheet, $grid){
                $sheet->getStyle('A2:'.$sheet->getHighestColumn().$sheet->getHighestRow())
                ->getAlignment()->setWrapText(true);
            },
            'exportConfig' => [
                ExportMenu::FORMAT_EXCEL_X => false,
                ExportMenu::FORMAT_HTML => false,
                ExportMenu::FORMAT_CSV => false,
                ExportMenu::FORMAT_TEXT => false,
            ],
        ]);
        ?>   </div>
		
		    <div class="form-group"> <button class="btn btn-success btn-block" id="dwl-exl"><i class="fa fa-download"></i> EXCEL</button></div>
<?php 
     $this->registerJs('
            $("#dwl-exl").click(function(){
                $("#w0-xls")[0].click();
            });
     ');
     ?>


        

        </div>
		
    </div>

<?php

$grid_columns = [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'format' => 'html',
                        'attribute' => 'others',
                        'label' => 'Name / NRIC',
                        'value' => function($model){
                            return $model->can_name.'<br/>('.$model->username.')';
                        }
                    ],
                    
                                                   

                ];
                foreach($domains as $domain){
                    if($domain->grade_cat)
                    {
						if($domain->grade_cat == 99){
							$grid_columns[] = 'total';
							
						}else{
							$grid_columns[] = 'c'.$domain->grade_cat;
						}
                        
                    }
                }
                foreach($demos as $demo){
                    if($demo->column_id == 1)
                    {
                        $grid_columns[] =[  
                            'label' => $batch->column1,
                            'value' => function($model){
                                return $model->column1;
                            }
                        ];
                    }else if($demo->column_id == 2)
                    {
                        $grid_columns[] =[  
                            'label' => $batch->column2,
                            'value' => function($model){
                                return $model->column2;
                            }
                        ];
                    }else if($demo->column_id == 3)
                    {
                        $grid_columns[] =[  
                            'label' => $batch->column3,
                            'value' => function($model){
                                return $model->column3;
                            }
                        ];
                    }else if($demo->column_id == 4)
                    {
                        $grid_columns[] =[  
                            'label' => $batch->column4,
                            'value' => function($model){
                                return $model->column4;
                            }
                        ];
                    }
                }
                $grid_columns[] = ['class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'width: 15%'],
                    'template' => '{view} {pdf}',
                    //'visible' => false,
                    'buttons'=>[
                        'view'=>function ($url, $model) use ($batch) {
                            return Html::a('<span class="fa fa-eye"></span> VIEW',['individual-result', 'id' => $model->id, 'batch_id' => $batch->id],['class'=>'btn btn-info btn-sm']);
                        },
                        'pdf'=>function ($url, $model) use ($batch){
                            return Html::a('<span class="fa fa-download"></span> PDF',['individual-pdf', 'id' => $model->id,  'batch_id' => $batch->id],['class'=>'btn btn-danger btn-sm', 'target' => '_blank']);
                        }
                    ],
                
                ];
                
                
?>


    <div class="box">
        <div class="box-body">
            <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
				
                // 'filterModel' => $searchModel,
                'pager' => [
                    'class' => 'yii\bootstrap4\LinkPager',
                ],
                'columns' => $grid_columns
            ]); ?>
        </div>
        </div>
    </div>
</div>

<?php

$js = '

$(document).ready(function(){
    changePdfId();
});

function changePdfId()
{
    $("#w0-pdf").attr("id", "ovrw-pdf");
    $("#ovrw-pdf").data("format",null);
}

$(".export-full-pdf").click(function(){
    var x = document.getElementById("ovrw-pdf");
    x.href = "'.Url::to(['result-pdf', 'id' => Yii::$app->user->identity->id]).'"
});


';
$this->registerJs($js);
?>
