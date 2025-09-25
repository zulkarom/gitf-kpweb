<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\postgrad\models\Field;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\postgrad\models\SupervisorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Supervisors / Examiners List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supervisor-index">

    <p>
        <?= Html::a('Add Supervisor / Examiner', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
  
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

    <div class="kpi-row">
        <div class="kpi-card kpi-wide kpi-aqua">
            <div class="kpi-text">
                <p class="kpi-title">Staff with Main Role</p>
                <p class="kpi-value"><?= (int)$countStaffMain ?></p>
            </div>
            <div class="kpi-icon"><span class="fa fa-user"></span></div>
        </div>
        <div class="kpi-card kpi-wide kpi-yellow">
            <div class="kpi-text">
                <p class="kpi-title">Staff with Co-supervisor Role</p>
                <p class="kpi-value"><?= (int)$countStaffSecond ?></p>
            </div>
            <div class="kpi-icon"><span class="fa fa-users"></span></div>
        </div>
        <div class="kpi-card kpi-narrow kpi-red">
            <div class="kpi-text">
                <p class="kpi-title">Red (0–3)</p>
                <p class="kpi-value"><?= (int)$countRed ?></p>
            </div>
            <div class="kpi-icon"><span class="fa fa-circle"></span></div>
        </div>
        <div class="kpi-card kpi-narrow kpi-yellow">
            <div class="kpi-text">
                <p class="kpi-title">Yellow (4–7)</p>
                <p class="kpi-value"><?= (int)$countYellow ?></p>
            </div>
            <div class="kpi-icon"><span class="fa fa-circle"></span></div>
        </div>
        <div class="kpi-card kpi-narrow kpi-green">
            <div class="kpi-text">
                <p class="kpi-title">Green (8+)</p>
                <p class="kpi-value"><?= (int)$countGreen ?></p>
            </div>
            <div class="kpi-icon"><span class="fa fa-circle"></span></div>
        </div>
    </div>
   <br />
    
            <?php $form = ActiveForm::begin([
                'method' => 'get',
                'action' => ['index'],
            ]); ?>
            <div class="row">
                <div class="col-md-5">
                    <?= $form->field($searchModel, 'svName')->textInput(['placeholder' => 'Cari Nama', 'onchange' => 'this.form.submit();'])->label(false) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($searchModel, 'field_id')->dropDownList(Field::listFieldArray(), ['prompt' => 'Semua Bidang Kepakaran', 'onchange' => 'this.form.submit();'])->label(false) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($searchModel, 'color')->dropDownList([
                        '' => 'Semua Warna',
                        'red' => 'Red (0–3)',
                        'yellow' => 'Yellow (4–7)',
                        'green' => 'Green (8+)',
                    ], ['onchange' => 'this.form.submit();'])->label(false) ?>
                </div>
              
            </div>
            <?php ActiveForm::end(); ?>
   

 <div class="box">
<div class="box-header"></div>
<div class="box-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'svName',
                'format' => 'raw',
                'value' => function($model){
                    $name = $model->svName;
                    return Html::a($name, ['view', 'id' => $model->id], [
                        'title' => $model->svName
                    ]);
                }
            ],
            [
                'label' => 'Bidang Kepakaran',
                'attribute' => 'svFieldsString',
                'value' => function($model){
                    return $model->svFieldsString;
                }
            ],
            [
                'label' => 'Penyelia Utama',
                'attribute' => 'main_count',
                'value' => function($model){
                    return isset($model->main_count) ? (int)$model->main_count : (int)$model->countMain;
                }
            ],
            [
                'label' => 'Penyelia Bersama',
                'attribute' => 'second_count',
                'value' => function($model){
                    return isset($model->second_count) ? (int)$model->second_count : (int)$model->countSecond;
                }
            ],
            [
                'label' => 'Jumlah Penyeliaan',
                'attribute' => 'total_count',
                'value' => function($model){
                    return isset($model->total_count) ? (int)$model->total_count : (int)$model->countTotal;
                }
            ],
            [
                'label' => 'Warna',
                'attribute' => 'total_count',
                'format' => 'raw',
                'contentOptions' => ['style' => 'text-align:center; width:80px;'],
                'value' => function($model){
                    $total = isset($model->total_count) ? (int)$model->total_count : (int)$model->countTotal;
                    if ($total <= 3) {
                        $color = '#d9534f'; // red
                    } elseif ($total <= 7) {
                        $color = '#f0ad4e'; // yellow
                    } else {
                        $color = '#5cb85c'; // green
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
                    return Html::a('View',['view', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
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
</div>

</div>
