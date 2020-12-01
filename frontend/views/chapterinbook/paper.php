<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\proceedings\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Html::encode($proceeding->chap_name);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paper-index">

 <section class="contact-page spad pt-0">
        <div class="container">
		<div align="center">
		<p><h3><?= Html::encode($proceeding->chap_name) ?></h3></p>
   
   <?php 
   if($proceeding->image_file){
	   ?>
	    <img width="50%" src="<?=Url::to(['download-image', 'purl' => $proceeding->chap_url])?>" />
	   <?php
   }
   
   ?>
  
		
		</div>
		<br />
   

    <div class="table-responsive"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
			[
				'attribute' => 'paper_no',
				'label' => '#',
				'value' => function($model){
					return $model->paper_no == 0 ? 'i.' : $model->paper_no . '.';
					
				}
				
			],
			
			[
				'attribute' => 'paper_title',
				'format' => 'html',
				'label' => 'TITLE',
				'value' => function($model){
					return '<b>' . $model->paper_title . '</b><br /><i>' .
					$model->author . '</i>'
					;
				}
				
			],
            
            [
				'attribute' => 'paper_page',
				'label' => 'PAGES',
				
			],
            
            
            //'paper_url:ntext',

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 13%'],
                'template' => '{view}',
                //'visible' => false,
                'buttons'=>[

                    'view' => function ($url, $model) {
						$text = $model->paper_no == 0 ? 'VIEW' : 'FULL PAPER';
                        return Html::a('<span class="fa fa-download"></span> ' . $text ,['download-file', 'id' => $model->id],['class'=>'btn btn-primary btn-sm', 'target' => '_blank']);
                    },
                    
                ],
            
            ]

        ],
    ]); ?></div></div>
    </section>
</div>
