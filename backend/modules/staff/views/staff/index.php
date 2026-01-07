<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use richardfan\widget\JSRegister;
use backend\modules\staff\models\Staff;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\staff\models\StaffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Staff Management';
$this->params['breadcrumbs'][] = $this->title;

$exportColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    'staff_no',
    'staff_title',
    [
        'attribute' => 'staff_name',
        'label' => 'Staff Name',
        'value' => function($model){
            if($model->user){
                return $model->user->fullname;
            }
        }
    ],
    [
        'attribute' => 'gender',
        'label' => 'Gender',
        'value' => function($model){
            if($model->gender == 1){
                return 'Male';
            }else{
                return 'Female';
            }
        }
    ],
    [
        'attribute' => 'position_id',
        'value' => function($model){
            if($model->staffPosition){
                return $model->staffPosition->position_name;
            }
        }
    ],
    [
        'label' => 'Email',
        'value' => function($model){
            if($model->user){
                return $model->user->email;
            }
        }
    ],
    [
        'attribute' => 'is_academic',
        'value' => function($model){
            if($model->is_academic == 1){
                return 'Academic';
            }else{
                return 'Administrative';
            }
        }
    ],
    [
        'attribute' => 'position_status',
        'value' => function($model){
            if($model->staffPositionStatus){
                return $model->staffPositionStatus->status_name;
            }
        }
    ],
    [
        'attribute' => 'working_status',
        'value' => function($model){
            if($model->workingStatus){
                return $model->workingStatus->work_name;
            }
        }
    ],
    'staff_edu',
    'staff_gscholar',
    'staff_expertise',
    'staff_interest',
    'officephone',
    'handphone1',
    'handphone2',
    'staff_ic',
    'staff_dob',
    'date_begin_umk',
    'date_begin_service',
    'personal_email',
    'ofis_location'
];
?>
    <?php
        $currentTab = $tab ?? 'staff';
        $countStaffTab = (int)($tabCounts['staff'] ?? 0);
        $countOtherTab = (int)($tabCounts['other'] ?? 0);
        $countInactiveTab = (int)($tabCounts['inactive'] ?? 0);
    ?>
