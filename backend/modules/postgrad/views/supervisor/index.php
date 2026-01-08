<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\modules\postgrad\models\Field;
use backend\models\Semester;
use yii\widgets\ActiveForm;
use backend\modules\postgrad\models\PgSetting;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\postgrad\models\SupervisorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Supervisors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supervisor-index">

    <?php
        $currentTab = $tab ?? 'academic';
        $isSupervisorTab = true;
    ?>

    <?php if ($isSupervisorTab) : ?>
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['index'],
    ]); ?>
    <?= Html::hiddenInput('tab', $currentTab) ?>
    <div class="row" style="margin-bottom:10px;">
        <div class="col-md-3">
            <?= $form->field($searchModel, 'semester_id')->dropDownList(
                Semester::listSemesterArray(),
                ['name' => 'semester_id', 'value' => $semesterId, 'prompt' => 'Semester', 'onchange' => 'this.form.submit();']
            )->label(false) ?>
        </div>

                <div class="col-md-4">
                    <?= $form->field($searchModel, 'svNameSearch')->textInput(['placeholder' => 'Cari Nama', 'onchange' => 'this.form.submit();'])->label(false) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($searchModel, 'field_id')->dropDownList(Field::listFieldArray(), ['prompt' => 'Semua Bidang Kepakaran', 'onchange' => 'this.form.submit();'])->label(false) ?>
                </div>
                <div class="col-md-2">
                    <?php
                        $greenLabel = PgSetting::trafficLightLabel('supervisor', 'green');
                        $yellowLabel = PgSetting::trafficLightLabel('supervisor', 'yellow');
                        $redLabel = PgSetting::trafficLightLabel('supervisor', 'red');
                    ?>
                    <?= $form->field($searchModel, 'color')->dropDownList([
                        '' => 'Semua Warna',
                        'green' => $greenLabel,
                        'yellow' => $yellowLabel,
                        'red' => $redLabel,
                    ], ['onchange' => 'this.form.submit();'])->label(false) ?>
                </div>
              
            </div>
            <?php ActiveForm::end(); ?>
    <?php endif; ?>
  
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
    /* optional aqua variant (staff main) keeps subtle blue square */
    .kpi-aqua .kpi-icon { background:#e0f2fe; }
    .kpi-badge { font-size:12px; color:#6b7280; margin-top:2px; }
    /* layout proportions: two wider then three compact */
    .kpi-wide { flex-basis: 24%; }
    .kpi-narrow { flex-basis: 17%; }
    @media (max-width: 1400px){ .kpi-wide { flex-basis:26%; } .kpi-narrow { flex-basis:16%; } }
    @media (max-width: 1200px){ .kpi-row { flex-wrap:wrap; } .kpi-wide, .kpi-narrow { flex-basis: calc(50% - 14px); } }
    @media (max-width: 768px){ .kpi-wide, .kpi-narrow { flex-basis: 100%; } }
    </style>


    
        
   

 <div class="box">
<div class="box-header with-border">
    <?php
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

    <?php if (($tab ?? 'academic') === 'academic') : ?>

    <?php
        $formName = $searchModel->formName();
        $semesterIdParam = Yii::$app->request->get('semester_id');

        $kpiBaseParams = ['index'];
        if (!empty($semesterIdParam)) {
            $kpiBaseParams['semester_id'] = $semesterIdParam;
        }

        $urlMain = Url::to(array_merge($kpiBaseParams, [$formName => ['sv_role' => 1]]));
        $urlCo = Url::to(array_merge($kpiBaseParams, [$formName => ['sv_role' => 2]]));

        $urlGreen = Url::to(array_merge($kpiBaseParams, [$formName => ['color' => 'green']]));
        $urlYellow = Url::to(array_merge($kpiBaseParams, [$formName => ['color' => 'yellow']]));
        $urlRed = Url::to(array_merge($kpiBaseParams, [$formName => ['color' => 'red']]));
    ?>

    <div class="kpi-row">
        <a href="<?= $urlMain ?>" style="display:block; color:inherit; text-decoration:none; flex: 1 1 0;">
            <div class="kpi-card kpi-wide kpi-aqua">
                <div class="kpi-text">
                    <p class="kpi-title">Staff with Main Supervisor Role</p>
                    <p class="kpi-value"><?= (int)$countStaffMain ?></p>
                </div>
                <div class="kpi-icon"><span class="fa fa-user"></span></div>
            </div>
        </a>
        <a href="<?= $urlCo ?>" style="display:block; color:inherit; text-decoration:none; flex: 1 1 0;">
            <div class="kpi-card kpi-wide kpi-yellow">
                <div class="kpi-text">
                    <p class="kpi-title">Staff with Co-supervisor Role</p>
                    <p class="kpi-value"><?= (int)$countStaffSecond ?></p>
                </div>
                <div class="kpi-icon"><span class="fa fa-users"></span></div>
            </div>
        </a>
        <a href="<?= $urlGreen ?>" style="display:block; color:inherit; text-decoration:none; flex: 1 1 0;">
            <div class="kpi-card kpi-narrow kpi-green">
                <div class="kpi-text">
                    <p class="kpi-title"><?= Html::encode(PgSetting::trafficLightLabel('supervisor', 'green')) ?></p>
                    <p class="kpi-value"><?= (int)$countGreen ?></p>
                </div>
                <div class="kpi-icon"><span class="fa fa-circle"></span></div>
            </div>
        </a>
        <a href="<?= $urlYellow ?>" style="display:block; color:inherit; text-decoration:none; flex: 1 1 0;">
            <div class="kpi-card kpi-narrow kpi-yellow">
                <div class="kpi-text">
                    <p class="kpi-title"><?= Html::encode(PgSetting::trafficLightLabel('supervisor', 'yellow')) ?></p>
                    <p class="kpi-value"><?= (int)$countYellow ?></p>
                </div>
                <div class="kpi-icon"><span class="fa fa-circle"></span></div>
            </div>
        </a>
        <a href="<?= $urlRed ?>" style="display:block; color:inherit; text-decoration:none; flex: 1 1 0;">
            <div class="kpi-card kpi-narrow kpi-red">
                <div class="kpi-text">
                    <p class="kpi-title"><?= Html::encode(PgSetting::trafficLightLabel('supervisor', 'red')) ?></p>
                    <p class="kpi-value"><?= (int)$countRed ?></p>
                </div>
                <div class="kpi-icon"><span class="fa fa-circle"></span></div>
            </div>
        </a>
    </div>
   <br />

    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'svName',
                'label' => 'Supervisor Name',
                'format' => 'raw',
                'value' => function($model){
                    $staffNo = $model->staff ? $model->staff->staff_no : '';
                    $name = strtoupper($model->svName);
                    $text = $staffNo ? $staffNo . ' - ' . $name : $name;
                    return Html::a($text, ['view', 'id' => $model->id, 'semester_id' => Yii::$app->request->get('semester_id')], [
                        'title' => $model->svName
                    ]);
                }
            ],
            [
                'label' => 'Field of Expertise',
                'attribute' => 'svFieldsString',
                'value' => function($model){
                    return $model->svFieldsString;
                }
            ],
            [
                'label' => 'Main Supervisor',
                'attribute' => 'main_count',
                'value' => function($model){
                    return (int)($model->getAttribute('main_count') ?? 0);
                }
            ],
            [
                'label' => 'Co-Supervisor',
                'attribute' => 'second_count',
                'value' => function($model){
                    return (int)($model->getAttribute('second_count') ?? 0);
                }
            ],
            [
                'label' => 'Total',
                'attribute' => 'total_count',
                'value' => function($model){
                    return (int)($model->getAttribute('total_count') ?? 0);
                }
            ],
            [
                'label' => 'Color',
                'attribute' => 'total_count',
                'format' => 'raw',
                'contentOptions' => ['style' => 'text-align:center; width:80px;'],
                'value' => function($model){
                    $total = (int)($model->getAttribute('total_count') ?? 0);
                    if ($total <= 3) {
                        $color = '#5cb85c'; // green
                    } elseif ($total <= 7) {
                        $color = '#f0ad4e'; // yellow
                    } else {
                        $color = '#d9534f'; // red
                    }
                    $outer = 'display:inline-block;width:24px;height:24px;border-radius:8px;background-color:#e5e7eb;position:relative;';
                    $inner = 'display:block;width:12px;height:12px;border-radius:50%;background-color:'.$color.';position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);';
                    return '<span title="Jumlah: '.$total.'" style="'.$outer.'"><span style="'.$inner.'"></span></span>';
                }
            ],
                

            ['class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 13%'],
                'template' => '{view}',
                //'visible' => false,
                'buttons'=>[
                    'view'=>function ($url, $model) {
                    return Html::a('View',['view', 'id' => $model->id, 'semester_id' => Yii::$app->request->get('semester_id')],['class'=>'btn btn-warning btn-sm']);
                    },
                    'delete'=>function ($url, $model) {
                    return Html::a('<span class="fa fa-trash"></span>', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger btn-sm',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this data?',
                            'method' => 'post',
                        ],
                    ])
                    ;
                    }
                    ],
                    
                    ],
                    
        ],
    ]); ?>
</div>
