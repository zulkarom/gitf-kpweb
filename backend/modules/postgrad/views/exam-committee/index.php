<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $semester_id integer|null */
/* @var $semesterList array */
/* @var $dataProvider yii\data\ArrayDataProvider */
/* @var $tab string */
/* @var $countChairman int */
/* @var $countDeputy int */
/* @var $countExaminer1 int */
/* @var $countExaminer2 int */
/* @var $countGreen int */
/* @var $countYellow int */
/* @var $countRed int */
/* @var $tabCounts array */
/* @var $kpi string|null */

$this->title = 'Examination Committee';
$this->params['breadcrumbs'][] = ['label' => 'Postgraduate Admin', 'url' => ['//postgrad/student/stats']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="exam-committee-index">

    <div class="box">

        <div class="box-header with-border">
            <?php
                $currentTab = $tab ?? 'academic';
                $semesterIdParam = Yii::$app->request->get('semester_id');

                $countAcademic = (int)($tabCounts['academic'] ?? 0);
                $countOther = (int)($tabCounts['other'] ?? 0);
                $countExternal = (int)($tabCounts['external'] ?? 0);
                $countTransferred = (int)($tabCounts['transferred'] ?? 0);

                $tabBase = ['index'];
                if (!empty($semesterIdParam)) {
                    $tabBase['semester_id'] = $semesterIdParam;
                }
            ?>
            <ul class="nav nav-tabs">
                <li class="<?= $currentTab === 'academic' ? 'active' : '' ?>">
                    <a href="<?= Url::to(array_merge($tabBase, ['tab' => 'academic'])) ?>">FKP Staff <span class="label label-primary"><?= $countAcademic ?></span></a>
                </li>
                <li class="<?= $currentTab === 'other' ? 'active' : '' ?>">
                    <a href="<?= Url::to(array_merge($tabBase, ['tab' => 'other'])) ?>">Other Faculty <span class="label label-primary"><?= $countOther ?></span></a>
                </li>
                <li class="<?= $currentTab === 'external' ? 'active' : '' ?>">
                    <a href="<?= Url::to(array_merge($tabBase, ['tab' => 'external'])) ?>">External <span class="label label-primary"><?= $countExternal ?></span></a>
                </li>
                <li class="<?= $currentTab === 'transferred' ? 'active' : '' ?>">
                    <a href="<?= Url::to(array_merge($tabBase, ['tab' => 'transferred'])) ?>">Transferred/Quit <span class="label label-primary"><?= $countTransferred ?></span></a>
                </li>
            </ul>
        </div>

        <div class="box-body">

            <?php
                $kpiBase = ['index', 'tab' => $currentTab];
                if (!empty($semester_id)) {
                    $kpiBase['semester_id'] = $semester_id;
                }
            ?>

            <style>
    .kpi-row { display:flex; gap:14px; align-items:stretch; flex-wrap:nowrap; }
    .kpi-card { flex: 1 1 0; background:#fff; border:1px solid #e5e7eb; border-radius:10px; padding:16px 18px; box-shadow:0 1px 2px rgba(0,0,0,.06); display:flex; align-items:center; justify-content:space-between; min-height:84px; }
    .kpi-card .kpi-text { line-height:1.1; }
    .kpi-card .kpi-title { margin:0; font-size:13px; color:#6b7280; font-weight:600; letter-spacing:.3px; }
    .kpi-card .kpi-value { margin:6px 0 0; font-size:28px; color:#111827; font-weight:700; }
    .kpi-icon { width:36px; height:36px; border-radius:8px; display:flex; align-items:center; justify-content:center; position:relative; background:#e5e7eb; }
    /* only color status cards (narrow) replace the icon with a circle */
    .kpi-narrow.kpi-red .kpi-icon > span,
    .kpi-narrow.kpi-yellow .kpi-icon > span,
    .kpi-narrow.kpi-green  .kpi-icon > span { display:none; }
    /* inner colored circle only for color status cards */
    .kpi-narrow.kpi-red .kpi-icon::after,
    .kpi-narrow.kpi-yellow .kpi-icon::after,
    .kpi-narrow.kpi-green  .kpi-icon::after { content:""; width:18px; height:18px; border-radius:50%; position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); }
    /* apply colors to the inner circle per status */
    .kpi-narrow.kpi-red .kpi-icon::after { background:#d9534f; }
    .kpi-narrow.kpi-yellow .kpi-icon::after { background:#f0ad4e; }
    .kpi-narrow.kpi-green .kpi-icon::after { background:#5cb85c; }
    /* optional aqua variant (chairman) keeps subtle blue square */
    .kpi-aqua .kpi-icon { background:#e0f2fe; }
    /* layout proportions: fit all stats in one row */
    .kpi-wide { flex-basis: 14%; }
    .kpi-narrow { flex-basis: 12%; }
    @media (max-width: 1400px){ .kpi-row { flex-wrap:wrap; } .kpi-wide, .kpi-narrow { flex-basis: calc(25% - 14px); } }
    @media (max-width: 992px){ .kpi-wide, .kpi-narrow { flex-basis: calc(50% - 14px); } }
    @media (max-width: 768px){ .kpi-wide, .kpi-narrow { flex-basis: 100%; } }
            </style>

            <div class="kpi-row">

                <a href="<?= Url::to(array_merge($kpiBase, ['kpi' => 'chairman'])) ?>" style="display:block; color:inherit; text-decoration:none; flex: 1 1 0;">
                    <div class="kpi-card kpi-wide kpi-aqua">
                        <div class="kpi-text">
                            <p class="kpi-title">Staff with Chairman Role</p>
                            <p class="kpi-value"><?= (int)$countChairman ?></p>
                        </div>
                        <div class="kpi-icon"><span class="fa fa-users"></span></div>
                    </div>
                </a>

                <a href="<?= Url::to(array_merge($kpiBase, ['kpi' => 'deputy'])) ?>" style="display:block; color:inherit; text-decoration:none; flex: 1 1 0;">
                    <div class="kpi-card kpi-wide kpi-yellow">
                        <div class="kpi-text">
                            <p class="kpi-title">Staff with D.Chairman Role</p>
                            <p class="kpi-value"><?= (int)$countDeputy ?></p>
                        </div>
                        <div class="kpi-icon"><span class="fa fa-users"></span></div>
                    </div>
                </a>

                <a href="<?= Url::to(array_merge($kpiBase, ['kpi' => 'examiner1'])) ?>" style="display:block; color:inherit; text-decoration:none; flex: 1 1 0;">
                    <div class="kpi-card kpi-wide kpi-aqua">
                        <div class="kpi-text">
                            <p class="kpi-title">Staff with Examiner 1 Role</p>
                            <p class="kpi-value"><?= (int)$countExaminer1 ?></p>
                        </div>
                        <div class="kpi-icon"><span class="fa fa-users"></span></div>
                    </div>
                </a>

                <a href="<?= Url::to(array_merge($kpiBase, ['kpi' => 'examiner2'])) ?>" style="display:block; color:inherit; text-decoration:none; flex: 1 1 0;">
                    <div class="kpi-card kpi-wide kpi-red">
                        <div class="kpi-text">
                            <p class="kpi-title">Staff with Examiner 2 Role</p>
                            <p class="kpi-value"><?= (int)$countExaminer2 ?></p>
                        </div>
                        <div class="kpi-icon"><span class="fa fa-users"></span></div>
                    </div>
                </a>

                <a href="<?= Url::to(array_merge($kpiBase, ['kpi' => 'green'])) ?>" style="display:block; color:inherit; text-decoration:none; flex: 1 1 0;">
                    <div class="kpi-card kpi-narrow kpi-green">
                        <div class="kpi-text">
                            <p class="kpi-title">Green (0–3)</p>
                            <p class="kpi-value"><?= (int)$countGreen ?></p>
                        </div>
                        <div class="kpi-icon"><span class="fa fa-circle"></span></div>
                    </div>
                </a>

                <a href="<?= Url::to(array_merge($kpiBase, ['kpi' => 'yellow'])) ?>" style="display:block; color:inherit; text-decoration:none; flex: 1 1 0;">
                    <div class="kpi-card kpi-narrow kpi-yellow">
                        <div class="kpi-text">
                            <p class="kpi-title">Yellow (4–7)</p>
                            <p class="kpi-value"><?= (int)$countYellow ?></p>
                        </div>
                        <div class="kpi-icon"><span class="fa fa-circle"></span></div>
                    </div>
                </a>

                <a href="<?= Url::to(array_merge($kpiBase, ['kpi' => 'red'])) ?>" style="display:block; color:inherit; text-decoration:none; flex: 1 1 0;">
                    <div class="kpi-card kpi-narrow kpi-red">
                        <div class="kpi-text">
                            <p class="kpi-title">Red (8+)</p>
                            <p class="kpi-value"><?= (int)$countRed ?></p>
                        </div>
                        <div class="kpi-icon"><span class="fa fa-circle"></span></div>
                    </div>
                </a>
            </div>

            <br />

            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => Url::to(['index']),
            ]); ?>

            <?= Html::hiddenInput('tab', $currentTab) ?>

            <div class="row">
                <div class="col-md-4">
                    <?= Html::dropDownList('semester_id', $semester_id, $semesterList, [
                        'class' => 'form-control',
                        'prompt' => 'Select Semester',
                        'onchange' => 'this.form.submit();',
                    ]) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

            <br />

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{summary}\n{items}\n{pager}",
                'tableOptions' => ['class' => 'table table-bordered table-striped'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'sv_name',
                        'label' => 'Staff',
                        'value' => function ($row) {
                            return $row['sv_name'];
                        },
                    ],
                    [
                        'attribute' => 'pengerusi',
                        'label' => 'Chairman',
                        'value' => function ($row) { return (int)$row['pengerusi']; },
                    ],
                    [
                        'attribute' => 'penolong',
                        'label' => 'Deputy Chairman',
                        'value' => function ($row) { return (int)$row['penolong']; },
                    ],
                    [
                        'attribute' => 'pemeriksa1',
                        'label' => 'Examiner 1',
                        'value' => function ($row) { return (int)$row['pemeriksa1']; },
                    ],
                    [
                        'attribute' => 'pemeriksa2',
                        'label' => 'Examiner 2',
                        'value' => function ($row) { return (int)$row['pemeriksa2']; },
                    ],
                       [
                        'attribute' => 'total',
                        'label' => 'Total',
                        'value' => function ($row) { return (int)$row['total']; },
                    ],
                    [
                        'label' => 'Color',
                        'attribute' => 'total',
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'text-align:center; width:80px;'],
                        'value' => function ($row) {
                            $total = (int)$row['total'];
                            if ($total <= 3) {
                                $color = '#5cb85c';
                            } elseif ($total <= 7) {
                                $color = '#f0ad4e';
                            } else {
                                $color = '#d9534f';
                            }
                            $outer = 'display:inline-block;width:24px;height:24px;border-radius:8px;background-color:#e5e7eb;position:relative;';
                            $inner = 'display:block;width:12px;height:12px;border-radius:50%;background-color:'.$color.';position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);';
                            return '<span title="Total: '.$total.'" style="'.$outer.'"><span style="'.$inner.'"></span></span>';
                        }
                    ],
                 
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}',
                        'header' => '',
                        'buttons' => [
                            'view' => function ($url, $row) {
                                if (empty($row['supervisor'])) {
                                    return '';
                                }
                                return Html::a('<i class="fa fa-eye"></i> View', ['/postgrad/supervisor/view', 'id' => $row['supervisor']->id], ['class' => 'btn btn-warning btn-sm']);
                            }
                        ]
                    ],
                ],
            ]) ?>

        </div>
    </div>

</div>
