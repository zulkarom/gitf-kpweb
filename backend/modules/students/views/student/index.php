<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\students\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Students';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-index">

    <p>
        <?= Html::a('Create Student', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<div class="box">
<div class="box-header"></div>
	<div class="box-body">    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
		['class' => 'yii\grid\SerialColumn'],
		'st_name',
		'matric_no',
		'nric',
		
		'program',
		//'is_active',
		
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
    ]); ?></div>
</div>
</div>
