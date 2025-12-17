<?php

use backend\modules\esiap\models\Program;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\postgrad\models\StudentPostGradSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Students Not Active';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-post-grad-index">

    <p>
        <?= Html::a('Add Student', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Statistics', ['stats'], ['class' => 'btn btn-info']) ?>
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
                'format' => 'html',
                'value' => function($model){
                   return Html::a(strtoupper($model->user->fullname),['view', 'id' => $model->id]);
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
            [
                'attribute' => 'study_mode_rc',
                'label' => 'Mode',
                'format' => 'text',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'study_mode_rc',
                    ['research' => 'Research', 'coursework' => 'Coursework'],
                    ['class'=> 'form-control','prompt' => 'Choose']
                ),
                'value' => function($model){
                   return $model->studyModeRcText;
                }
            ],
            [
                'attribute' => 'status',
                'label' => 'Status',
                'format' => 'raw',
                'filter' => Html::activeDropDownList($searchModel, 'status', $searchModel->statusList(),['class'=> 'form-control','prompt' => 'Choose']),
                'value' => function($model){
                   return $model->statusLabel;
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
