<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Front Sliders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="front-slider-index">


    <p>
        <?= Html::a('New Slide', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'slide_name',
			[
				'label' => 'Slide',
				'format' => 'html',
				'value' => function($model){
					return '<img src="'.Url::to(['/website/front-slider/download-file', 'attr' => 'image','id' => $model->id]).'" width="100px" />';
				}
			],
            'slide_order',
            
['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 13%'],
                'template' => '{update} {delete}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> Update',['/website/front-slider/update', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },
                    'delete'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span> Delete', ['/website/front-slider/delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => 'Are you sure you want to delete this slide?',
                'method' => 'post',
            ],
        ]) 
;
                    }
                ],
            
            ],


        ],
    ]); ?></div>
</div>

</div>
