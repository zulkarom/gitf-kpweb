<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\downloads\models\DownloadCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Download Categories';
$this->params['breadcrumbs'][] = ['label' => 'Downloads', 'url' => ['/students/download/index']];
$this->params['breadcrumbs'][] = 'Categories';
?>
<div class="download-category-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
	<?= Html::a('Download List', ['/downloads/download'], ['class' => 'btn btn-info']) ?>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
<div class="box-header"></div>
	<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
		['class' => 'yii\grid\SerialColumn'],
		
		'category_name',
		[
			'attribute' => 'is_default',
			'value' => 'showDefault',
		],
		
		[
			'attribute' => 'is_active',
			'value' => 'showActive',
		],
		
		'created_at:date',
		
		['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 10%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> Update',['update', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },

                ],
            
            ],
        ],
    ]); ?></div>
	</div>
</div>
