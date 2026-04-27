<?php

use backend\modules\esiap\models\Program;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use common\models\Country;
use yii\helpers\ArrayHelper;
use common\models\Common;
use backend\models\Campus;
use backend\modules\postgrad\models\Student;
use backend\modules\postgrad\models\StudentRegister;
use backend\modules\postgrad\models\ResearchStage;
use backend\modules\postgrad\models\Field;
use backend\models\Semester;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\postgrad\models\StudentPostGradSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $statusDaftarSummary array */

$this->title = 'Students List (Research)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-post-grad-index">

    <?php
        $semester = $searchModel->semester_id ? Semester::findOne((int)$searchModel->semester_id) : null;
        $semPart = 'unknown_sem';
        if ($semester) {
            $session = strtolower($semester->sessionShort());
            $y1 = substr((string)$semester->id, 0, 4);
            $y2 = substr((string)$semester->id, 4, 4);
            $semPart = 'sem_' . $session . '_' . $y1 . '_' . $y2;
        }

        $studentSchemaCols = array_keys(Student::getTableSchema()->columns);
        $excludeStudentCols = [
            'id',
            'user_id',
            'status',
            'last_status_daftar',
            'matric_no',
            'program_id',
            'study_mode',
            'study_mode_rc',
            'nationality',
            'nric',
            'gender',
            'marital_status',
            'citizenship',
            'field_id',
            'religion',
            'race',
            'campus_id',
            'phone_no',
            'created_at',
            'updated_at',
        ];
        $profileCols = array_values(array_diff($studentSchemaCols, $excludeStudentCols));
        $studentModel = new Student();
        $labels = $studentModel->attributeLabels();

        $exportColumns = [
            [
                'attribute' => 'no',
                'label' => 'No.',
                'value' => function () {
                    static $n = 0;
                    $n++;
                    return $n;
                }
            ],
            'matric_no',
            [
                'attribute' => 'name',
                'label' => 'Student Name',
                'value' => function ($model) {
                    return $model->user ? $model->user->fullname : '';
                }
            ],
            [
                'attribute' => 'status_daftar',
                'label' => 'Status Daftar',
                'value' => function ($model) {
                    return StudentRegister::statusDaftarText($model->status_daftar);
                }
            ],
            [
                'attribute' => 'status_aktif',
                'label' => 'Status Aktif',
                'value' => function ($model) {
                    return StudentRegister::statusAktifText($model->status_aktif);
                }
            ],
            [
                'attribute' => 'email',
                'label' => 'Email',
                'value' => function ($model) {
                    return $model->user ? $model->user->email : '';
                }
            ],
            [
                'attribute' => 'program_id',
                'label' => 'Program',
                'value' => function ($model) {
                    if ((int)$model->program_id === 85) {
                        return 'PhD';
                    }
                    if (in_array((int)$model->program_id, [81, 82, 84], true)) {
                        return 'Master';
                    }
                    return $model->program ? $model->program->program_code : '';
                }
            ],
            [
                'attribute' => 'study_mode',
                'label' => 'Taraf Pengajian',
                'value' => function ($model) {
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
                'label' => 'Study Mode (RC)',
                'value' => function ($model) {
                    return (string)$model->study_mode_rc;
                }
            ],
            [
                'attribute' => 'nationality',
                'label' => 'Country',
                'value' => function ($model) {
                    return $model->country ? $model->country->country_name : '';
                }
            ],
            [
                'attribute' => 'nric',
                'label' => 'NRIC/Passport',
                'value' => function ($model) {
                    // prefix tab to force Excel text
                    return "\t" . (string)$model->nric;
                }
            ],
            [
                'attribute' => 'latest_stage',
                'label' => 'Latest Stage',
                'value' => function ($model) {
                    return (string)$model->latest_stage;
                }
            ],
            [
                'attribute' => 'main_sv',
                'label' => 'Main Supervisor',
                'value' => function ($model) {
                    foreach ($model->supervisors as $sv) {
                        if ((int)$sv->sv_role === 1 && (int)$sv->is_active === 1) {
                            return $sv->supervisor ? $sv->supervisor->svNamePlain : '';
                        }
                    }
                    return '';
                }
            ],
            [
                'attribute' => 'second_sv',
                'label' => 'Second Supervisor',
                'value' => function ($model) {
                    foreach ($model->supervisors as $sv) {
                        if ((int)$sv->sv_role === 2 && (int)$sv->is_active === 1) {
                            return $sv->supervisor ? $sv->supervisor->svNamePlain : '';
                        }
                    }
                    return '';
                }
            ],
            [
                'attribute' => 'third_sv',
                'label' => 'Third Supervisor',
                'value' => function ($model) {
                    foreach ($model->supervisors as $sv) {
                        if ((int)$sv->sv_role === 3 && (int)$sv->is_active === 1) {
                            return $sv->supervisor ? $sv->supervisor->svNamePlain : '';
                        }
                    }
                    return '';
                }
            ],
        ];

        // export profile fields as text labels
        $exportColumns[] = [
            'attribute' => 'gender',
            'label' => 'Jantina',
            'value' => function ($model) {
                $list = Common::gender();
                $key = $model->gender;
                return array_key_exists($key, $list) ? $list[$key] : '';
            }
        ];

        $exportColumns[] = [
            'attribute' => 'marital_status',
            'label' => 'Taraf Perkahwinan',
            'value' => function ($model) {
                $list = Common::marital2();
                $key = $model->marital_status;
                return array_key_exists($key, $list) ? $list[$key] : '';
            }
        ];

        $exportColumns[] = [
            'attribute' => 'citizenship',
            'label' => 'Kewarganegaraan',
            'value' => function ($model) {
                $list = Common::citizenship();
                $key = (string)$model->citizenship;
                return array_key_exists($key, $list) ? $list[$key] : '';
            }
        ];

        $exportColumns[] = [
            'attribute' => 'field_id',
            'label' => 'Bidang Pengajian',
            'value' => function ($model) {
                return $model->field ? (string)$model->field->field_name : '';
            }
        ];

        $exportColumns[] = [
            'attribute' => 'religion',
            'label' => 'Agama',
            'value' => function ($model) {
                $list = Common::religion();
                $key = $model->religion;
                return array_key_exists($key, $list) ? $list[$key] : '';
            }
        ];

        $exportColumns[] = [
            'attribute' => 'race',
            'label' => 'Bangsa',
            'value' => function ($model) {
                $list = Common::race();
                $key = $model->race;
                return array_key_exists($key, $list) ? $list[$key] : '';
            }
        ];

        $exportColumns[] = [
            'attribute' => 'campus_id',
            'label' => 'Kampus',
            'value' => function ($model) {
                return $model->campus ? (string)$model->campus->campus_name : '';
            }
        ];

        $exportColumns[] = [
            'attribute' => 'phone_no',
            'label' => 'No. Telefon',
            'value' => function ($model) {
                return "\t" . (string)$model->phone_no;
            }
        ];

        foreach ($profileCols as $c) {
            $exportColumns[] = [
                'attribute' => $c,
                'label' => array_key_exists($c, $labels) ? $labels[$c] : $c,
                'value' => function ($model) use ($c) {
                    return $model->{$c};
                }
            ];
        }
    ?>

    <div style="display:flex; gap:6px; align-items:center; flex-wrap:wrap; margin-bottom:10px;">
        <?= Html::a('<i class="fa fa-plus"></i> Add Student', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Statistics', ['stats', 'semester_id' => $searchModel->semester_id], ['class' => 'btn btn-info']) ?>
        <?= Html::a('All Student Data', ['master'], ['class' => 'btn btn-primary']) ?>
        <?= ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $exportColumns,
            'filename' => 'students_' . $semPart,
            'asDropdown' => true,
            'target' => ExportMenu::TARGET_BLANK,
            'dropdownOptions' => [
                'label' => '<i class="fa fa-file-excel-o"></i> Export Excel',
                'class' => 'btn btn-success',
                'style' => 'background-color:#00a65a;border-color:#008d4c;color:#fff;',
                'encodeLabel' => false,
            ],
            'exportConfig' => [
                ExportMenu::FORMAT_HTML => false,
                ExportMenu::FORMAT_TEXT => false,
                ExportMenu::FORMAT_PDF => false,
                ExportMenu::FORMAT_CSV => false,
                ExportMenu::FORMAT_EXCEL => false,
                ExportMenu::FORMAT_EXCEL_X => [
                    'label' => 'Excel',
                ],
            ],
        ]) ?>
    </div>

    <?php
        $semesterOptions = ArrayHelper::map(
            Semester::find()->orderBy(['id' => SORT_DESC])->all(),
            'id',
            function($s){ return $s->longFormat(); }
        );
    ?>


