<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\postgrad\models\ExternalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Externals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="external-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Add External', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
     <div class="box">
<div class="box-header"></div>
<div class="box-body">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'ex_name',
            'universityName',
            [
                'attribute' => 'svFieldsString',
                'label' => 'Field',
                'value' => function($model){
                    return $model->svFieldsString;
                },
            ],


            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 13%'],
                'template' => '{update} {delete}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="fa fa-edit"></span>', 
                            ['update', 'id' => $model->id], ['class'=>'btn btn-warning btn-sm']);
                    },
                    'delete'=>function ($url, $model) {
                        return Html::a('<span class="fa fa-trash"></span>', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this data?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                ],
            
            ],
        ],
    ]); ?>

</div>
</div>


</div>
