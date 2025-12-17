<?php

use backend\modules\esiap\models\Program;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use common\models\Country;
use yii\helpers\ArrayHelper;
use backend\modules\postgrad\models\Student;
use backend\modules\postgrad\models\StudentRegister;
use backend\models\Semester;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\postgrad\models\StudentPostGradSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = isset($title) ? $title : 'Postgraduate Students';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-post-grad-index">

    <p>
        <?= Html::a('Add Student', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Statistics', ['stats', 'semester_id' => $searchModel->semester_id], ['class' => 'btn btn-info']) ?>
    </p>

    <?php
        $semesterOptions = ArrayHelper::map(
            Semester::find()->orderBy(['id' => SORT_DESC])->all(),
            'id',
            function($s){ return $s->longFormat(); }
        );
    ?>

    <div class="box box-default">
        <div class="box-body">
            <?php $form = ActiveForm::begin(['method' => 'get', 'action' => ['index']]); ?>
            <div class="row">
                <div class="col-md-6">
                    <?= Html::label('Semester', 'semester_id', ['class' => 'control-label']) ?>
                    <?= Html::dropDownList('semester_id', $searchModel->semester_id, $semesterOptions, ['class' => 'form-control', 'prompt' => 'Choose', 'id' => 'semester_id']) ?>
                </div>
                <div class="col-md-6" style="padding-top:25px">
                    <?= Html::submitButton('Filter', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

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
                'label' => 'Student',
                'format' => 'html',
                'value' => function($model){
                   $name = strtoupper($model->user->fullname);
                   $matric = $model->matric_no;
                   $nric = $model->nric;
                   $line2 = trim($matric . ' | ' . $nric, " | ");
                   return Html::a($name, ['view', 'id' => $model->id, 'semester_id' => $this->context->request->get('semester_id')]) . '<br />' . Html::encode($line2);
                }
            ],
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
                'attribute' => 'status_daftar',
                'label' => 'Status Daftar',
                'format' => 'raw',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status_daftar',
                    StudentRegister::statusDaftarList(),
                    ['class'=> 'form-control','prompt' => 'Choose']
                ),
                'value' => function($model){
                   return StudentRegister::statusDaftarLabel($model->status_daftar);
                }
            ],

            [
                'attribute' => 'status_aktif',
                'label' => 'Status Aktif',
                'format' => 'raw',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'status_aktif',
                    StudentRegister::statusAktifList(),
                    ['class'=> 'form-control','prompt' => 'Choose']
                ),
                'value' => function($model){
                   return StudentRegister::statusAktifLabel($model->status_aktif);
                }
            ],
            
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
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
