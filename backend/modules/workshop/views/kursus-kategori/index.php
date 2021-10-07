<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\postgrad\models\KursusKategoriSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Training Category';
$this->params['breadcrumbs'][] = $this->title;
?>
<p>
    <?= Html::a('New Category', ['create'], ['class' => 'btn btn-success']) ?>
</p>
<div class="box">
<div class="box-header"></div>
<div class="box-body">
<div class="kursus-kategori-index">

     <?= GridView::widget([
            'dataProvider' => $dataProvider,
            // 'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'kategori_name',
                'created_at:datetime',

                ['class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 18%'],
                'template' => '{update} {delete}',
                //'visible' => false,
                'buttons'=>[
                'view'=>function ($url, $model) {
                    return Html::a('<span class="fa fa-eye"></span> Senarai Kursus',['view', 'id' => $model->id],['class'=>'btn btn-primary btn-sm']);
                },
                
                'update'=>function ($url, $model) {
                return Html::a('<span class="fa fa-edit"></span>',['update', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                },
                'delete'=>function ($url, $model) {
                    return Html::a('<span class="fa fa-trash"></span>',['delete', 'id' => $model->id],['class'=>'btn btn-danger btn-sm', 'data' => [
                    'confirm' => 'Are you sure to delete this data?'
                    ],
                    ]);
                }
                ],
                
                ],
            ],
        ]); ?>
</div>
</div>
</div>
