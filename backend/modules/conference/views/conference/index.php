<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\conference\models\ConferenceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Conferences';
$this->params['breadcrumbs'][] = $this->title;
?>
    <p>
        <?php /*  echo  Html::a('Create Conference', ['create'], ['class' => 'btn btn-success'])  */  ?>
    </p>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="conference-index">




    <div class="card shadow mb-4">

            <div class="card-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
      //  'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'conf_name',
                'value' => function($model){
                    return $model->conf_name . ' ('. $model->conf_abbr .')';
                }
            ],
            
            'conferenceDateRange',
            'conf_venue',
            [
                'label' => 'Active',
                'value' => function($model){
                    return $model->is_active == 1 ? 'YES' : 'NO';
                }
            ],
            //'conf_url:url',
			
			

            ['class' => 'yii\grid\ActionColumn',
                 //'contentOptions' => ['style' => 'width: 13%'],
                'template' => '{paper} {update} {website} {delete}',
                //'visible' => false,
                'buttons'=>[
                    'paper'=>function ($url, $model) {
                        return Html::a('<span class="fa fa-file"></span> Papers',['paper/overview', 'conf' => $model->id],['class'=>'btn btn-primary btn-sm']);
                    },
                    'website'=>function ($url, $model) {
                    return Html::a('<span class="fa fa-users"></span> Participants',['register/index', 'conf' => $model->id],['class'=>'btn btn-info btn-sm']);
                    },
                    'update'=>function ($url, $model) {
                    return Html::a('<span class="fa fa-cog"></span> Config',['setting/index', 'conf' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },
                    'delete'=>function ($url, $model) {
                        return Html::a('<span class="fa fa-trash"></span>', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => 'Are you sure you want to delete this conference?',
                'method' => 'post',
            ],
        ]) 
;
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>
</div>
</div>
</div>
