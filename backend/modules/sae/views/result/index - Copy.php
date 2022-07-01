<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use yii\bootstrap4\Modal;
use kartik\export\ExportMenu;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ResultSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'View All Result';
$this->params['breadcrumbs'][] = $this->title;

$columns = [
          
            ['class' => 'yii\grid\SerialColumn'],
            [
                'format' => 'raw',
                'label' => 'Full Name(NRIC)',
                'value' => function($model){
                    return $model->can_name.'<br/>('.$model->username.')';
                }
            ],
            [
                'format' => 'raw',
                'label' => 'Batch',
                'value' => function($model){
                    return $model->batch->bat_text;
                }
            ],
            [
                'format' => 'raw',
                'attribute' => 'status',
                'value' => function($model){
                    return $model->statusText;
                }
            ],
            [
                'format' => 'raw',
                'attribute' => 'finished_at',
                'value' => function($model){
                    if($model->finished_at){
                        return date('d M Y h:i:s', $model->finished_at);
                    }
                    else{
                        return "-";
                    }
                }
            ],   
            'c1',
            'c2',
            'c3',
            'c4',
            'c5',
            'c6', 
            [   
                'format' => 'raw',
                'label' => 'Total',
                'value' => function($model){
                    return ($model->c1+$model->c2+$model->c3+$model->c4+$model->c5+$model->c6);
                }
            ], 

        ];
?>

<div class="result-index">

    <div class="row">

        <div class="col-md-8">
            <?= $this->render('_form_search', [
                'model' => $searchModel,
            ]) ?>
        </div>

        <div class="col-md-4">

            <?=
            ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $columns,
            'columnSelectorOptions'=>[
                'label' => 'Columns',
                'class' => 'btn btn-danger',
                'style'=> 'display:none;', 
            ],
            'fontAwesome' => true,
            'dropdownOptions' => [
                'label' => 'DOWNLOAD RESULT',
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
                // ExportMenu::FORMAT_EXCEL => [
                //     'label' => 'EXCEL',
                //     'icon' => 'floppy-remove',
                //     'iconOptions' => ['class' => 'text-success'],
                //     'linkOptions' => [],
                //     'options' => ['title' => 'PDF'],
                //     'alertMsg' => 'The EXCEL 95+ (xls) export file will be generated for download.',
                //     'mime' => 'application/vnd.ms-excel',
                //     'extension' => 'xls',
                //     'writer' => ExportMenu::FORMAT_EXCEL
                // ],

                // ExportMenu::FORMAT_PDF => [
                //     'label' => 'PDF',
                //     'icon' => 'file-pdf-o',
                //     'iconOptions' => ['class' => 'text-danger'],
                //     'linkOptions' => [],
                //     'options' => ['title' => 'Portable Document Format'],
                //     'alertMsg' => 'The PDF export file will be generated for download.',
                //     'mime' => 'application/pdf',
                //     'extension' => 'pdf',
                //     'writer' => ExportMenu::FORMAT_PDF
                // ],
            ],
        ]);



        ?>   


        </div>
    </div>

    

    <div class="card card-primary card-outline">
        <div class="card-body">
            <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                // 'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'format' => 'html',
                        'attribute' => 'others',
                        'label' => 'Full Name(NRIC)',
                        'value' => function($model){
                            return $model->can_name.'<br/>('.$model->username.')';
                        }
                    ],
                    [
                        'format' => 'html',
                        'label' => 'Batch',
                        'value' => function($model){
                            return $model->batch->bat_text;
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function($model){
                            return $model->statusText;
                        }
                    ],
                    [
                        'attribute' => 'finished_at',
                        'value' => function($model){
                            if($model->finished_at){
                                return date('d M Y h:i:s', $model->finished_at);
                            }
                            else{
                                return "-";
                            }
                        }
                    ],   
                    'c1',
                    'c2',
                    'c3',
                    'c4',
                    'c5',
                    'c6', 
                    [   
                        'label' => 'Total',
                        'value' => function($model){
                            return ($model->c1+$model->c2+$model->c3+$model->c4+$model->c5+$model->c6);
                        }
                    ], 

                    ['class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'width: 10%'],
                        'template' => '{view} {pdf}',
                        //'visible' => false,
                        'buttons'=>[
                            'view'=>function ($url, $model) {
                                return Html::a('<span class="fa fa-eye"></span> VIEW',['individual-result', 'id' => $model->id],['class'=>'btn btn-info btn-sm']);
                            },
                            'pdf'=>function ($url, $model) {
                                return Html::a('<span class="fa fa-download"></span> PDF',['individual-pdf', 'id' => $model->id],['class'=>'btn btn-danger btn-sm', 'target' => '_blank']);
                            }
                        ],
                    
                    ],            

                ],
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