<div class="box">
<div class="box-header">
    <?php $form = ActiveForm::begin(['method' => 'get', 'action' => ['index']]); ?>
    <div class="row">
        <div class="col-md-4">
            <?= Html::label('Semester', 'semester_id', ['class' => 'control-label']) ?>
            <?= Html::dropDownList('semester_id', $searchModel->semester_id, $semesterOptions, ['class' => 'form-control', 'prompt' => 'Choose', 'id' => 'semester_id', 'onchange' => '$(this).closest("form").submit()']) ?>
        </div>
    </div>
</div>
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




    <?php
        $filters = Yii::$app->request->get('StudentPostGradSearch', []);
        if (isset($filters['status_daftar'])) {
            unset($filters['status_daftar']);
        }
    ?>

    <?php if (!empty($statusDaftarSummary)) : ?>
        <?php
            $allTotal = 0;
            foreach ($statusDaftarSummary as $r) {
                $allTotal += (int)($r['total'] ?? 0);
            }
            $urlAll = ['index', 'semester_id' => $searchModel->semester_id, 'StudentPostGradSearch' => $filters];
        ?>
        <?= Html::a(
            Html::tag('span', Html::encode('All (' . (int)$allTotal . ')'), ['class' => 'label-outline label-outline--gray']),
            $urlAll,
            ['style' => 'display:inline-block; margin:2px 4px 2px 0;']
        ) ?>

        <?php foreach ($statusDaftarSummary as $row) : ?>
            <?php
                $code = $row['status_daftar'];
                $total = (int)($row['total'] ?? 0);
                if ($total <= 0) {
                    continue;
                }

                $filters2 = $filters;
                $filters2['status_daftar'] = $code;
                $url = ['index', 'semester_id' => $searchModel->semester_id, 'StudentPostGradSearch' => $filters2];
            ?>
            <?= Html::a(
                StudentRegister::statusDaftarOutlineLabel($code, $total),
                $url,
                ['style' => 'display:inline-block; margin:2px 4px 2px 0;']
            ) ?>
        <?php endforeach; ?>
        <br /><br />
    <?php endif; ?>
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
                'filter' => Html::activeDropDownList($searchModel, 'program_id', ['84' => 'PhD', '85' => 'Master'],['class'=> 'form-control','prompt' => 'Choose']),
                'value' => function($model){
                   if ($model->program_id == 85) {
                       return 'PhD';
                   }
                   if (in_array((int)$model->program_id, [81, 82, 84], true)) {
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
                'attribute' => 'latest_stage',
                'label' => 'Stage',
                'format' => 'text',
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'latest_stage_id',
                    ArrayHelper::map(
                        ResearchStage::find()->orderBy(['id' => SORT_ASC])->all(),
                        'id',
                        function($s){
                            $abbr = (string)$s->stage_abbr;
                            $name = (string)$s->stage_name;
                            return $abbr !== '' ? $abbr : $name;
                        }
                    ),
                    ['class'=> 'form-control','prompt' => 'Choose']
                ),
                'value' => function($model){
                    return (string)$model->latest_stage;
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
                   return StudentRegister::statusDaftarOutlineLabel($model->status_daftar);
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
<?php ActiveForm::end(); ?>
</div>
</div>
</div>
</div>
