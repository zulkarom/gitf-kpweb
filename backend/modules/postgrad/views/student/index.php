<?php

use backend\modules\esiap\models\Program;
use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Country;
use yii\helpers\ArrayHelper;
use backend\modules\postgrad\models\Student;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\postgrad\models\StudentPostGradSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $title;
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
    <?php
    // Build country options from distinct countries present in pg_student
    $countryIds = (new \yii\db\Query())
        ->select('nationality')
        ->from(Student::tableName())
        ->where(['not', ['nationality' => null]])
        ->andWhere(['<>', 'nationality', 0])
        ->groupBy('nationality')
        ->column();
    $countryOptions = [];
    if ($countryIds) {
        $countryOptions = ArrayHelper::map(
            Country::find()->where(['id' => $countryIds])->orderBy('country_name')->all(),
            'id',
            'country_name'
        );
    }
    ?>
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
                'attribute' => 'nationality',
                'label' => 'Country',
                'format' => 'text',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'nationality',
                    $countryOptions,
                    ['class'=> 'form-control','prompt' => 'Choose']
                ),
                'value' => function($model){
                   return $model->country ? $model->country->country_name : '';
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
