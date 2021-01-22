<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\aduan\models\AduanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Senarai Aduan';
$this->params['breadcrumbs'][] = $this->title;
?>
 <p>
        <?= Html::a('Create Aduan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<div class="box">
<div class="box-header">
<div class="aduan-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'title',
            'name',
            'nric',
            // 'address:ntext',
            'email:email',
			'created_at:date',
			'progress.progress',
            //'phone',
            //'topic',
            
            // 'aduan:ntext',
            //'declaration',
            //'upload_url:ntext',
            //'captcha',

            ['class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 10.7%'],
                'template' => '{files}',
                'buttons'=>[
                    'files'=>function ($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-th-list"></span> View', ['aduan/view', 'id' => $model->id], ['class' => 'btn btn-warning btn-sm'
                        ]) 
                ;
                    }
                   

                ],
            
            ],
        ],
    ]); ?>
</div>
</div>
</div>
