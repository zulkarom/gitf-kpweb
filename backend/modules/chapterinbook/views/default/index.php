<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\proceedings\models\ProceedingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Chapter in Book';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proceeding-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Chapter in Book', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            'chap_name',
            'date_start',
            'date_end',
            

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 13%'],
                'template' => '{view} {update} {delete}',
                //'visible' => false,
                'buttons'=>[
                    'update' => function ($url, $model) {
                        return Html::a('<span class="fa fa-edit"></span>',['update', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },
                    'view' => function ($url, $model) {
                        return Html::a('Papers',['paper/index', 'proc' => $model->id],['class'=>'btn btn-success btn-sm']);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="fa fa-trash"></span>', ['delete-article', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this manuscript?',
                                'method' => 'post',
                            ],
                        ]) ;
                    }
                ],
            
            ]

        ],
    ]); ?>
</div>
