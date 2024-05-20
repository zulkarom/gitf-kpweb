<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\protege\models\SessionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Protege Sessions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="session-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Session', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
    <div class="box-header">
    </div>
    <div class="box-body">
        <div class="table-responsive">
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Session Name',
                'format' => 'html',
                'value' => function($model){
                    return $model->session_name;
                }
            ],
            
            [
                'label' =>'Total Students',
                'value' => function($model){
                    return $model->total_student;
                }
            ],
            [
                'label' =>'Total Companies',
                'value' => function($model){
                    return count($model->companyOffers);
                }
            ],
            [
                'label' =>'Total Slot (Progress)',
                'value' => function($model){
                    if($model->total_student > 0){
                        $per = $model->sumSlotOffer() / $model->total_student;
                    $per = $per * 100;
                    $per = number_format($per,2);
                    $per = $per + 0;
                    }else{
                        $per = 0;
                    }
                    
                    return $model->sumSlotOffer() . ' ('.$per.'%)';
                }
            ],
            [
                'label' =>'Total Register (Progress)',
                'value' => function($model){
                    $reg = $model->countRegister();
                    if($model->total_student > 0){
                        $per_student = $reg / $model->total_student;
                    $per_student = $per_student * 100;
                    $per_student = number_format($per_student,2);
                    $per_student = $per_student + 0;
                    }else{
                        $per_student = 0;
                    }
                    
                    if($model->sumSlotOffer() > 0){
                        $per_slot = $reg / $model->sumSlotOffer();
                        $per_slot = $per_slot * 100;
                        $per_slot = number_format($per_slot,2);
                        $per_slot = $per_slot + 0;
                    }else{
                        $per_slot = 0;
                    }
                    
                    return $reg . ' ('.$per_student.'% /st) ('.$per_slot.'% /sl)';
                }
            ],
            [
                'label' => 'Status',
                'format' => 'html',
                'value' => function($model){
                    return $model->activeLabel;
                }
            ],
            ['class' => 'yii\grid\ActionColumn',
                           //  'contentOptions' => ['style' => 'width: 13%'],
                            'template' => '{update} {delete}',
                            //'visible' => false,
                            'buttons'=>[

                                'view'=>function ($url, $model) {
                                    return Html::a('View Companies',['/protege/company-offer/index', 'session' => $model->id],['class'=>'btn btn-primary btn-sm']);
                                },
                
                                'update'=>function ($url, $model) {
                                    return Html::a('<span class="fa fa-edit"></span> Update',['update', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                                },
                                'delete'=>function ($url, $model) {
                                    return Html::a('<span class="fa fa-trash"></span>', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger btn-sm',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this session?',
                            'method' => 'post',
                        ],
                    ]) 
            ;
                                }
                            ],
                        
                        ],
        ],
    ]); ?>
        </div>
    
    </div></div>
    
</div>
