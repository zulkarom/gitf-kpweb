<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\postgrad\models\SupervisorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Supervisors / Examiners List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supervisor-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Add Supervisor / Examiner', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


 <div class="box">
<div class="box-header"></div>
<div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'svName',
            [
                'attribute' => 'is_internal',
                'filter' => Html::activeDropDownList($searchModel, 'is_internal', $searchModel->listType(),['class'=> 'form-control','prompt' => 'Choose']),
                'value' => function($model){
                    return $model->typeName;
                
                
                }
                
                ],
                'svFieldsString',
                

            ['class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 13%'],
                'template' => '{view} {delete}',
                //'visible' => false,
                'buttons'=>[
                    'view'=>function ($url, $model) {
                    return Html::a('View',['view', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
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
</div>

</div>
