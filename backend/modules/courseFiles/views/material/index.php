<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\courseFiles\models\MaterialSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Teaching Materials';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-index">


    <p>
        <?= Html::a('Create Material Group', ['create', 'course' => $course->id], ['class' => 'btn btn-success']) ?>
    </p>
<h4><?=$course->course_code . ' ' . $course->course_name?></h4>
<div class="box">
<div class="box-header"></div>
<div class="box-body">    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        ///'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'material_name',
            'createdBy.fullname',
            'created_at',
			
			['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 10%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-search"></span> View Materials',['view', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },
					
                ],
            
            ],

        ],
    ]); ?></div>
</div>

</div>
