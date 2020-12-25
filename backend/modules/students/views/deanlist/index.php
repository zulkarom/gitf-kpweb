<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\students\models\DeanListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dean Lists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dean-list-index">
    <p>
        <?= Html::a('Create Dean List', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	
	<div class="row">

        <div class="col-md-10" align="right">

<?= $this->render('_semester_search', [
        'model' => $semester,
    ]) ?>
</div>
</div>

  <div class="box">
<div class="box-header"></div>
<div class="box-body">  <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'semester_id',
			'matric_no',
			[
				'attribute' => 'name',
				'label' => 'Name',
				'value' => function($model){
					return $model->student->st_name;
				}
				
			],
			[
				'attribute' => 'nric',
				'label' => 'NRIC',
				'value' => function($model){
					return $model->student->nric;
				}
				
			],
			'created_at:date',

			['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 18%'],
                'template' => '{update} {download}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('VIEW',['view', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },
					'download' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-download-alt"></span> Download',['download-file', 'id' => $model->id],['class'=>'btn btn-success btn-sm', 'target' => '_blank']);
                    },
					
                ],
            
            ],
        ],
    ]); ?></div>
</div>

</div>
