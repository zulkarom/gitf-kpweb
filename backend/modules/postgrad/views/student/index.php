<?php

use backend\modules\esiap\models\Program;
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
            [
                'attribute' => 'program_id',
                'label' => 'Program',
                'format' => 'html',
                'filter' => Html::activeDropDownList($searchModel, 'program_id', $searchModel->listProgram(),['class'=> 'form-control','prompt' => 'Choose']),
                'value' => function($model){
                   return $model->programCode;
                }
            ],
            
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="fa fa-edit"></span>',['update', 'id' => $model->id],['class'=>'btn btn-primary btn-sm']);
                    },
                    'view'=>function ($url, $model) {
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
