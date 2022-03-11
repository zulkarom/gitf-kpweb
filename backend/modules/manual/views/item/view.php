<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\manual\models\Item */

$this->title = $model->item_text;
$this->params['breadcrumbs'][] = ['label' => 'Title Page', 'url' => ['title/view', 'id' => $model->title_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="item-view">


    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          //  'id',
            'title.title_text',
            'item_text:ntext',
        ],
    ]) ?>

</div>


<?= Html::a('Add Sub Item', ['step/create', 'item' => $model->id], ['class' => 'btn btn-success']) ?>


<?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'step_text:html',

            ['class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 13%'],
                'template' => '{view} {update} {delete}',
                //'visible' => false,
                'buttons'=>[
                    'view'=>function ($url, $model) {
                    return Html::a('<span class="fa fa-search"></span>',
                        ['step/view', 'id' => $model->id], ['class'=>'btn btn-primary btn-sm']);
                    },
                    'update'=>function ($url, $model) {
                    return Html::a('<span class="fa fa-edit"></span>',
                        ['step/update', 'id' => $model->id], ['class'=>'btn btn-warning btn-sm']);
                    },
                    'delete'=>function ($url, $model) {
                    return Html::a('<span class="fa fa-trash"></span>', ['step/ delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger btn-sm',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]);
                    }
                    ],
                    
                    ],
        ],
    ]); ?>