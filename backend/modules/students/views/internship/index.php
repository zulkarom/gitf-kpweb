<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\students\models\InternshipSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Internship Lists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="internship-list-index">

<p><?= Html::a('New Record', ['create'], ['class' => 'btn btn-success']) ?>
 <?= Html::a('Upload', ['upload'], ['class' => 'btn btn-info']) ?>

</p>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'matrik',
            'nric',
            'program',
         
			
			['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 20%'],
                'template' => '{update} {download}',
                //'visible' => false,
                'buttons'=>[
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-search"></span> View',['view', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },
					'download' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-download-alt"></span> Download',['download-letter', 'id' => $model->id],['class'=>'btn btn-success btn-sm', 'target' => '_blank']);
                    },
					
                ],
            
            ],
			
        ],
    ]); ?></div>
</div>

</div>
