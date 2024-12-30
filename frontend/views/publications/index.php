<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\proceedings\models\ProceedingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Publications';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proceeding-index">

   
<section class="contact-page spad pt-0">
        <div class="container">
		
		<p>
 <h3><?= Html::encode($this->title) ?></h3>
 </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pager' => [
            'class' => 'yii\bootstrap4\LinkPager',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'proc_name',
            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 13%'],
                'template' => '{view}',
                //'visible' => false,
                'buttons'=>[

                    'view' => function ($url, $model) {
                        return Html::a('View Papers',['paper', 'purl' => $model->proc_url],['class'=>'btn btn-success btn-sm']);
                    },
                    
                ],
            
            ]

        ],
    ]); ?>
	        </div>
    </section>

</div>
