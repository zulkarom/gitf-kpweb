<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\manual\models\Section */

$this->title = $model->section_name . ' - Title List' ;
$this->params['breadcrumbs'][] = ['label' => 'Module', 'url' => ['/manual/module']];
$this->params['breadcrumbs'][] = ['label' => 'Sections List', 'url' => ['module/view', 'id' => $model->module_id]];
$this->params['breadcrumbs'][] = 'Title List';
\yii\web\YiiAsset::register($this);
?>
<div class="section-view">


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
            'id',
            'module_id',
            'section_name',
        ],
    ]) ?>
    
    <p>
        <?= Html::a('Add Title', ['title/create', 'section' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title_text',

            ['class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 13%'],
                'template' => '{view} {update} {delete}',
                //'visible' => false,
                'buttons'=>[
                    'view'=>function ($url, $model) {
                    return Html::a('<span class="fa fa-search"></span>',
                        ['title/view', 'id' => $model->id], ['class'=>'btn btn-primary btn-sm']);
                    },
                    'update'=>function ($url, $model) {
                    return Html::a('<span class="fa fa-edit"></span>',
                        ['title/update', 'id' => $model->id], ['class'=>'btn btn-warning btn-sm']);
                    },
                    'delete'=>function ($url, $model) {
                    return Html::a('<span class="fa fa-trash"></span>', ['title/delete', 'id' => $model->id], [
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
    
    

</div>
