<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\export\ExportMenu;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AnswerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Participants';

$this->params['breadcrumbs'][] = $this->title;

$columns = [
          
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'NAME',
                'contentOptions' => ['cellFormat' => DataType::TYPE_STRING], 
                'value' => function($model){
                    if($model->candidate){
                        return strtoupper($model->candidate->can_name);
                    }
                    
                }
            ],
            [
                'label' => 'NRIC',
                'contentOptions' => ['cellFormat' => DataType::TYPE_STRING], 
                'value' => function($model){
                    if($model->candidate){
                        return $model->candidate->username;
                    }
                    
                }
            ],
            [
                'label' => 'Batch',
                'value' => function($model){
                    return $model->batch->bat_text;
                }
            ],
            [
                'attribute' => 'status',
                'value' => function($model){
                    return strtoupper($model->statusText);
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
        ];
?>

<div class="result-index">

    <div class="row">

        <div class="col-md-9">
            <?= $this->render('_form_search', [
                'model' => $searchModel,
            ]) ?>
        </div>

        <div class="col-md-2">
            <?= Html::a('OVERALL RESULT', ['result/index', "bat_id" => $searchModel->bat_id, 'type' => 1], ['class' => 'btn btn-info btn-block']) ?>
        </div>
        <div class="col-md-1">
        <div style="display:none">
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
                'label' => 'DOWNLOAD',
                'class' => 'btn btn-danger',
                'style'=> 'color:white;',
            ],
            'filename' => 'ALL PARTICIPANTS',
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
        <div class="form-group"> <button class="btn btn-success btn-block" id="dwl-exl"><i class="fa fa-download"></i> Excel</button></div>
        <?php 
     $this->registerJs('
            $("#dwl-exl").click(function(){
                $("#w0-xls")[0].click();
            });
     ');
     ?>
        </div>
    </div>

    

    <div class="box">
        <div class="box-body">
            <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'others',
                        'label' => 'Name',
                        'value' => function($model){
                        if($model->candidate){
                            return $model->candidate->can_name;
                        }
                            
                        }
                    ],
					[
                        'label' => 'NRIC',
                        'value' => function($model){
                        if($model->candidate){
                            return $model->candidate->username;
                        }
                            
                        }
                    ],
                    [
                        'format' => 'html',
                        'label' => 'Batch',
                        'value' => function($model){
                            if($model->batch){
                                return $model->batch->bat_text;
                            }
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'html',
                        'value' => function($model){
                            return $model->statusLabel;
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

                    ['class' => 'yii\grid\ActionColumn',
          
                        'template' => '{view} {pdf}',
                        //'visible' => false,
                        'buttons'=>[
                            'view'=>function ($url, $model) use ($batch){
                                return Html::a('<span class="fa fa-eye"></span> VIEW',['result/individual-result', 'id' => $model->can_id, 'batch_id' => $batch->id],['class'=>'btn btn-info btn-sm']);
                            },
                            'pdf'=>function ($url, $model) use ($batch){
                                if($model->overall_status == 3){
                                    return Html::a('<span class="fa fa-download"></span> PDF',['/sae/result/individual-pdf', 'id' => $model->id],['class'=>'btn btn-danger btn-sm', 'target' => '_blank']);
                                }
                                
                            }
                        ],
                    
                    ],            

                ],
            ]); ?>
        </div>
        </div>
    </div>
</div>


