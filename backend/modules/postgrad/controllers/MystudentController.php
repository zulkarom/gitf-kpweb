<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\User;
use common\models\Country;
use backend\models\Semester;
use backend\modules\esiap\models\Program;
use backend\modules\postgrad\models\Field;
use backend\modules\postgrad\models\Student;
use backend\modules\postgrad\models\StudentPostGradSearch;
use backend\modules\postgrad\models\Supervisor;
use backend\modules\postgrad\models\StudentSupervisor;
use backend\modules\postgrad\models\StudentRegister;
use backend\modules\postgrad\models\StudentStage;
use backend\modules\postgrad\models\ResearchStage;
use backend\modules\postgrad\models\PgSetting;
use backend\modules\postgrad\models\StageExaminer;
use yii\db\Query;
use yii\db\Expression;
use yii\web\NotFoundHttpException;

class MystudentController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $staff = $user && isset($user->staff) ? $user->staff : null;

        $semesterId = (int)Yii::$app->request->get('semester_id', 0);
        $svRole = (int)Yii::$app->request->get('sv_role', 0);
        $stageId = (int)Yii::$app->request->get('stage_id', 0);
        if (!$semesterId) {
            $currentSem = Semester::getCurrentSemester();
            if ($currentSem) {
                $semesterId = (int)$currentSem->id;
            }
        }

        $supervisorId = null;
        if ($staff) {
            $supervisorId = Supervisor::find()
                ->select(['id'])
                ->where(['staff_id' => $staff->id])
                ->scalar();
        }

        $baseQuery = StudentSupervisor::find()->alias('sv')
            ->innerJoin(['s' => Student::tableName()], 's.id = sv.student_id')
            ->leftJoin(['u' => 'user'], 'u.id = s.user_id')
            ->andWhere(['sv.supervisor_id' => (int)$supervisorId]);

        $latestStageSemesterSub = (new Query())
            ->select(['student_id', 'max_semester_id' => 'MAX(semester_id)'])
            ->from(StudentStage::tableName())
            ->where(['<=', 'semester_id', (int)$semesterId])
            ->groupBy(['student_id']);

        $latestStageSub = (new Query())
            ->select(['st1.student_id', 'max_id' => 'MAX(st1.id)'])
            ->from(['st1' => StudentStage::tableName()])
            ->innerJoin(['stsem' => $latestStageSemesterSub], 'stsem.student_id = st1.student_id AND st1.semester_id = stsem.max_semester_id')
            ->groupBy(['st1.student_id']);

        $baseQuery->leftJoin(['stmax' => $latestStageSub], 'stmax.student_id = s.id')
            ->leftJoin(['stg' => StudentStage::tableName()], 'stg.id = stmax.max_id')
            ->leftJoin(['rs' => ResearchStage::tableName()], 'rs.id = stg.stage_id')
            ->leftJoin(['r' => StudentRegister::tableName()], 'r.student_id = s.id AND r.semester_id = :sem', [':sem' => (int)$semesterId]);

        $baseQuery->select([
            'sv.*',
            'student_name' => 'u.fullname',
            'matric_no' => 's.matric_no',
            'stage_name' => new Expression("COALESCE(NULLIF(rs.stage_name_en,''), rs.stage_name)"),
            'status_daftar' => 'r.status_daftar',
        ]);

        $stats = [
            'main_supervisor' => 0,
            'second_supervisor' => 0,
            'total_supervision' => 0,
            'total_supervision_color' => 'red',
            'stages' => [
                'Registration' => 0,
                'Proposal Defense' => 0,
                'Re-Proposal Defense' => 0,
                'Pre-Viva' => 0,
            ],
        ];

        $stageNameToId = [];

        if ($supervisorId) {
            $roleRows = (clone $baseQuery)
                ->select([
                    'sv.sv_role',
                    'cnt' => 'COUNT(DISTINCT sv.student_id)',
                ])
                ->groupBy(['sv.sv_role'])
                ->asArray()
                ->all();

            foreach ($roleRows as $rRow) {
                $role = (int)($rRow['sv_role'] ?? 0);
                $cnt = (int)($rRow['cnt'] ?? 0);
                if ($role === 1) {
                    $stats['main_supervisor'] = $cnt;
                }
                if ($role === 2) {
                    $stats['second_supervisor'] = $cnt;
                }
            }

            $stats['total_supervision'] = (int)$stats['main_supervisor'] + (int)$stats['second_supervisor'];
            $stats['total_supervision_color'] = PgSetting::classifyTrafficLight('supervisor', (int)$stats['total_supervision']);

            $wantedStages = array_keys($stats['stages']);
            $stageRows = ResearchStage::find()
                ->select(['id', 'stage_name'])
                ->where(['stage_name' => $wantedStages])
                ->asArray()
                ->all();

            foreach ($stageRows as $sRow) {
                $name = (string)($sRow['stage_name'] ?? '');
                if ($name !== '') {
                    $stageNameToId[$name] = (int)$sRow['id'];
                }
            }

            if ($stageNameToId) {
                $stageCounts = (clone $baseQuery)
                    ->select([
                        'stg.stage_id',
                        'cnt' => 'COUNT(DISTINCT sv.student_id)',
                    ])
                    ->andWhere(['stg.stage_id' => array_values($stageNameToId)])
                    ->groupBy(['stg.stage_id'])
                    ->asArray()
                    ->all();

                $idToName = array_flip($stageNameToId);
                foreach ($stageCounts as $cRow) {
                    $id = (int)($cRow['stage_id'] ?? 0);
                    $cnt = (int)($cRow['cnt'] ?? 0);
                    if (isset($idToName[$id])) {
                        $stats['stages'][$idToName[$id]] = $cnt;
                    }
                }
            }
        }

        if (!$supervisorId) {
            $baseQuery->andWhere('0=1');
        }

        $query = clone $baseQuery;

        if (in_array($svRole, [1, 2], true)) {
            $query->andWhere(['sv.sv_role' => $svRole]);
        }

        if ($stageId > 0) {
            $query->andWhere(['stg.stage_id' => $stageId]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => [
                'defaultOrder' => [
                    'student_name' => SORT_ASC,
                ],
                'attributes' => [
                    'student_name' => [
                        'asc' => ['u.fullname' => SORT_ASC],
                        'desc' => ['u.fullname' => SORT_DESC],
                    ],
                    'matric_no' => [
                        'asc' => ['s.matric_no' => SORT_ASC],
                        'desc' => ['s.matric_no' => SORT_DESC],
                    ],
                    'sv_role' => [
                        'asc' => ['sv.sv_role' => SORT_ASC],
                        'desc' => ['sv.sv_role' => SORT_DESC],
                    ],
                    'stage_name' => [
                        'asc' => ['rs.stage_name_en' => SORT_ASC, 'rs.stage_name' => SORT_ASC],
                        'desc' => ['rs.stage_name_en' => SORT_DESC, 'rs.stage_name' => SORT_DESC],
                    ],
                    'status_daftar' => [
                        'asc' => ['r.status_daftar' => SORT_ASC],
                        'desc' => ['r.status_daftar' => SORT_DESC],
                    ],
                ],
            ],
        ]);

        return $this->render('/student/mystudents', [
            'dataProvider' => $dataProvider,
            'semesterId' => $semesterId,
            'stats' => $stats,
            'stageNameToId' => $stageNameToId,
        ]);
    }

    public function actionView($id)
    {
        $user = Yii::$app->user->identity;
        $staff = $user && isset($user->staff) ? $user->staff : null;

        $supervisorId = null;
        if ($staff) {
            $supervisorId = Supervisor::find()
                ->select(['id'])
                ->where(['staff_id' => $staff->id])
                ->scalar();
        }

        if (!$supervisorId) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $isMine = StudentSupervisor::find()
            ->where([
                'student_id' => (int)$id,
                'supervisor_id' => (int)$supervisorId,
            ])
            ->exists();

        if (!$isMine) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = Student::findOne((int)$id);
        if (!$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $latestReg = StudentRegister::find()
            ->where(['student_id' => (int)$model->id])
            ->andWhere(['not', ['status_daftar' => null]])
            ->orderBy(['semester_id' => SORT_DESC, 'id' => SORT_DESC])
            ->one();
        $model->last_status_daftar = $latestReg ? $latestReg->status_daftar : null;

        $semesterId = (int)Yii::$app->request->get('semester_id', 0);
        if (!$semesterId) {
            $currentSem = Semester::getCurrentSemester();
            if ($currentSem) {
                $semesterId = (int)$currentSem->id;
            }
        }

        if ($semesterId) {
            $reg = StudentRegister::find()->where([
                'student_id' => (int)$model->id,
                'semester_id' => (int)$semesterId,
            ])->one();

            $model->status_daftar = $reg ? $reg->status_daftar : null;
            $model->status_aktif = $reg ? $reg->status_aktif : null;
        } else {
            $model->status_daftar = null;
            $model->status_aktif = null;
        }

        $semesters = $model->studentSemesters;
        $supervisors = $model->supervisors;
        $stages = $model->stages;

        return $this->render('/student/view', [
            'model' => $model,
            'semesters' => $semesters,
            'supervisors' => $supervisors,
            'stages' => $stages
        ]);
    }

    public function actionStats()
    {
        $user = Yii::$app->user->identity;
        $staff = $user && isset($user->staff) ? $user->staff : null;

        $semesterId = (int)Yii::$app->request->get('semester_id', 0);
        if (!$semesterId) {
            $currentSemester = Semester::getCurrentSemester();
            $semesterId = $currentSemester ? (int)$currentSemester->id : 0;
        }

        if (!$staff) {
            $activeCount = 0;
            $mainSupervisorCount = 0;
            $secondSupervisorCount = 0;
            $committeeStats = ['chairman' => 0, 'deputy' => 0, 'examiner1' => 0, 'examiner2' => 0, 'total' => 0, 'total_color' => 'red'];
            $studyMode = [1 => 0, 2 => 0];
            $programLevel = ['master' => 0, 'phd' => 0];
            $years = [];
            $byCountryRows = [];
            $countries = [];
            $byFieldRows = [];
            $overallRc = ['research' => 0, 'coursework' => 0];
            $localCount = 0;
            $internationalCount = 0;
            $masterRc = ['research' => 0, 'coursework' => 0];
            $phdModes = [1 => 0, 2 => 0];

            return $this->render('/student/mystats', [
                'semester_id' => $semesterId,
                'activeCount' => $activeCount,
                'mainSupervisorCount' => $mainSupervisorCount,
                'secondSupervisorCount' => $secondSupervisorCount,
                'committeeStats' => $committeeStats,
                'studyMode' => $studyMode,
                'programLevel' => $programLevel,
                'years' => $years,
                'byCountryRows' => $byCountryRows,
                'countries' => $countries,
                'byFieldRows' => $byFieldRows,
                'overallRc' => $overallRc,
                'localCount' => $localCount,
                'internationalCount' => $internationalCount,
                'masterRc' => $masterRc,
                'phdModes' => $phdModes,
            ]);
        }

        $supervisor = Supervisor::find()
            ->where(['staff_id' => $staff->id])
            ->one();

        if (!$supervisor) {
            $activeCount = 0;
            $mainSupervisorCount = 0;
            $secondSupervisorCount = 0;
            $committeeStats = ['chairman' => 0, 'deputy' => 0, 'examiner1' => 0, 'examiner2' => 0, 'total' => 0, 'total_color' => 'red'];
            $studyMode = [1 => 0, 2 => 0];
            $programLevel = ['master' => 0, 'phd' => 0];
            $years = [];
            $byCountryRows = [];
            $countries = [];
            $byFieldRows = [];
            $overallRc = ['research' => 0, 'coursework' => 0];
            $localCount = 0;
            $internationalCount = 0;
            $masterRc = ['research' => 0, 'coursework' => 0];
            $phdModes = [1 => 0, 2 => 0];

            return $this->render('/student/mystats', [
                'semester_id' => $semesterId,
                'activeCount' => $activeCount,
                'mainSupervisorCount' => $mainSupervisorCount,
                'secondSupervisorCount' => $secondSupervisorCount,
                'committeeStats' => $committeeStats,
                'studyMode' => $studyMode,
                'programLevel' => $programLevel,
                'years' => $years,
                'byCountryRows' => $byCountryRows,
                'countries' => $countries,
                'byFieldRows' => $byFieldRows,
                'overallRc' => $overallRc,
                'localCount' => $localCount,
                'internationalCount' => $internationalCount,
                'masterRc' => $masterRc,
                'phdModes' => $phdModes,
            ]);
        }

        $studentTable = Student::tableName();
        $svTable = StudentSupervisor::tableName();
        $regTable = StudentRegister::tableName();
        $semesterId = $semesterId ?: null;

        $mainSupervisorCount = 0;
        $secondSupervisorCount = 0;
        $roleRows = (new \yii\db\Query())
            ->select(['ss.sv_role', 'cnt' => 'COUNT(DISTINCT s.id)'])
            ->from(['s' => $studentTable])
            ->innerJoin(['ss' => $svTable], 'ss.student_id = s.id')
            ->innerJoin(['sr' => $regTable], 'sr.student_id = s.id' . ($semesterId ? ' AND sr.semester_id = ' . $semesterId : ''))
            ->where([
                'ss.supervisor_id' => $supervisor->id,
                'sr.status_aktif' => StudentRegister::STATUS_AKTIF_AKTIF,
                'ss.sv_role' => [1, 2],
            ])
            ->groupBy(['ss.sv_role'])
            ->all();
        foreach ($roleRows as $rr) {
            $role = (int)($rr['sv_role'] ?? 0);
            $cnt = (int)($rr['cnt'] ?? 0);
            if ($role === 1) { $mainSupervisorCount = $cnt; }
            if ($role === 2) { $secondSupervisorCount = $cnt; }
        }

        $committeeStats = [
            'chairman' => 0,
            'deputy' => 0,
            'examiner1' => 0,
            'examiner2' => 0,
            'total' => 0,
            'total_color' => 'red',
        ];

        if ($semesterId) {
            $committeeRows = StageExaminer::find()->alias('se')
                ->select([
                    'se.committee_role',
                    'cnt' => 'COUNT(*)',
                ])
                ->innerJoin(['stg' => StudentStage::tableName()], 'stg.id = se.stage_id')
                ->where([
                    'se.examiner_id' => (int)$supervisor->id,
                    'stg.semester_id' => (int)$semesterId,
                    'se.committee_role' => [1, 2, 3, 4],
                ])
                ->groupBy(['se.committee_role'])
                ->asArray()
                ->all();

            foreach ($committeeRows as $r) {
                $role = (int)($r['committee_role'] ?? 0);
                $cnt = (int)($r['cnt'] ?? 0);
                if ($role === 1) { $committeeStats['chairman'] = $cnt; }
                if ($role === 2) { $committeeStats['deputy'] = $cnt; }
                if ($role === 3) { $committeeStats['examiner1'] = $cnt; }
                if ($role === 4) { $committeeStats['examiner2'] = $cnt; }
                $committeeStats['total'] += $cnt;
            }

            $committeeStats['total_color'] = PgSetting::classifyTrafficLight('exam_committee', (int)$committeeStats['total']);
        }

        $activeCount = (int) (new \yii\db\Query())
            ->from(['s' => $studentTable])
            ->innerJoin(['ss' => $svTable], 'ss.student_id = s.id')
            ->innerJoin(['sr' => $regTable], 'sr.student_id = s.id' . ($semesterId ? ' AND sr.semester_id = ' . $semesterId : ''))
            ->where([
                'ss.supervisor_id' => $supervisor->id,
                'sr.status_aktif' => StudentRegister::STATUS_AKTIF_AKTIF,
            ])
            ->count('*');

        $modeRows = (new \yii\db\Query())
            ->select(['s.study_mode', 'cnt' => 'COUNT(*)'])
            ->from(['s' => $studentTable])
            ->innerJoin(['ss' => $svTable], 'ss.student_id = s.id')
            ->innerJoin(['sr' => $regTable], 'sr.student_id = s.id' . ($semesterId ? ' AND sr.semester_id = ' . $semesterId : ''))
            ->where([
                'ss.supervisor_id' => $supervisor->id,
                'sr.status_aktif' => StudentRegister::STATUS_AKTIF_AKTIF,
            ])
            ->groupBy(['s.study_mode'])
            ->all();
        $studyMode = [1 => 0, 2 => 0];
        foreach ($modeRows as $r) {
            if (!empty($r['study_mode'])) {
                $studyMode[(int)$r['study_mode']] = (int)$r['cnt'];
            }
        }

        $programLevel = ['master' => 0, 'phd' => 0];
        $levelRows = (new \yii\db\Query())
            ->select(['p.pro_level', 'cnt' => 'COUNT(*)'])
            ->from(['s' => $studentTable])
            ->innerJoin(['ss' => $svTable], 'ss.student_id = s.id')
            ->innerJoin(['sr' => $regTable], 'sr.student_id = s.id' . ($semesterId ? ' AND sr.semester_id = ' . $semesterId : ''))
            ->leftJoin(['p' => Program::tableName()], 'p.id = s.program_id')
            ->where([
                'ss.supervisor_id' => $supervisor->id,
                'sr.status_aktif' => StudentRegister::STATUS_AKTIF_AKTIF,
                'p.pro_level' => [3, 4],
            ])
            ->groupBy(['p.pro_level'])
            ->all();
        foreach ($levelRows as $r) {
            if ((int)$r['pro_level'] === 3) { $programLevel['master'] = (int)$r['cnt']; }
            if ((int)$r['pro_level'] === 4) { $programLevel['phd'] = (int)$r['cnt']; }
        }

        $years = (new \yii\db\Query())
            ->select(['s.admission_year', 'cnt' => 'COUNT(*)'])
            ->from(['s' => $studentTable])
            ->innerJoin(['ss' => $svTable], 'ss.student_id = s.id')
            ->innerJoin(['sr' => $regTable], 'sr.student_id = s.id' . ($semesterId ? ' AND sr.semester_id = ' . $semesterId : ''))
            ->where([
                'ss.supervisor_id' => $supervisor->id,
                'sr.status_aktif' => StudentRegister::STATUS_AKTIF_AKTIF,
            ])
            ->andWhere(['not', ['s.admission_year' => null]])
            ->groupBy(['s.admission_year'])
            ->orderBy(['s.admission_year' => SORT_DESC])
            ->limit(5)
            ->all();

        $byCountryRows = (new \yii\db\Query())
            ->select([
                's.nationality',
                'cnt' => "SUM(CASE WHEN s.study_mode_rc IN ('research','coursework') THEN 1 ELSE 0 END)",
                'research_cnt' => "SUM(CASE WHEN s.study_mode_rc = 'research' THEN 1 ELSE 0 END)",
                'coursework_cnt' => "SUM(CASE WHEN s.study_mode_rc = 'coursework' THEN 1 ELSE 0 END)",
            ])
            ->from(['s' => $studentTable])
            ->innerJoin(['ss' => $svTable], 'ss.student_id = s.id')
            ->innerJoin(['sr' => $regTable], 'sr.student_id = s.id' . ($semesterId ? ' AND sr.semester_id = ' . $semesterId : ''))
            ->where([
                'ss.supervisor_id' => $supervisor->id,
                'sr.status_aktif' => StudentRegister::STATUS_AKTIF_AKTIF,
            ])
            ->groupBy(['s.nationality'])
            ->all();
        $countryIds = [];
        foreach ($byCountryRows as $r) { if (!empty($r['nationality'])) { $countryIds[] = (int)$r['nationality']; } }
        $countries = [];
        if ($countryIds) {
            $countries = Country::find()->where(['id' => $countryIds])->indexBy('id')->all();
        }

        $byFieldRows = (new \yii\db\Query())
            ->select([
                's.field_id',
                'cnt' => 'COUNT(*)',
            ])
            ->from(['s' => $studentTable])
            ->innerJoin(['ss' => $svTable], 'ss.student_id = s.id')
            ->innerJoin(['sr' => $regTable], 'sr.student_id = s.id' . ($semesterId ? ' AND sr.semester_id = ' . $semesterId : ''))
            ->where([
                'ss.supervisor_id' => $supervisor->id,
                'sr.status_aktif' => StudentRegister::STATUS_AKTIF_AKTIF,
            ])
            ->groupBy(['s.field_id'])
            ->all();
        $fieldIds = [];
        foreach ($byFieldRows as $r) { if (!empty($r['field_id'])) { $fieldIds[] = (int)$r['field_id']; } }
        $fields = [];
        if ($fieldIds) {
            $fields = Field::find()->where(['id' => $fieldIds])->indexBy('id')->all();
        }

        $rcRows = (new \yii\db\Query())
            ->select(['s.study_mode_rc', 'cnt' => 'COUNT(*)'])
            ->from(['s' => $studentTable])
            ->innerJoin(['ss' => $svTable], 'ss.student_id = s.id')
            ->innerJoin(['sr' => $regTable], 'sr.student_id = s.id' . ($semesterId ? ' AND sr.semester_id = ' . $semesterId : ''))
            ->where([
                'ss.supervisor_id' => $supervisor->id,
                'sr.status_aktif' => StudentRegister::STATUS_AKTIF_AKTIF,
            ])
            ->andWhere(['s.study_mode_rc' => ['research', 'coursework']])
            ->groupBy(['s.study_mode_rc'])
            ->all();
        $overallRc = ['research' => 0, 'coursework' => 0];
        foreach ($rcRows as $r) {
            $key = (string)$r['study_mode_rc'];
            if (isset($overallRc[$key])) { $overallRc[$key] = (int)$r['cnt']; }
        }

        $localCount = (int) (new \yii\db\Query())
            ->from(['s' => $studentTable])
            ->innerJoin(['ss' => $svTable], 'ss.student_id = s.id')
            ->innerJoin(['sr' => $regTable], 'sr.student_id = s.id' . ($semesterId ? ' AND sr.semester_id = ' . $semesterId : ''))
            ->where([
                'ss.supervisor_id' => $supervisor->id,
                'sr.status_aktif' => StudentRegister::STATUS_AKTIF_AKTIF,
                's.nationality' => 158,
            ])
            ->count('*');
        $internationalCount = max(0, $activeCount - $localCount);

        $masterRows = (new \yii\db\Query())
            ->select([
                's.study_mode_rc',
                'cnt' => 'COUNT(*)',
            ])
            ->from(['s' => $studentTable])
            ->innerJoin(['ss' => $svTable], 'ss.student_id = s.id')
            ->innerJoin(['sr' => $regTable], 'sr.student_id = s.id' . ($semesterId ? ' AND sr.semester_id = ' . $semesterId : ''))
            ->leftJoin(['p' => Program::tableName()], 'p.id = s.program_id')
            ->where([
                'ss.supervisor_id' => $supervisor->id,
                'sr.status_aktif' => StudentRegister::STATUS_AKTIF_AKTIF,
                'p.pro_level' => 3,
            ])
            ->andWhere(['s.study_mode_rc' => ['research', 'coursework']])
            ->groupBy(['s.study_mode_rc'])
            ->all();
        $masterRc = ['research' => 0, 'coursework' => 0];
        foreach ($masterRows as $r) {
            $key = (string)$r['study_mode_rc'];
            if (isset($masterRc[$key])) { $masterRc[$key] = (int)$r['cnt']; }
        }

        $phdModeRows = (new \yii\db\Query())
            ->select(['s.study_mode', 'cnt' => 'COUNT(*)'])
            ->from(['s' => $studentTable])
            ->innerJoin(['ss' => $svTable], 'ss.student_id = s.id')
            ->innerJoin(['sr' => $regTable], 'sr.student_id = s.id' . ($semesterId ? ' AND sr.semester_id = ' . $semesterId : ''))
            ->leftJoin(['p' => Program::tableName()], 'p.id = s.program_id')
            ->where([
                'ss.supervisor_id' => $supervisor->id,
                'sr.status_aktif' => StudentRegister::STATUS_AKTIF_AKTIF,
                'p.pro_level' => 4,
            ])
            ->groupBy(['s.study_mode'])
            ->all();
        $phdModes = [1 => 0, 2 => 0];
        foreach ($phdModeRows as $r) {
            if (!empty($r['study_mode'])) {
                $phdModes[(int)$r['study_mode']] = (int)$r['cnt'];
            }
        }

        return $this->render('/student/mystats', [
            'semester_id' => $semesterId,
            'activeCount' => $activeCount,
            'mainSupervisorCount' => $mainSupervisorCount,
            'secondSupervisorCount' => $secondSupervisorCount,
            'committeeStats' => $committeeStats,
            'studyMode' => $studyMode,
            'programLevel' => $programLevel,
            'years' => $years,
            'byCountryRows' => $byCountryRows,
            'countries' => $countries,
            'byFieldRows' => $byFieldRows,
            'fields' => $fields,
            'overallRc' => $overallRc,
            'localCount' => $localCount,
            'internationalCount' => $internationalCount,
            'masterRc' => $masterRc,
            'phdModes' => $phdModes,
        ]);
    }
}
