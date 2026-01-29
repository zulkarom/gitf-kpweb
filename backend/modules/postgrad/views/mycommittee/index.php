<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use backend\models\Semester;
use backend\modules\postgrad\models\StudentStage;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $semesterId int */
/* @var $stats array */

$this->title = 'My Examination Committee';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="mycommittee-index">

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
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Chairman</span>
                    <span class="info-box-number"><?= (int)($stats['chairman'] ?? 0) ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">D. Chairman</span>
                    <span class="info-box-number"><?= (int)($stats['deputy'] ?? 0) ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Examiner 1</span>
                    <span class="info-box-number"><?= (int)($stats['examiner1'] ?? 0) ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Examiner 2</span>
                    <span class="info-box-number"><?= (int)($stats['examiner2'] ?? 0) ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="info-box">
                <?php
                    $traffic = (string)($stats['total_color'] ?? 'red');
                    $circleColor = '#d9534f';
                    if ($traffic === 'green') {
                        $circleColor = '#5cb85c';
                    } elseif ($traffic === 'yellow') {
                        $circleColor = '#f0ad4e';
                    }
                ?>
                <span class="info-box-icon bg-gray"><i class="fa fa-circle" style="color:<?= Html::encode($circleColor) ?>;"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total</span>
                    <span class="info-box-number"><?= (int)($stats['total'] ?? 0) ?></span>
                </div>
            </div>
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
                        'label' => 'Name',
                        'value' => function($row) {
                            $name = strtoupper((string)($row['student_name'] ?? ''));
                            $matric = (string)($row['matric_no'] ?? '');
                            $label = trim($matric) !== '' ? ($matric . ' - ' . $name) : $name;
                            return $label;
                        },
                    ],
                    [
                        'attribute' => 'stage_name_en',
                        'label' => 'Stage',
                        'value' => function($row) {
                            $en = (string)($row['stage_name_en'] ?? '');
                            $bm = (string)($row['stage_name'] ?? '');
                            return $en !== '' ? $en : $bm;
                        },
                    ],
                    [
                        'attribute' => 'committee_role_label',
                        'label' => 'Committee Role',
                        'value' => function($row) {
                            return (string)($row['committee_role_label'] ?? '');
                        },
                    ],
                    [
                        'attribute' => 'appoint_date',
                        'label' => 'Date',
                        'value' => function($row) {
                            $d = (string)($row['appoint_date'] ?? '');
                            if ($d === '') {
                                return '';
                            }
                            $ts = strtotime($d);
                            return $ts ? date('d/m/Y', $ts) : $d;
                        },
                    ],
                    [
                        'attribute' => 'stage_status',
                        'label' => 'Status',
                        'value' => function($row) {
                            return StudentStage::statusText($row['stage_status'] ?? null);
                        },
                    ],
                ],
            ]); ?>

        </div>
    </div>

</div>
