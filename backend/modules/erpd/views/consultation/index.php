<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\erpd\models\ConsultationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Consultations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consultation-index">


    <p>
        <?= Html::a('New Consultation', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

   <div class="box">
<div class="box-header"></div>
<div class="box-body"> <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'csl_title',
            [
				'attribute' => 'csl_funder',
				'label'  => 'Funder'
			],
            //'csl_amount',
            [
				'attribute' => 'csl_level',
				'value' => function($model){
					return $model->levelName;
				}
			],
            //'date_start',
            //'date_end',
            //'csl_file',

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> UPDATE',['consultation/update/', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>

</div>
