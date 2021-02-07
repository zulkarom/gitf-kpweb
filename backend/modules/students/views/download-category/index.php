<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\students\models\DownloadCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Download Categories';
$this->params['breadcrumbs'][] = ['label' => 'Downloads', 'url' => ['/students/download/index']];
$this->params['breadcrumbs'][] = 'Categories';
?>
<div class="download-category-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
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
		
		'created_at:date',
		
		['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?></div>
	</div>
</div>
