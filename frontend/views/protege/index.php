<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\proceedings\models\ProceedingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Protege@UMK';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proceeding-index">

   
<section class="contact-page spad pt-0">
        <div class="container">
		
		<p>
 <h3><?= Html::encode($this->title) ?></h3>
 <br />
 <?php if($session){?>
 <b>Session:</b> <?=$session->session_name?>
 <?php 
 if($session->instruction){
    ?>
 <br/> <b>Note:</b> <?=$session->instruction?>
    <?php
 }
 ?>

 </p>
 <div class="table-responsive">
     

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
              'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' =>'List of Companies',
                'format' => 'html',
                'value' => function($model){
                    return Html::a('<b>'.$model->company->company_name . '</b>',['view', 'id' => $model->id]) . '<br /><i>'.$model->company->address . '</i>';
                }
            ],
            [
                'label' =>'Available',
                'value' => function($model){
                    return $model->availableText();
                }
            ],
            [
                'label' => 'Registered',
                'value' => function($model){
                    return $model->sumRegistered();
                }
            ],
            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 13%'],
                'template' => '{view}',
                //'visible' => false,
                'buttons'=>[

                    'view' => function ($url, $model) {
                        return Html::a('View',['view', 'id' => $model->id],['class'=>'btn btn-'.$model->buttonColor().' btn-sm']);
                    },
                    
                ],
            
            ]

        ],
    ]); 
    
}else{
    echo 'No active session';
}
    ?>
 </div>
	        </div>
    </section>

</div>
