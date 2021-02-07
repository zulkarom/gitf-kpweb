<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\students\models\DeanListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student File Downloads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dean-list-index">
    <p>
       
		 <?= Html::a('Upload Files', ['upload'], ['class' => 'btn btn-info']) ?>
		 
		 
		 <?= Html::a('Categories', ['/students/download-category'], ['class' => 'btn btn-warning']) ?>
    </p>
	
	<div class="row">

        <div class="col-md-10" align="right">

<?= $this->render('_category_search', [
        'model' => $category,
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
                        return Html::a('<span class="glyphicon glyphicon-search"></span> VIEW',['view', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
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
