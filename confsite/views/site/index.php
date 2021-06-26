<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

$this->title= 'FKP CONFERENCE MANAGEMENT SYSTEM';

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@confsite/views/myasset');


?>
<br /><br />
<h4 class="p-b-11">
<a href="#" class="m-text24">
	LIST OF CONFERENCES								</a>
</h4>
<br />
<div class="table-responsive"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'id',
				'label' => 'Conferences',
				'format' => 'html',
				'value' => function($model){
					return '<a href="'.Url::to(['site/home', 'confurl' => $model->conf_url]).'">' . $model->conf_name . ' ('.$model->conf_abbr.')</a>';
				}
				
			],
            
            'date_start:date',


        ],
    ]); ?></div>