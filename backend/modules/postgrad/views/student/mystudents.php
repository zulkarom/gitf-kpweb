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
/* @var $stats array */

$this->title = 'My Students';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-post-grad-index">

    <div class="box">
        <div class="box-header"></div>
        <div class="box-body">

            <div class="row" style="margin-bottom:10px;">
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Main Supervisor</span>
                            <span class="info-box-number"><?= (int)($stats['main_supervisor'] ?? 0) ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-user-plus"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Second Supervisor</span>
                            <span class="info-box-number"><?= (int)($stats['second_supervisor'] ?? 0) ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-flag"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Stage - Registration</span>
                            <span class="info-box-number"><?= (int)($stats['stages']['Registration'] ?? 0) ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-red"><i class="fa fa-file-text-o"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Stage - Proposal Defense</span>
                            <span class="info-box-number"><?= (int)($stats['stages']['Proposal Defense'] ?? 0) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-bottom:10px;">
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-purple"><i class="fa fa-repeat"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Stage - Re-Proposal Defense</span>
                            <span class="info-box-number"><?= (int)($stats['stages']['Re-Proposal Defense'] ?? 0) ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-navy"><i class="fa fa-graduation-cap"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Stage - Pre-Viva</span>
                            <span class="info-box-number"><?= (int)($stats['stages']['Pre-Viva'] ?? 0) ?></span>
                        </div>
                    </div>
                </div>
            </div>

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
                            $raw = (string)$model->getAttribute('student_name');
                            if ($raw === '' && $model->student && $model->student->user) {
                                $raw = (string)$model->student->user->fullname;
                            }

                            $name = strtoupper($raw);
                            return Html::a($name, ['view', 'id' => $model->student_id, 'semester_id' => $semesterId]);
                        },
                    ],
                    [
                        'attribute' => 'matric_no',
                        'label' => 'Matric',
                        'value' => function($model){
                            $matric = (string)$model->getAttribute('matric_no');
                            if ($matric === '' && $model->student) {
                                $matric = (string)$model->student->matric_no;
                            }
                            return $matric;
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
