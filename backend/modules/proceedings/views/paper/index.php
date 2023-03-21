<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\proceedings\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Papers';
$this->params['breadcrumbs'][] = ['label' => 'Proceedings', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="paper-index">

    <p>
        <?= Html::a('Create Paper', ['create', 'proc' => $proc], ['class' => 'btn btn-success']) ?>
    </p>

  <div class="box">
    <div class="box-header">
    </div>      
<div class="box-body">

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'paper_no',
            'paper_title',
			[
				'attribute' => 'author',
				'label' => 'Authors',
				'format' => 'html'
				
			],
            
            
            //'paper_page',
            //'paper_url:ntext',

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 13%'],
                'template' => '{view} {update} {delete}',
                //'visible' => false,
                'buttons'=>[
                    'update' => function ($url, $model) {
                        return Html::a('<span class="fa fa-edit"></span>',['update', 'id' => $model->id, 'proc' => $model -> proc_id],['class'=>'btn btn-warning btn-sm']);
                    },
                    'view' => function ($url, $model) {
                        return Html::a('<span class="fa fa-eye"></span>',['view', 'id' => $model->id, 'proc' => $model -> proc_id],['class'=>'btn btn-success btn-sm']);
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
    </div>


</div>
