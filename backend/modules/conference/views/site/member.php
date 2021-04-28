<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title= 'CONFERENCES';
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@confsite/views/myasset');
?>



<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">
							List of My Conference
							</h3>
							<p class="panel-subtitle"></p>
						</div>
						<div class="panel-body">
			
			

<div class="table-responsive"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'label' => 'Date',
				'value' => function($model){
					return $model->conferenceDateRange;
				}
				
			],
			[
				'label' => 'Conference',
				'value' => function($model){
					return Html::encode($model->conf_name . ' (' .$model->conf_abbr . ')' );
				}
				
			],
			
			[
				'label' => 'Location',
				'value' => function($model){
					return Html::encode($model->conf_venue);
				}
				
			],
            
			
            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 24%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="fa fa-pencil"></span> Update',['setting/index/', 'conf' => $model->id],['class'=>'btn btn-info btn-sm']) . ' 
						
						<a href="https://site.confvalley.com/'.$model->conf_url.'" target="_blank" class="btn btn-default btn-sm"><span class="fa fa-globe"></span> Website</a>
						';
                    },
                   
                ],
            
            ],

        ],
    ]); ?></div>
	
				</div>
</div>