<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\protege\models\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Companies Database';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-index">

    <p>
        <?= Html::a('Create Company', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <div class="box">
    <div class="box-header">
    </div>
    <div class="box-body">
    <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'company_name',
            'address',
            [
                'format' => 'html',
                'attribute' => 'status',
                'filter' => Html::activeDropDownList($searchModel, 'status', $searchModel->statusArray,['class'=> 'form-control','prompt' => 'Pilih Status']),
                'label' => 'Status',
                'value' => function($model){
                    return $model->statusLabel;
                }
            ],
            //'description:ntext',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn',
                            'template' => '{update} {delete}',
                            //'visible' => false,
                            'buttons'=>[

                                'update'=>function ($url, $model) {
                                    return Html::a('<span class="fa fa-edit"></span> Update',['update', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                                },
                                'delete'=>function ($url, $model) {
                                    return Html::a('<span class="fa fa-trash"></span>', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger btn-sm',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this data?',
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
