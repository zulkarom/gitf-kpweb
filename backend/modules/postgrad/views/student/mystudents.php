<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use backend\models\Semester;
use backend\modules\postgrad\models\StudentSupervisor;
use backend\modules\postgrad\models\StudentRegister;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $semesterId int */

$this->title = 'My Students';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-post-grad-index">

    <div class="box">
        <div class="box-header"></div>
        <div class="box-body">

            <?php $form = ActiveForm::begin(['method' => 'get', 'action' => ['index']]); ?>
            <div class="row" style="margin-bottom:10px;">
                <div class="col-md-6">
                    <?= Html::label('Semester', 'semester_id', ['class' => 'control-label']) ?>
                    <?= Html::dropDownList(
                        'semester_id',
                        $semesterId,
                        Semester::listSemesterArray(),
                        ['class' => 'form-control', 'prompt' => 'Choose', 'id' => 'semester_id']
                    ) ?>
                </div>
                <div class="col-md-6" style="padding-top:25px">
                    <?= Html::submitButton('Filter', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => null,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'student_name',
                        'label' => 'Student Name',
                        'format' => 'raw',
                        'value' => function($model) use ($semesterId){
                            $name = strtoupper((string)$model->getAttribute('student_name'));
                            return Html::a($name, ['view', 'id' => $model->student_id, 'semester_id' => $semesterId]);
                        },
                    ],
                    [
                        'attribute' => 'matric_no',
                        'label' => 'Matric',
                        'value' => function($model){
                            return (string)$model->getAttribute('matric_no');
                        },
                    ],
                    [
                        'attribute' => 'sv_role',
                        'label' => 'Role',
                        'value' => function($model){
                            return $model->roleName();
                        },
                    ],
                    [
                        'attribute' => 'stage_name',
                        'label' => 'Research Stage',
                        'value' => function($model){
                            $stage = (string)$model->getAttribute('stage_name');
                            return $stage !== '' ? $stage : '-';
                        },
                    ],
                    [
                        'attribute' => 'status_daftar',
                        'label' => 'Status Daftar',
                        'format' => 'raw',
                        'value' => function($model){
                            return StudentRegister::statusDaftarLabel($model->getAttribute('status_daftar'));
                        },
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
