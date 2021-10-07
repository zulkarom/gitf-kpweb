<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\postgrad\models\StudentPostGradSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Postgraduate Students';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-post-grad-index">

    <p>
        <?= Html::a('Add Student', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<div class="box">
<div class="box-header"></div>
<div class="box-body">  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'name',
                'label' => 'Name',
                'value' => function($model){
                    return $model->user->fullname;
                }
            ],
            'matric_no',
            'nric',
            'program_code',
            
            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-search"></span> VIEW',['view', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    }
                ],
            
            ],
        ],
    ]); ?>
</div>
</div>
</div>
</div>
