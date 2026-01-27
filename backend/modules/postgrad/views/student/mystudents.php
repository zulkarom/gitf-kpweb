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

<style>
    .info-box.stage-box{min-height:60px;}
    .info-box.stage-box .info-box-icon{width:50px;font-size:20px;line-height:60px;height:60px;}
    .info-box.stage-box .info-box-content{margin-left:50px;padding-top:6px;padding-bottom:6px;}
</style>

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
            </div>
            <?php ActiveForm::end(); ?>

            <?php
            $this->registerJs('jQuery(function($){$("#semester_id").on("change", function(){ $(this).closest("form").submit();});});');
            ?>

             <div class="row" style="margin-bottom:10px;">
                <div class="col-md-3">
                    <a href="<?= Html::encode(\yii\helpers\Url::to(['index', 'semester_id' => $semesterId, 'sv_role' => 1])) ?>" style="color:inherit;">
                        <div class="info-box">
                            <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Main Supervisor</span>
                                <span class="info-box-number"><?= (int)($stats['main_supervisor'] ?? 0) ?></span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= Html::encode(\yii\helpers\Url::to(['index', 'semester_id' => $semesterId, 'sv_role' => 2])) ?>" style="color:inherit;">
                        <div class="info-box">
                            <span class="info-box-icon bg-green"><i class="fa fa-user-plus"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Second Supervisor</span>
                                <span class="info-box-number"><?= (int)($stats['second_supervisor'] ?? 0) ?></span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row" style="margin-bottom:10px;">
                <div class="col-md-3">
                    <a href="<?= Html::encode(\yii\helpers\Url::to(['index', 'semester_id' => $semesterId, 'stage_id' => (int)($stageNameToId['Registration'] ?? 0)])) ?>" style="color:inherit;">
                        <div class="info-box stage-box">
                            <span class="info-box-icon bg-yellow"><i class="fa fa-flag"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Stage - Registration</span>
                                <span class="info-box-number"><?= (int)($stats['stages']['Registration'] ?? 0) ?></span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= Html::encode(\yii\helpers\Url::to(['index', 'semester_id' => $semesterId, 'stage_id' => (int)($stageNameToId['Proposal Defense'] ?? 0)])) ?>" style="color:inherit;">
                        <div class="info-box stage-box">
                            <span class="info-box-icon bg-red"><i class="fa fa-file-text-o"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Stage - Proposal Defense</span>
                                <span class="info-box-number"><?= (int)($stats['stages']['Proposal Defense'] ?? 0) ?></span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= Html::encode(\yii\helpers\Url::to(['index', 'semester_id' => $semesterId, 'stage_id' => (int)($stageNameToId['Re-Proposal Defense'] ?? 0)])) ?>" style="color:inherit;">
                        <div class="info-box stage-box">
                            <span class="info-box-icon bg-purple"><i class="fa fa-repeat"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Stage - Re-Proposal Defense</span>
                                <span class="info-box-number"><?= (int)($stats['stages']['Re-Proposal Defense'] ?? 0) ?></span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="<?= Html::encode(\yii\helpers\Url::to(['index', 'semester_id' => $semesterId, 'stage_id' => (int)($stageNameToId['Pre-Viva'] ?? 0)])) ?>" style="color:inherit;">
                        <div class="info-box stage-box">
                            <span class="info-box-icon bg-navy"><i class="fa fa-graduation-cap"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Stage - Pre-Viva</span>
                                <span class="info-box-number"><?= (int)($stats['stages']['Pre-Viva'] ?? 0) ?></span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

    <div class="box">
        <div class="box-header"></div>
        <div class="box-body">
           

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
                            $raw = (string)$model->student_name;
                            if ($raw === '' && $model->student && $model->student->user) {
                                $raw = (string)$model->student->user->fullname;
                            }

                            $name = strtoupper($raw);
                            $matric = (string)$model->matric_no;
                            if ($matric === '' && $model->student) {
                                $matric = (string)$model->student->matric_no;
                            }

                            $label = $matric . ' - ' . $name;
                            return Html::a($label, ['view', 'id' => $model->student_id]);
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
                            $stage = (string)$model->stage_name;
                            return $stage !== '' ? $stage : '-';
                        },
                    ],
                    [
                        'attribute' => 'status_daftar',
                        'label' => 'Status Daftar',
                        'format' => 'raw',
                        'value' => function($model){
                            return StudentRegister::statusDaftarLabel($model->status_daftar);
                        },
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