<div class="staff-index">

     <div class="form-group">
                <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Add New Staff', ['create'], ['class' => 'btn btn-success']) ?> 
                <?= Html::button('<span class="glyphicon glyphicon-search"></span> Search',['id' => 'btn-search-show', 'class' => 'btn btn-primary']) ?>

                <?=ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $exportColumns,
                    'exportConfig' => [
                        ExportMenu::FORMAT_PDF => false,
                        ExportMenu::FORMAT_EXCEL_X => false,
                    ],
                    'filename' => 'STAFF_DATA_' . date('Y-m-d'),
                    'onRenderSheet'=>function($sheet, $grid){
                        $sheet->getStyle('A2:'.$sheet->getHighestColumn().$sheet->getHighestRow())
                        ->getAlignment()->setWrapText(true);
                    },

                ]);?>

                
            </div>
            
       <div style="display:none" id="con-form-searach">
                <?=$this->render('_search', ['model' => $searchModel, 'tab' => $currentTab])?>
            </div>




    <div class="box">
        <div class="box-header with-border">
            <ul class="nav nav-tabs">
                <li class="<?= $currentTab === 'staff' ? 'active' : '' ?>">
                    <a href="<?= Yii::$app->urlManager->createUrl(['/staff/staff/index']) ?>">FKP Staff <span class="label label-primary"><?= $countStaffTab ?></span></a>
                </li>
                <li class="<?= $currentTab === 'other' ? 'active' : '' ?>">
                    <a href="<?= Yii::$app->urlManager->createUrl(['/staff/staff/external']) ?>">Other Faculty <span class="label label-primary"><?= $countOtherTab ?></span></a>
                </li>
                <li class="<?= $currentTab === 'inactive' ? 'active' : '' ?>">
                    <a href="<?= Yii::$app->urlManager->createUrl(['/staff/staff/inactive']) ?>">Transfered/Quit <span class="label label-primary"><?= $countInactiveTab ?></span></a>
                </li>
            </ul>
        </div>
        <div class="box-body">

            <?php
            $summaryParams = Yii::$app->request->queryParams;
            if (isset($summaryParams['StaffSearch']['position_id'])) {
                unset($summaryParams['StaffSearch']['position_id']);
            }

            $summarySearchModel = new \backend\modules\staff\models\StaffSearch();
            $summaryProvider = $summarySearchModel->search($summaryParams);
            $qPos = clone $summaryProvider->query;
            $positionSummary = $qPos
                ->select([
                    'sp.id AS position_id',
                    'sp.position_name AS position_name',
                    'sp.position_gred AS position_gred',
                    'COUNT(DISTINCT staff.id) AS total'
                ])
                ->leftJoin(['sp' => 'staff_position'], 'sp.id = staff.position_id')
                ->groupBy(['sp.id', 'sp.position_name', 'sp.position_gred'])
                ->orderBy(['position_order' => SORT_ASC])
                ->asArray()
                ->all();
            ?>


                       <?php
                        foreach ($positionSummary as $row) : ?>
                            <?php
                                $name = $row['position_name'] . ' (' . $row['position_gred'] . ')' ?: '(Not Set)';
                                $text = $name . ' (' . (int)$row['total'] . ')';
                                $positionId = (int)($row['position_id'] ?? 0);
                                $variants = ['blue', 'green', 'yellow', 'aqua', 'red', 'purple', 'gray'];
                                $variant = $positionId > 0 ? $variants[$positionId % count($variants)] : 'gray';
                                $filters = Yii::$app->request->get('StaffSearch', []);
                                $filters['position_id'] = $row['position_id'] ?? null;
                                $url = ['/staff/staff/index', 'StaffSearch' => $filters];
                            ?>
                            <?= Html::a(
                                Html::tag('span', Html::encode($text), ['class' => 'label-outline label-outline--' . $variant]),
                                $url,
                                ['style' => 'display:inline-block; margin:2px 4px 2px 0;']
                            ) ?>
                        <?php endforeach; ?>
                    <br /><br />

            <div class="box">
                <div class="box-header"></div>
                <div class="box-body"><?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'export' => false,
                    //'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'staff_name',
                            'label' => 'Staff Name',
                            'format' => 'raw',
                            'value' => function($model){
                                if($model->user){
                                    $text = $model->staff_no . ' - ' . strtoupper(trim($model->staff_title) . ' ' . trim($model->user->fullname));
                                    return Html::a(Html::encode($text), ['/staff/staff/view', 'id' => $model->id]);
                                }
                            }
                        ],
                        [
                            'attribute' => 'position_id',
                            'label' => 'Position',
                            'format' => 'raw',
                            'value' => function($model){
                                return $model->positionLabel;
                            }
                        ],
                        [
                            'attribute' => 'is_academic',
                            'label' => 'Type',
                            'format' => 'raw',
                            'value' => function($model){
                                return $model->typeLabel;
                            }
                        ],
                        [
                            'attribute' => 'position_status',
                            'label' => 'Position Status',
                            'format' => 'raw',
                            'value' => function($model){
                                return $model->positionStatusLabel;
                            }
                        ],
                        [
                            'attribute' => 'working_status',
                            'label' => 'Working Status',
                            'format' => 'raw',
                            'value' => function($model){
                                return $model->workingStatusLabel;
                            }
                        ],
                        ['class' => 'yii\grid\ActionColumn',
                            'contentOptions' => ['style' => 'width: 8.7%'],
                            'template' => '{update}',
                            //'visible' => false,
                            'buttons'=>[
                                'update'=>function ($url, $model) {
                                    return Html::a('UPDATE',['/staff/staff/update/', 'id' => $model->id],['class'=>'btn btn-primary btn-sm']);
                                }
                            ],
                        ],
                    ],
                ]); ?></div>
            </div>
        </div>
    </div>
</div>

<?php JSRegister::begin(); ?>
<script>
    $("#btn-search-show").click(function(){
        $('#con-form-searach').slideToggle();
    });
    $("#hide-form").click(function(){
        $('#con-form-searach').slideUp();
    });
</script>
<?php JSRegister::end(); ?>