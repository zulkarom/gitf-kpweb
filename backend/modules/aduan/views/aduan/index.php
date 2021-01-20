<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\aduan\models\AduanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Feedback';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box">
<div class="box-header">
<div class="aduan-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Aduan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
            //'phone',
            //'topic',
            
            // 'aduan:ntext',
            //'declaration',
            //'upload_url:ntext',
            //'captcha',

            ['class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 20.7%'],
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
