<?php

use backend\modules\esiap\models\Program;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use common\models\Country;
use yii\helpers\ArrayHelper;
use backend\modules\postgrad\models\Student;
use backend\modules\postgrad\models\StudentRegister;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\postgrad\models\StudentMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $statusDaftarSummary array */

$this->title = 'All Student Data';
$this->params['breadcrumbs'][] = ['label' => 'Students List (Research)', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-master-index">

    <p>
        <?= Html::a('Add Student', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Research Students List', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>

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

    $currentFilters = Yii::$app->request->get('StudentMasterSearch', []);
    $filtersAll = $currentFilters;
    if (isset($filtersAll['status_daftar'])) {
        unset($filtersAll['status_daftar']);
    }
    if (isset($filtersAll['study_mode_rc'])) {
        unset($filtersAll['study_mode_rc']);
    }

    $studyModeSummary = (new \yii\db\Query())
        ->select([
            'study_mode_rc' => 's.study_mode_rc',
            'total' => 'COUNT(*)',
        ])
        ->from(['s' => Student::tableName()])
        ->groupBy(['s.study_mode_rc'])
        ->orderBy(['total' => SORT_DESC])
        ->all();

    $badgeMode = function($mode, $count = null) {
        $text = $mode === 'research' ? 'Research' : ($mode === 'coursework' ? 'Coursework' : ($mode === null || $mode === '' ? 'N/A' : (string)$mode));
        if ($count !== null) {
            $text .= ' (' . (int)$count . ')';
        }
        $variant = $mode === 'research' ? 'blue' : ($mode === 'coursework' ? 'purple' : 'gray');
        return Html::tag('span', Html::encode($text), ['class' => 'label-outline label-outline--' . $variant]);
    };
    ?>

    <?php if (!empty($studyModeSummary) || !empty($statusDaftarSummary)) : ?>
        <?php
        $allTotal = max(
            (int) (new \yii\db\Query())->from(Student::tableName())->count('*'),
            0
        );
        $urlAll = ['master', 'StudentMasterSearch' => $filtersAll];
        ?>
        <?= Html::a(
            Html::tag('span', Html::encode('All (' . (int)$allTotal . ')'), ['class' => 'label-outline label-outline--gray']),
            $urlAll,
            ['style' => 'display:inline-block; margin:2px 4px 2px 0;']
        ) ?>

        <?php foreach ($studyModeSummary as $row) : ?>
            <?php
            $mode = $row['study_mode_rc'];
            $total = (int)($row['total'] ?? 0);
            if ($total <= 0) {
                continue;
            }
            $filtersMode2 = $currentFilters;
            if (isset($filtersMode2['study_mode_rc'])) {
                unset($filtersMode2['study_mode_rc']);
            }
            $filtersMode2['study_mode_rc'] = $mode;
            $modeUrl = ['master', 'StudentMasterSearch' => $filtersMode2];
            ?>
            <?= Html::a(
                $badgeMode($mode, $total),
                $modeUrl,
                ['style' => 'display:inline-block; margin:2px 4px 2px 0;']
            ) ?>
        <?php endforeach; ?>

        <?php foreach ($statusDaftarSummary as $row) : ?>
            <?php
            $code = $row['status_daftar'];
            $total = (int)($row['total'] ?? 0);
            if ($total <= 0) {
                continue;
            }

            $filters2 = $currentFilters;
            if (isset($filters2['status_daftar'])) {
                unset($filters2['status_daftar']);
            }
            $filters2['status_daftar'] = $code;
            $url = ['master', 'StudentMasterSearch' => $filters2];
            ?>
            <?= Html::a(
                StudentRegister::statusDaftarOutlineLabel($code, $total),
                $url,
                ['style' => 'display:inline-block; margin:2px 4px 2px 0;']
            ) ?>
        <?php endforeach; ?>

        <br /><br />
    <?php endif; ?>

    <div class="box">
        <div class="box-header"></div>
        <div class="box-body">
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
                            return Html::a($name, ['view', 'id' => $model->id]) . '<br />' . Html::encode($line2);
                        }
                    ],
                    [
                        'attribute' => 'program_id',
                        'label' => 'Program',
                        'format' => 'html',
                        'filter' => Html::activeDropDownList($searchModel, 'program_id', ['84' => 'PhD', '85' => 'Master'],['class'=> 'form-control','prompt' => 'Choose']),
                        'value' => function($model){
                            if ((int)$model->program_id === 84) {
                                return 'PhD';
                            }
                            if (in_array((int)$model->program_id, [81, 82, 85], true)) {
                                return 'Master';
                            }
                            return $model->program ? $model->program->program_code : '';
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
                        'attribute' => 'study_mode',
                        'label' => 'Taraf Pengajian',
                        'format' => 'text',
                        'filter' => Html::activeDropDownList(
                            $searchModel,
                            'study_mode',
                            [1 => 'Sepenuh Masa', 2 => 'Separuh Masa'],
                            ['class'=> 'form-control','prompt' => 'Choose']
                        ),
                        'value' => function($model){
                            if ((int)$model->study_mode === 1) {
                                return 'Sepenuh Masa';
                            }
                            if ((int)$model->study_mode === 2) {
                                return 'Separuh Masa';
                            }
                            return '';
                        }
                    ],

                    [
                        'attribute' => 'study_mode_rc',
                        'label' => 'Study Mode',
                        'format' => 'raw',
                        'filter' => Html::activeDropDownList(
                            $searchModel,
                            'study_mode_rc',
                            ['research' => 'Research', 'coursework' => 'Coursework'],
                            ['class'=> 'form-control','prompt' => 'Choose']
                        ),
                        'value' => function($model){
                            $mode = $model->study_mode_rc;
                            $filters = Yii::$app->request->get('StudentMasterSearch', []);
                            $filters['study_mode_rc'] = $mode;
                            $url = ['master', 'StudentMasterSearch' => $filters];
                            $text = $mode === 'research' ? 'Research' : ($mode === 'coursework' ? 'Coursework' : ($mode === null || $mode === '' ? 'N/A' : (string)$mode));
                            $variant = $mode === 'research' ? 'blue' : ($mode === 'coursework' ? 'purple' : 'gray');
                            return Html::a(Html::tag('span', Html::encode($text), ['class' => 'label-outline label-outline--' . $variant]), $url);
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
                        'value' => function($model) {
                            $code = $model->status_daftar;
                            $filters = Yii::$app->request->get('StudentMasterSearch', []);
                            $filters['status_daftar'] = $code;
                            $url = ['master', 'StudentMasterSearch' => $filters];
                            return Html::a(StudentRegister::statusDaftarOutlineLabel($code), $url);
                        }
                    ],

                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{view}',
                        'buttons'=>[
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
