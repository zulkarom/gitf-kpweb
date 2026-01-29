<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\db\IntegrityException;
use common\models\User;
use common\models\Country;
use backend\modules\esiap\models\Program;
use backend\modules\postgrad\models\Field;
use backend\modules\postgrad\models\Student;
use backend\modules\postgrad\models\StudentRegister;
use backend\modules\postgrad\models\StudentData;
use backend\modules\postgrad\models\StudentData2;
use backend\modules\postgrad\models\StudentData4;
use backend\modules\postgrad\models\StudentPostGradSearch;
use backend\modules\postgrad\models\StudentMasterSearch;
use backend\modules\postgrad\models\Supervisor;
use backend\modules\postgrad\models\StudentSupervisor;
use backend\modules\postgrad\models\StageExaminer;
use backend\modules\postgrad\models\StudentStage;
use backend\modules\postgrad\models\PgStudentThesis;
use backend\modules\postgrad\models\PgSetting;
use backend\models\Semester;
use yii\db\Query;
use backend\modules\staff\models\Staff;

/**
 * StudentPostGradController implements the CRUD actions for StudentPostGrad model.
 */
class StudentController extends Controller
{
    /**
     * {@inheritdoc}
     */
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

    /**
     * Lists all StudentPostGrad models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;
        if (!isset($params['StudentPostGradSearch'])) {
            $params['StudentPostGradSearch'] = [];
        }
        if (!array_key_exists('study_mode_rc', $params['StudentPostGradSearch'])) {
            $params['StudentPostGradSearch']['study_mode_rc'] = 'research';
        }

        $searchModel = new StudentPostGradSearch();
        $dataProvider = $searchModel->search($params);

        if ((int)Yii::$app->request->get('debug_sql') === 1) {
            $sql = $dataProvider->query->createCommand()->rawSql;
            header('Content-Type: text/plain; charset=utf-8');
            echo $sql;
            Yii::$app->end();
        }

        $dataProvider->pagination->params = $params;
        $dataProvider->sort->params = $params;

        $semesterId = (int)$searchModel->semester_id;
        $statusDaftarSummary = [];
        if ($semesterId) {
            $statusDaftarSummary = (new Query())
                ->select([
                    'status_daftar' => 'r.status_daftar',
                    'total' => 'COUNT(DISTINCT r.student_id)',
                ])
                ->from(['r' => StudentRegister::tableName()])
                ->innerJoin(['s' => Student::tableName()], 's.id = r.student_id')
                ->where(['r.semester_id' => $semesterId])
                ->andWhere("LOWER(s.study_mode_rc) = 'research'")
                ->groupBy(['r.status_daftar'])
                ->orderBy(['total' => SORT_DESC])
                ->all();
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusDaftarSummary' => $statusDaftarSummary,
        ]);
    }

    public function actionMaster()
    {
        $params = Yii::$app->request->queryParams;
        if (!isset($params['StudentMasterSearch'])) {
            $params['StudentMasterSearch'] = [];
        }

        $searchModel = new StudentMasterSearch();
        $dataProvider = $searchModel->search($params);

        $dataProvider->pagination->params = $params;
        $dataProvider->sort->params = $params;

        $statusDaftarSummary = (new Query())
            ->select([
                'status_daftar' => 's.last_status_daftar',
                'total' => 'COUNT(*)',
            ])
            ->from(['s' => Student::tableName()])
            ->groupBy(['s.last_status_daftar'])
            ->orderBy(['total' => SORT_DESC])
            ->all();

        return $this->render('master', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusDaftarSummary' => $statusDaftarSummary,
        ]);
    }

    /**
     * Entry point for the "My Students" menu.
     * Shows only students under the logged-in staff's supervision.
     * Route: /postgrad/student/mystudents
     */
    public function actionMystudents()
    {
        $user = Yii::$app->user->identity;
        $staff = $user && isset($user->staff) ? $user->staff : null;

        $searchModel = new StudentPostGradSearch();

        $query = Student::find()->alias('s')
            ->joinWith(['supervisors sv'])
            ->where(['s.status' => Student::STATUS_ACTIVE]);

        if ($staff) {
            $supervisor = Supervisor::find()
                ->where(['staff_id' => $staff->id])
                ->one();

            if ($supervisor) {
                $query->andWhere(['sv.supervisor_id' => $supervisor->id]);
            } else {
                $query->andWhere('0=1');
            }
        } else {
            $query->andWhere('0=1');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('mystudents', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Students filtered by study_mode_rc = research
     */
    public function actionResearch()
    {
        $semesterId = Yii::$app->request->get('semester_id');
        return $this->redirect([
            'index',
            'semester_id' => $semesterId,
            'StudentPostGradSearch' => [
                'study_mode_rc' => 'research',
            ],
        ]);
    }

    /**
     * Students filtered by study_mode_rc = coursework
     */
    public function actionCoursework()
    {
        $semesterId = Yii::$app->request->get('semester_id');
        return $this->redirect([
            'index',
            'semester_id' => $semesterId,
            'StudentPostGradSearch' => [
                'study_mode_rc' => 'coursework',
            ],
        ]);
    }

    /**
     * Students filtered by status = not active
     */
    public function actionInactive()
    {
        $semesterId = Yii::$app->request->get('semester_id');
        return $this->redirect([
            'index',
            'semester_id' => $semesterId,
            'StudentPostGradSearch' => [
                'status' => Student::STATUS_NOT_ACTIVE,
            ],
        ]);
    }

    public function actionCombined($tab = 'research')
    {
        return $this->redirect(['index']);
    }

    public function actionStats()
    {
        $semesterId = (int)Yii::$app->request->get('semester_id', 0);
        if (!$semesterId) {
            $currentSem = Semester::getCurrentSemester();
            if ($currentSem) {
                $semesterId = (int)$currentSem->id;
            }
        }

        // Overall research count (selected semester, includes Aktif + Tidak Aktif)
        $activeCount = (int) (new \yii\db\Query())
            ->from(['r' => StudentRegister::tableName()])
            ->innerJoin(['s' => Student::tableName()], 's.id = r.student_id')
            ->where(['r.semester_id' => (int)$semesterId])
            ->andWhere("LOWER(s.study_mode_rc) = 'research'")
            ->count('*');

        // Breakdown by status_daftar (research only, includes Aktif + Tidak Aktif)
        $statusDaftarRows = (new \yii\db\Query())
            ->select(['r.status_daftar', 'cnt' => 'COUNT(*)'])
            ->from(['r' => StudentRegister::tableName()])
            ->innerJoin(['s' => Student::tableName()], 's.id = r.student_id')
            ->where(['r.semester_id' => (int)$semesterId])
            ->andWhere("LOWER(s.study_mode_rc) = 'research'")
            ->groupBy(['r.status_daftar'])
            ->orderBy(['cnt' => SORT_DESC])
            ->all();

        // Breakdown by status_aktif (research only)
        $statusAktifRows = (new \yii\db\Query())
            ->select(['r.status_aktif', 'cnt' => 'COUNT(*)'])
            ->from(['r' => StudentRegister::tableName()])
            ->innerJoin(['s' => Student::tableName()], 's.id = r.student_id')
            ->where(['r.semester_id' => (int)$semesterId])
            ->andWhere("LOWER(s.study_mode_rc) = 'research'")
            ->groupBy(['r.status_aktif'])
            ->orderBy(['cnt' => SORT_DESC])
            ->all();

        // Study mode breakdown (1: Full-time, 2: Part-time) (research only)
        $modeRows = (new \yii\db\Query())
            ->select(['s.study_mode', 'cnt' => 'COUNT(*)'])
            ->from(['r' => StudentRegister::tableName()])
            ->innerJoin(['s' => Student::tableName()], 's.id = r.student_id')
            ->where(['r.semester_id' => (int)$semesterId])
            ->andWhere("LOWER(s.study_mode_rc) = 'research'")
            ->groupBy(['s.study_mode'])
            ->all();
        $studyMode = [1 => 0, 2 => 0];
        foreach ($modeRows as $r) {
            if (!empty($r['study_mode'])) {
                $studyMode[(int)$r['study_mode']] = (int)$r['cnt'];
            }
        }

        // Program level breakdown: Master (pro_level=3), PhD (pro_level=4) (research only)
        $programLevel = ['master' => 0, 'phd' => 0];
        $levelRows = (new \yii\db\Query())
            ->select(['p.pro_level', 'cnt' => 'COUNT(*)'])
            ->from(['r' => StudentRegister::tableName()])
            ->innerJoin(['s' => Student::tableName()], 's.id = r.student_id')
            ->leftJoin(['p' => Program::tableName()], 'p.id = s.program_id')
            ->where([
                'r.semester_id' => (int)$semesterId,
                'p.pro_level' => [3, 4],
            ])
            ->andWhere("LOWER(s.study_mode_rc) = 'research'")
            ->groupBy(['p.pro_level'])
            ->all();
        foreach ($levelRows as $r) {
            if ((int)$r['pro_level'] === 3) { $programLevel['master'] = (int)$r['cnt']; }
            if ((int)$r['pro_level'] === 4) { $programLevel['phd'] = (int)$r['cnt']; }
        }

        // Last 5 admission years (descending) (research only)
        $years = (new \yii\db\Query())
            ->select(['s.admission_year', 'cnt' => 'COUNT(*)'])
            ->from(['r' => StudentRegister::tableName()])
            ->innerJoin(['s' => Student::tableName()], 's.id = r.student_id')
            ->where(['r.semester_id' => (int)$semesterId])
            ->andWhere("LOWER(s.study_mode_rc) = 'research'")
            ->andWhere(['not', ['s.admission_year' => null]])
            ->groupBy(['s.admission_year'])
            ->orderBy(['s.admission_year' => SORT_DESC])
            ->limit(5)
            ->all();

        // By country (nationality) (research only)
        $byCountryRows = (new \yii\db\Query())
            ->select([
                'nationality' => 's.nationality',
                // Research-only totals by nationality
                'cnt' => "SUM(CASE WHEN LOWER(s.study_mode_rc) = 'research' THEN 1 ELSE 0 END)",
                'research_phd_cnt' => "SUM(CASE WHEN LOWER(s.study_mode_rc) = 'research' AND p.pro_level = 4 THEN 1 ELSE 0 END)",
                'research_master_cnt' => "SUM(CASE WHEN LOWER(s.study_mode_rc) = 'research' AND p.pro_level = 3 THEN 1 ELSE 0 END)",
            ])
            ->from(['r' => StudentRegister::tableName()])
            ->innerJoin(['s' => Student::tableName()], 's.id = r.student_id')
            ->leftJoin(['p' => Program::tableName()], 'p.id = s.program_id')
            ->where([
                'r.semester_id' => (int)$semesterId,
            ])
            ->andWhere(['not', ['s.nationality' => null]])
            ->groupBy(['s.nationality'])
            ->all();
        $countryIds = [];
        foreach ($byCountryRows as $r) { if (!empty($r['nationality'])) { $countryIds[] = (int)$r['nationality']; } }
        $countries = [];
        if ($countryIds) {
            $countries = Country::find()->where(['id' => $countryIds])->indexBy('id')->all();
        }

        // By field of study (research only)
        $byFieldRows = (new \yii\db\Query())
            ->select([
                's.field_id',
                'cnt' => 'COUNT(*)',
                'phd_cnt' => "SUM(CASE WHEN p.pro_level = 4 THEN 1 ELSE 0 END)",
                'master_cnt' => "SUM(CASE WHEN p.pro_level = 3 THEN 1 ELSE 0 END)",
            ])
            ->from(['r' => StudentRegister::tableName()])
            ->innerJoin(['s' => Student::tableName()], 's.id = r.student_id')
            ->leftJoin(['p' => Program::tableName()], 'p.id = s.program_id')
            ->where(['r.semester_id' => (int)$semesterId])
            ->andWhere("LOWER(s.study_mode_rc) = 'research'")
            ->groupBy(['s.field_id'])
            ->all();
        $fieldIds = [];
        foreach ($byFieldRows as $r) { if (!empty($r['field_id'])) { $fieldIds[] = (int)$r['field_id']; } }
        $fields = [];
        if ($fieldIds) {
            $fields = Field::find()->where(['id' => $fieldIds])->indexBy('id')->all();
        }

        // Additional stats for top cards
        // 1) Overall Research vs Coursework (research only - for display consistency)
        $overallRc = ['research' => $activeCount, 'coursework' => 0];

        // 2) Local (Malaysia id=158) vs International (research only, includes Aktif + Tidak Aktif)
        $localCount = (int) (new \yii\db\Query())
            ->from(['r' => StudentRegister::tableName()])
            ->innerJoin(['s' => Student::tableName()], 's.id = r.student_id')
            ->where([
                'r.semester_id' => (int)$semesterId,
                's.nationality' => 158,
            ])
            ->andWhere("LOWER(s.study_mode_rc) = 'research'")
            ->count('*');
        $internationalCount = max(0, (int)($overallRc['research'] ?? 0) - $localCount);

        // 3) Master's (pro_level=3) Research vs Coursework (research only)
        $masterRcRows = (new \yii\db\Query())
            ->select(['s.study_mode_rc', 'cnt' => 'COUNT(*)'])
            ->from(['r' => StudentRegister::tableName()])
            ->innerJoin(['s' => Student::tableName()], 's.id = r.student_id')
            ->leftJoin(['p' => Program::tableName()], 'p.id = s.program_id')
            ->where([
                'r.semester_id' => (int)$semesterId,
                'p.pro_level' => 3,
            ])
            ->andWhere("LOWER(s.study_mode_rc) = 'research'")
            ->groupBy(['s.study_mode_rc'])
            ->all();
        $masterRc = ['research' => 0, 'coursework' => 0];
        foreach ($masterRcRows as $r) {
            $key = (string)$r['study_mode_rc'];
            if (isset($masterRc[$key])) { $masterRc[$key] = (int)$r['cnt']; }
        }

        // 3b) Master's (pro_level=3) Full-time vs Part-time (research only)
        $masterModeRows = (new \yii\db\Query())
            ->select(['s.study_mode', 'cnt' => 'COUNT(*)'])
            ->from(['r' => StudentRegister::tableName()])
            ->innerJoin(['s' => Student::tableName()], 's.id = r.student_id')
            ->leftJoin(['p' => Program::tableName()], 'p.id = s.program_id')
            ->where([
                'r.semester_id' => (int)$semesterId,
                'p.pro_level' => 3,
            ])
            ->andWhere("LOWER(s.study_mode_rc) = 'research'")
            ->groupBy(['s.study_mode'])
            ->all();
        $masterModes = [1 => 0, 2 => 0];
        foreach ($masterModeRows as $r) {
            if (!empty($r['study_mode'])) {
                $masterModes[(int)$r['study_mode']] = (int)$r['cnt'];
            }
        }

        // 4) PhD (pro_level=4) Full-time vs Part-time (research only)
        $phdModeRows = (new \yii\db\Query())
            ->select(['s.study_mode', 'cnt' => 'COUNT(*)'])
            ->from(['r' => StudentRegister::tableName()])
            ->innerJoin(['s' => Student::tableName()], 's.id = r.student_id')
            ->leftJoin(['p' => Program::tableName()], 'p.id = s.program_id')
            ->where([
                'r.semester_id' => (int)$semesterId,
                'p.pro_level' => 4,
            ])
            ->andWhere("LOWER(s.study_mode_rc) = 'research'")
            ->groupBy(['s.study_mode'])
            ->all();
        $phdModes = [1 => 0, 2 => 0];
        foreach ($phdModeRows as $r) {
            if (!empty($r['study_mode'])) {
                $phdModes[(int)$r['study_mode']] = (int)$r['cnt'];
            }
        }

        $supervisorTraffic = ['green' => 0, 'yellow' => 0, 'red' => 0];
        $supervisorRanges = PgSetting::trafficLightRanges('supervisor');
        $supervisorRows = (new Query())
            ->select(['a.id AS sid', 'COUNT(sr.id) AS total'])
            ->from(['a' => Supervisor::tableName()])
            ->innerJoin(['stf' => Staff::tableName()], 'stf.id = a.staff_id AND stf.faculty_id = 1 AND stf.staff_active = 1')
            ->leftJoin(['ss' => 'pg_student_sv'], 'ss.supervisor_id = a.id')
            ->leftJoin(['sr' => StudentRegister::tableName()], 'sr.student_id = ss.student_id AND sr.semester_id = :sem', [':sem' => (int)$semesterId])
            ->groupBy(['a.id'])
            ->all();
        foreach ($supervisorRows as $r) {
            $t = (int)($r['total'] ?? 0);
            $color = PgSetting::classifyTrafficLight('supervisor', $t);
            if (isset($supervisorTraffic[$color])) {
                $supervisorTraffic[$color]++;
            }
        }

        $committeeTraffic = ['green' => 0, 'yellow' => 0, 'red' => 0];
        $committeeRanges = PgSetting::trafficLightRanges('exam_committee');
        $committeeSupervisors = Supervisor::find()->alias('sv')
            ->innerJoin(['stf' => Staff::tableName()], 'stf.id = sv.staff_id')
            ->where(['sv.is_internal' => 1, 'stf.faculty_id' => 1, 'stf.staff_active' => 1])
            ->indexBy('id')
            ->all();
        $committeeTotalsBySv = [];
        if (!empty($committeeSupervisors)) {
            $ids = array_keys($committeeSupervisors);
            $committeeRows = (new Query())
                ->select([
                    'supervisor_id' => 'se.examiner_id',
                    'total' => "SUM(CASE WHEN se.committee_role IN (1,2,3,4) THEN 1 ELSE 0 END)",
                ])
                ->from(['se' => StageExaminer::tableName()])
                ->innerJoin(['st' => StudentStage::tableName()], 'st.id = se.stage_id')
                ->where([
                    'st.semester_id' => (int)$semesterId,
                    'se.examiner_id' => $ids,
                ])
                ->groupBy(['se.examiner_id'])
                ->all();
            foreach ($committeeRows as $r) {
                $committeeTotalsBySv[(int)$r['supervisor_id']] = (int)($r['total'] ?? 0);
            }
        }
        foreach ($committeeSupervisors as $sid => $sv) {
            $t = (int)($committeeTotalsBySv[(int)$sid] ?? 0);
            $color = PgSetting::classifyTrafficLight('exam_committee', $t);
            if (isset($committeeTraffic[$color])) {
                $committeeTraffic[$color]++;
            }
        }

        return $this->render('stats', [
            'semester_id' => $semesterId,
            'activeCount' => $activeCount,
            'studyMode' => $studyMode,
            'programLevel' => $programLevel,
            'years' => $years,
            'byCountryRows' => $byCountryRows,
            'countries' => $countries,
            'byFieldRows' => $byFieldRows,
            'fields' => $fields,
            // new stats for top cards
            'overallRc' => $overallRc,
            'localCount' => $localCount,
            'internationalCount' => $internationalCount,
            'masterRc' => $masterRc,
            'masterModes' => $masterModes,
            'phdModes' => $phdModes,
            'statusDaftarRows' => $statusDaftarRows,
            'statusAktifRows' => $statusAktifRows,
            'supervisorTraffic' => $supervisorTraffic,
            'committeeTraffic' => $committeeTraffic,
            'supervisorRanges' => $supervisorRanges,
            'committeeRanges' => $committeeRanges,
        ]);
    }

    /**
     * Entry point for the "My Stats" menu.
     * Reuses the existing stats page via redirect to keep logic in one place.
     * Route: /postgrad/student/mystats
     */
    public function actionMystats()
    {
        $user = Yii::$app->user->identity;
        $staff = $user && isset($user->staff) ? $user->staff : null;

        if (!$staff) {
            // no linked staff, show empty stats
            $activeCount = 0;
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

            return $this->render('mystats', [
                'activeCount' => $activeCount,
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
            // staff is not registered as supervisor, show empty stats
            $activeCount = 0;
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

            return $this->render('mystats', [
                'activeCount' => $activeCount,
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

        // Overall active count for this supervisor's students
        $activeCount = (int) (new \yii\db\Query())
            ->from(['s' => $studentTable])
            ->innerJoin(['ss' => $svTable], 'ss.student_id = s.id')
            ->where([
                'ss.supervisor_id' => $supervisor->id,
                's.status' => Student::STATUS_ACTIVE,
            ])
            ->count('*');

        // Study mode breakdown (1: Full-time, 2: Part-time)
        $modeRows = (new \yii\db\Query())
            ->select(['s.study_mode', 'cnt' => 'COUNT(*)'])
            ->from(['s' => $studentTable])
            ->innerJoin(['ss' => $svTable], 'ss.student_id = s.id')
            ->where([
                'ss.supervisor_id' => $supervisor->id,
                's.status' => Student::STATUS_ACTIVE,
            ])
            ->groupBy(['s.study_mode'])
            ->all();
        $studyMode = [1 => 0, 2 => 0];
        foreach ($modeRows as $r) {
            if (!empty($r['study_mode'])) {
                $studyMode[(int)$r['study_mode']] = (int)$r['cnt'];
            }
        }

        // Program level breakdown: Master (pro_level=3), PhD (pro_level=4)
        $programLevel = ['master' => 0, 'phd' => 0];
        $levelRows = (new \yii\db\Query())
            ->select(['p.pro_level', 'cnt' => 'COUNT(*)'])
            ->from(['s' => $studentTable])
            ->innerJoin(['ss' => $svTable], 'ss.student_id = s.id')
            ->leftJoin(['p' => Program::tableName()], 'p.id = s.program_id')
            ->where([
                'ss.supervisor_id' => $supervisor->id,
                's.status' => Student::STATUS_ACTIVE,
                'p.pro_level' => [3, 4],
            ])
            ->groupBy(['p.pro_level'])
            ->all();
        foreach ($levelRows as $r) {
            if ((int)$r['pro_level'] === 3) { $programLevel['master'] = (int)$r['cnt']; }
            if ((int)$r['pro_level'] === 4) { $programLevel['phd'] = (int)$r['cnt']; }
        }

        // Last 5 admission years (descending) for this supervisor's students
        $years = (new \yii\db\Query())
            ->select(['s.admission_year', 'cnt' => 'COUNT(*)'])
            ->from(['s' => $studentTable])
            ->innerJoin(['ss' => $svTable], 'ss.student_id = s.id')
            ->where([
                'ss.supervisor_id' => $supervisor->id,
                's.status' => Student::STATUS_ACTIVE,
            ])
            ->andWhere(['not', ['s.admission_year' => null]])
            ->groupBy(['s.admission_year'])
            ->orderBy(['s.admission_year' => SORT_DESC])
            ->limit(5)
            ->all();

        // By country (nationality) with study mode RC breakdown for this supervisor's students
        $byCountryRows = (new \yii\db\Query())
            ->select([
                's.nationality',
                'cnt' => "SUM(CASE WHEN s.study_mode_rc IN ('research','coursework') THEN 1 ELSE 0 END)",
                'research_cnt' => "SUM(CASE WHEN s.study_mode_rc = 'research' THEN 1 ELSE 0 END)",
                'coursework_cnt' => "SUM(CASE WHEN s.study_mode_rc = 'coursework' THEN 1 ELSE 0 END)",
            ])
            ->from(['s' => $studentTable])
            ->innerJoin(['ss' => $svTable], 'ss.student_id = s.id')
            ->where([
                'ss.supervisor_id' => $supervisor->id,
                's.status' => Student::STATUS_ACTIVE,
            ])
            ->andWhere(['not', ['s.nationality' => null]])
            ->groupBy(['s.nationality'])
            ->all();
        $countryIds = [];
        foreach ($byCountryRows as $r) { if (!empty($r['nationality'])) { $countryIds[] = (int)$r['nationality']; } }
        $countries = [];
        if ($countryIds) {
            $countries = Country::find()->where(['id' => $countryIds])->indexBy('id')->all();
        }

        // By field of study for this supervisor's students
        $byFieldRows = (new \yii\db\Query())
            ->select(['s.field_id', 'cnt' => 'COUNT(*)'])
            ->from(['s' => $studentTable])
            ->innerJoin(['ss' => $svTable], 'ss.student_id = s.id')
            ->where([
                'ss.supervisor_id' => $supervisor->id,
                's.status' => Student::STATUS_ACTIVE,
            ])
            ->groupBy(['s.field_id'])
            ->all();
        $fieldIds = [];
        foreach ($byFieldRows as $r) { if (!empty($r['field_id'])) { $fieldIds[] = (int)$r['field_id']; } }
        $fields = [];
        if ($fieldIds) {
            $fields = Field::find()->where(['id' => $fieldIds])->indexBy('id')->all();
        }

        // 1) Overall Research vs Coursework (active only) for this supervisor's students
        $rcRows = (new \yii\db\Query())
            ->select(['s.study_mode_rc', 'cnt' => 'COUNT(*)'])
            ->from(['s' => $studentTable])
            ->innerJoin(['ss' => $svTable], 'ss.student_id = s.id')
            ->where([
                'ss.supervisor_id' => $supervisor->id,
                's.status' => Student::STATUS_ACTIVE,
            ])
            ->andWhere(['s.study_mode_rc' => ['research', 'coursework']])
            ->groupBy(['s.study_mode_rc'])
            ->all();
        $overallRc = ['research' => 0, 'coursework' => 0];
        foreach ($rcRows as $r) {
            $key = (string)$r['study_mode_rc'];
            if (isset($overallRc[$key])) { $overallRc[$key] = (int)$r['cnt']; }
        }

        // 2) Local (Malaysia id=158) vs International for this supervisor's students
        $localCount = (int) (new \yii\db\Query())
            ->from(['s' => $studentTable])
            ->innerJoin(['ss' => $svTable], 'ss.student_id = s.id')
            ->where([
                'ss.supervisor_id' => $supervisor->id,
                's.status' => Student::STATUS_ACTIVE,
                's.nationality' => 158,
            ])
            ->count('*');
        $internationalCount = max(0, $activeCount - $localCount);

        // 3) Master's (pro_level=3) Research vs Coursework (active only) for this supervisor's students
        $masterRcRows = (new \yii\db\Query())
            ->select(['s.study_mode_rc', 'cnt' => 'COUNT(*)'])
            ->from(['s' => $studentTable])
            ->innerJoin(['ss' => $svTable], 'ss.student_id = s.id')
            ->leftJoin(['p' => Program::tableName()], 'p.id = s.program_id')
            ->where([
                'ss.supervisor_id' => $supervisor->id,
                's.status' => Student::STATUS_ACTIVE,
                'p.pro_level' => 3,
            ])
            ->andWhere(['s.study_mode_rc' => ['research', 'coursework']])
            ->groupBy(['s.study_mode_rc'])
            ->all();
        $masterRc = ['research' => 0, 'coursework' => 0];
        foreach ($masterRcRows as $r) {
            $key = (string)$r['study_mode_rc'];
            if (isset($masterRc[$key])) { $masterRc[$key] = (int)$r['cnt']; }
        }

        // 4) PhD (pro_level=4) Full-time vs Part-time (active only) study_mode: 1=full,2=part for this supervisor's students
        $phdModeRows = (new \yii\db\Query())
            ->select(['s.study_mode', 'cnt' => 'COUNT(*)'])
            ->from(['s' => $studentTable])
            ->innerJoin(['ss' => $svTable], 'ss.student_id = s.id')
            ->leftJoin(['p' => Program::tableName()], 'p.id = s.program_id')
            ->where([
                'ss.supervisor_id' => $supervisor->id,
                's.status' => Student::STATUS_ACTIVE,
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

        return $this->render('mystats', [
            'activeCount' => $activeCount,
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

   public function actionPutProgram(){
        $list = Student::find()->all();
        foreach($list as $s){
            if($s->program_code == 'DOK'){
                $s->program_id = 85;
                $s->save();
            }else if($s->program_code == 'SAR'){
                $s->program_id = 84;
                $s->save();
            }
        }
    }
    
    public function actionImport(){
        die();
        $list = StudentData::find()->all();
        foreach($list as $stud){
            //lets create user first 
            //how? 
            //check whether email  exist
            $student = new Student();
            
            $username = $stud->NO_MATRIK;
            $exist = User::findOne(['username' => $username]);
            if($exist){
                $user = $exist;
               
            }else{
                $user = new User();
                $user->username = $stud->NO_MATRIK;
                $random = rand(30,30000);
                $user->password_hash = \Yii::$app->security->generatePasswordHash($random);

                $user->email = $stud->EMEL_PELAJAR;
                
            }
            $user->fullname = $stud->NAMA_PELAJAR;
            $user->status = 10;
            if($user->save()){
                //for student data
                $student->user_id = $user->id;
                $student->matric_no = $stud->NO_MATRIK;
                $student->nric = str_replace("-","",$stud->NO_IC);
                $student->date_birth = date('Y-m-d', strtotime($stud->TARIKH_LAHIR));
                if($stud->TARAF_PERKAHWINAN == 'Berkahwin'){
                    $student->marital_status = 1;
                }else{
                    $student->marital_status = 2;
                }
                
                if($stud->JANTINA == 'LELAKI'){
                    $student->gender = 1;
                }else{
                    $student->gender = 0;
                }
                
                if($stud->NEGARA_ASAL == 'Malaysia'){
                    $student->nationality = 158;
                }else if($stud->NEGARA_ASAL == 'Pakistan'){
                    $student->nationality = 178;
                }else{
                    $student->nationality = 0;
                }
                
                if($stud->KEWARGANEGARAAN == 'Tempatan'){
                    $student->citizenship = 1;
                }else{
                    $student->citizenship = 2;
                }
                
                $student->program_code = $stud->KOD_PROGRAM;
                
                if($stud->TARAF_PENGAJIAN == 'Penuh Masa'){
                    $student->study_mode = 1;
                }else{
                    $student->study_mode = 2;
                }
                
                $student->address = $stud->ALAMAT;
                $student->city = $stud->DAERAH;
                $student->phone_no = $stud->NO_TELEFON;
                $student->personal_email = $stud->EMEL_PERSONAL;
                $student->religion = 1;
                $student->race = 1;
				
                $student->bachelor_name = $stud->NAMA_SARJANA_MUDA;
                $student->bachelor_university = $stud->UNIVERSITI_SARJANA_MUDA;
                $student->bachelor_cgpa = $stud->CGPA_SARJANA_MUDA;
				
				if($student->bachelor_year > 0){
					$student->bachelor_year = $stud->TAHUN_SARJANA_MUDA;
				}else{
					$student->bachelor_year = null;
				}
                
                
                $sesi = ['201920201' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '201920202' => 'SEMESTER FEBRUARI SESI AKADEMIK 2019/2020', '202020211' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '202020212' => 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021'];
                foreach($sesi as $key => $val){
                    if($stud->SESI_MASUK == $val){
                        $student->admission_semester = $key;
                    }
                }
                
                $student->admission_year = $stud->TAHUN_KEMASUKAN;
                $student->admission_date = date('Y-m-d', strtotime($stud->TARIKH_KEMASUKAN));
                $student->sponsor = $stud->PEMBIAYAAN;
                $student->current_sem = $stud->SEMESTER;
                $student->campus_id = 2;
                $student->status = 1;
                $student->save();
                
                
                
                
            }
            
            
           
            
            
        }
        
    } 
	
	
	/* public function actionBaikiData(){
        $list = StudentData4::find()->all();
        foreach($list as $stud){
			$matric = $stud->matric;
			$ori = StudentData2::findOne(['NO_MATRIK' => $matric]);
			$ori->TAHUN_KEMASUKAN = $stud->admission_year;
			$ori->TARIKH_KEMASUKAN = $stud->admission_date;
			$ori->PEMBIAYAAN = $stud->sponsor;
			$ori->SEMESTER = $stud->semester;
			if($ori->save()){
				echo 'SUCCESS: ' . $matric . '<br />';
			}else{
				print_r($ori->getErrors());
			}
		}
	}
	
	public function actionImportStudent2(){
        $list = StudentData2::find()->all();
        foreach($list as $stud){
            //lets create user first 
            //how? 
            //check whether email  exist
            
            
            $email = $stud->EMEL_PELAJAR;
            $exist = User::findOne(['email' => $email]);
            if($exist){
                $user = $exist;
               
            }else{
                $user = new User();
                $user->username = $stud->NO_MATRIK;
                $random = rand(30,30000);
                $user->password_hash = \Yii::$app->security->generatePasswordHash($random);

                $user->email = $email;
                
            }
            $user->fullname = $stud->NAMA_PELAJAR;
            $user->status = 10;
            if($user->save()){
                //for student data
				$ada = Student::findOne(['matric_no' => $stud->NO_MATRIK]);
				if($ada){
					$student = $ada;
				}else{
					$student = new Student();
					$student->matric_no = $stud->NO_MATRIK;
				}
                $student->user_id = $user->id;
                
                $student->nric = $stud->NO_IC;
                $student->date_birth = date('Y-m-d', strtotime($stud->TARIKH_LAHIR));
                if($stud->TARAF_PERKAHWINAN == 'Berkahwin'){
                    $student->marital_status = 1;
                }else{
                    $student->marital_status = 2;
                }
                
                if($stud->JANTINA == 'LELAKI'){
                    $student->gender = 1;
                }else{
                    $student->gender = 0;
                }
				
				
				$code = 158;
				switch($stud->NEGARA_ASAL){
					case 'Banglade';
					$code = 19;
					break;
					
					case 'Senegal':
					$code = 205;
					break;
					
					case 'Ghana':
					$code = 82;
					break;
					
					case 'Nigeria':
					$code = 164;
					break;
					
					case 'Indonesi':
					$code = 101;
					break;
					
					case 'Thailand':
					$code = 218;
					break;
					
					case 'Pakistan':
					$code = 178;
					break;
				}
                
                $student->nationality = $code;
                
                if($stud->KEWARGANEGARAAN == 'Tempatan'){
                    $student->citizenship = 1;
                }else{
                    $student->citizenship = 2;
                }
                
                $student->program_code = $stud->KOD_PROGRAM;
                
                if($stud->TARAF_PENGAJIAN == 'Penuh Masa'){
                    $student->study_mode = 1;
                }else{
                    $student->study_mode = 2;
                }
                
                $student->address = $stud->ALAMAT;
                $student->city = $stud->DAERAH;
                $student->phone_no = $stud->NO_TELEFON;
                $student->personal_email = $stud->EMEL_PERSONAL;
				
				$agama = [1 => 'Islam', 2 => 'Buddh', 3 => 'Krist' , 4 => 'Hindu', 5 => 'Others'];
				$p = false;
				foreach($agama as $key => $val){
                    if(strtolower($stud->AGAMA) == strtolower($val)){
						$p = true;
                        $student->religion = $key;
                    }
                }
				if($p == false){
					$student->religion = 5;
				}
				
				$bangsa = [1 => 'melayu', 2 => 'cina', 3 => 'Indian' , 4 => 'Others'];
				$b = false;
				foreach($agama as $key => $val){
                    if(strtolower($stud->BANGSA) == strtolower($val)){
						$b = true;
                        $student->race = $key;
                    }
                }
				if($b == false){
					$student->race = 4;
				}
				

				
				
                $student->bachelor_name = $stud->NAMA_SARJANA_MUDA;
                $student->bachelor_university = $stud->UNIVERSITI_SARJANA_MUDA;
                if($student->bachelor_cgpa > 0){
					$student->bachelor_cgpa = $stud->CGPA_SARJANA_MUDA;
				} else{
					$student->bachelor_cgpa = null;
				}
				
                if($student->bachelor_year > 0){
					$student->bachelor_year = $stud->TAHUN_SARJANA_MUDA;
				}else{
					$student->bachelor_year = null;
				}
				
				$student->master_name = $stud->NAMA_SARJANA;
                $student->master_university = $stud->UNIVERSITI_SARJANA;
                $student->master_cgpa = $stud->CGPA_SARJANA;
                $student->master_year = $stud->TAHUN_SARJANA;
				
				if($student->master_year > 0){
					$student->master_year = $stud->TAHUN_SARJANA;
				}else{
					$student->master_year = null;
				}
                
                $sesi = [
				'201020112' => 'SEMESTER FEBRUARI SESI AKADEMIK 2010/2011',
				'201220132' => 'SEMESTER FEBRUARI SESI AKADEMIK 2012/2013',
				'201420152' => 'SEMESTER FEBRUARI SESI AKADEMIK 2014/2015',
				'201520162' => 'SEMESTER FEBRUARI SESI AKADEMIK 2015/2016',
				'201620172' => 'SEMESTER FEBRUARI SESI AKADEMIK 2016/2017',
				'201720182' => 'SEMESTER FEBRUARI SESI AKADEMIK 2017/2018',
				'201820192' => 'SEMESTER FEBRUARI SESI AKADEMIK 2018/2019',
				'201920202' => 'SEMESTER FEBRUARI SESI AKADEMIK 2019/2020',
				'202020212' => 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021',
				'201120121' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2011/2012',
				'201220131' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2012/2013',
				'201320141' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2013/2014',
				'201420151' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2014/2015',
				'201520161' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2015/2016',
				'201620171' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2016/2017',
				'201720181' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2017/2018',
				'201820191' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2018/2019',
				'201920201' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020',
				'202020211' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021',
				'202120221' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022',
				];
                foreach($sesi as $key => $val){
                    if($stud->SESI_MASUK == $val){
                        $student->admission_semester = $key;
                    }
                }
                
                $student->admission_year = $stud->TAHUN_KEMASUKAN;
                $student->admission_date = date('Y-m-d', strtotime($stud->TARIKH_KEMASUKAN));
                $student->sponsor = $stud->PEMBIAYAAN;
                $student->current_sem = $stud->SEMESTER;
                $student->campus_id = 2;
                $student->status = 1;
                if($student->save()){
					$stud->done_import = 1;
					$stud->save();
					echo 'SUCSESS: ' . $stud->NAMA_PELAJAR . '<br />';
				}else{
					echo 'FAILED: ';
					print_r($student->getErrors());
				}
                
                
                
                
            }else{
				echo 'FAILED AT USER: ' . $stud->NO_MATRIK . ' ' . $stud->EMEL_PELAJAR . ' ';
					print_r($user->getErrors());
			}
            
            
           
            
            
        }
        
    } */

    /**
     * Displays a single StudentPostGrad model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

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

        $thesisList = PgStudentThesis::find()
            ->where(['student_id' => (int)$model->id])
            ->orderBy(['date_applied' => SORT_DESC, 'id' => SORT_DESC])
            ->all();

        $thesis = PgStudentThesis::find()->where([
            'student_id' => (int)$model->id,
        ])->orderBy(['date_applied' => SORT_DESC, 'id' => SORT_DESC])->one();
        if (!$thesis) {
            $thesis = new PgStudentThesis();
            $thesis->student_id = (int)$model->id;
            $thesis->is_active = 1;
        }
        
        return $this->render('view', [
            'model' => $model,
            'semesters' => $semesters,
            'supervisors' => $supervisors,
            'stages' => $stages,
            'thesis' => $thesis,
            'thesisList' => $thesisList,
        ]);
    }

    public function actionThesisCreate($id)
    {
        $student = $this->findModel($id);
        $thesis = new PgStudentThesis();
        $thesis->student_id = (int)$student->id;
        $thesis->is_active = 1;

        if ($thesis->load(Yii::$app->request->post()) && $thesis->save()) {
            if ((int)$thesis->is_active === 1) {
                PgStudentThesis::updateAll(
                    ['is_active' => 0],
                    ['and', ['student_id' => (int)$student->id], ['<>', 'id', (int)$thesis->id]]
                );
            }
            Yii::$app->session->addFlash('success', 'Thesis title added.');
            return $this->redirect(['view', 'id' => $student->id]);
        }

        return $this->render('thesis-create', [
            'student' => $student,
            'thesis' => $thesis,
        ]);
    }

    public function actionThesisUpdate($id, $thesis_id)
    {
        $student = $this->findModel($id);
        $thesis = PgStudentThesis::find()->where([
            'id' => (int)$thesis_id,
            'student_id' => (int)$student->id,
        ])->one();

        if (!$thesis) {
            throw new NotFoundHttpException('The requested thesis record does not exist.');
        }

        if ($thesis->load(Yii::$app->request->post()) && $thesis->save()) {
            if ((int)$thesis->is_active === 1) {
                PgStudentThesis::updateAll(
                    ['is_active' => 0],
                    ['and', ['student_id' => (int)$student->id], ['<>', 'id', (int)$thesis->id]]
                );
            }
            Yii::$app->session->addFlash('success', 'Thesis title updated.');
            return $this->redirect(['view', 'id' => $student->id]);
        }

        return $this->render('thesis-update', [
            'student' => $student,
            'thesis' => $thesis,
        ]);
    }

    public function actionUpdateThesis($id)
    {
        $model = $this->findModel($id);

        $thesis = PgStudentThesis::find()->where([
            'student_id' => (int)$model->id,
            'is_active' => 1,
        ])->orderBy(['id' => SORT_DESC])->one();

        if (!$thesis) {
            $thesis = new PgStudentThesis();
            $thesis->student_id = (int)$model->id;
            $thesis->is_active = 1;
        }

        if ($thesis->load(Yii::$app->request->post())) {
            if ($thesis->save()) {
                if ((int)$thesis->is_active === 1) {
                    PgStudentThesis::updateAll(
                        ['is_active' => 0],
                        ['and', ['student_id' => (int)$model->id], ['<>', 'id', (int)$thesis->id]]
                    );
                }
                Yii::$app->session->addFlash('success', 'Thesis information updated.');
            } else {
                Yii::$app->session->addFlash('error', 'Failed to update thesis information.');
            }
        }

        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionUpdateSemesterInfo($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->addFlash('success', 'Maklumat pendaftaran semester dikemaskini.');
            } else {
                $model->flashError();
            }
        }

        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Creates a new StudentPostGrad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Student();
        $modelUser = new User();
        $model->scenario = 'create';
        $modelUser->scenario = 'studPost';

        if ($model->load(Yii::$app->request->post()) 
            && $modelUser->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                //check email exist
                $email = $modelUser->email;
                $user = User::find()
                    ->where(['or',
                        ['email' => $email],
                        ['username' => $email]
                    ])->one();

                if ($user) {
                    $modelUser = $user;
                    $modelUser->scenario = 'studPost';
                } else {
                    $random = rand(30,30000);
                    $modelUser->username = $model->matric_no;
                    $modelUser->password_hash = \Yii::$app->security->generatePasswordHash($random);
                }
                $modelUser->status = 10;

                if (!$modelUser->save()) {
                    $transaction->rollBack();
                    Yii::$app->session->addFlash('error', 'Gagal simpan rekod pengguna: ' . json_encode($modelUser->getErrors()));
                    return $this->render('create', [
                        'model' => $model,
                        'modelUser' => $modelUser,
                    ]);
                }

                $model->user_id = $modelUser->id;
                if (!$model->save()) {
                    $transaction->rollBack();
                    Yii::$app->session->addFlash('error', 'Gagal simpan rekod pelajar: ' . json_encode($model->getErrors()));
                    return $this->render('create', [
                        'model' => $model,
                        'modelUser' => $modelUser,
                    ]);
                }

                $transaction->commit();
                Yii::$app->session->addFlash('success', 'Pelajar berjaya didaftarkan.');
                return $this->redirect(['view', 'id' => $model->id]);

            } catch (IntegrityException $e) {
                if ($transaction->isActive) {
                    $transaction->rollBack();
                }
                Yii::error($e->getMessage(), __METHOD__);
                Yii::$app->session->addFlash('error', 'Gagal simpan (database integrity): ' . $e->getMessage());
            } catch (\Throwable $e) {
                if ($transaction->isActive) {
                    $transaction->rollBack();
                }
                Yii::error($e->getMessage(), __METHOD__);
                Yii::$app->session->addFlash('error', 'Ralat sistem semasa simpan: ' . $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelUser' => $modelUser,
        ]);
    }

    /**
     * Updates an existing StudentPostGrad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelUser = User::findOne($model->user_id);

        if ($model->load(Yii::$app->request->post()) 
            && $modelUser->load(Yii::$app->request->post())) {

            if($modelUser->save()){

                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    $model->flashError();
                }
            }else{
                $modelUser->flashError();
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelUser' => $modelUser,
        ]);
    }

    /**
     * Deletes an existing StudentPostGrad model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        try {
            $model->delete();
            Yii::$app->session->addFlash('success', "Student Deleted");
            return $this->redirect(['index']);
        } catch(\yii\db\IntegrityException $e) {
            Yii::$app->session->addFlash('error', "Cannot delete the student at this stage");
            return $this->redirect(['view', 'id' => $model->id]);
            
        }

        
    }

    /**
     * Finds the StudentPostGrad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Student the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUpdateStudentDataFromCsv(){
        $webroot = \Yii::getAlias('@webroot');
        $path = $webroot . DIRECTORY_SEPARATOR . 'student_data.csv';

        echo '<pre style="white-space: pre-wrap">';

        if (!file_exists($path)) {
            echo 'CSV not found at: ' . $path;
            echo '</pre>';
            return;
        }

        $fh = fopen($path, 'r');
        if (!$fh) {
            echo 'Unable to open CSV: ' . $path;
            echo '</pre>';
            return;
        }

        set_time_limit(0);

        $row = 0;
        $header = [];
        $cols = [];
        $updated = 0;
        $skipped = 0;
        $notFound = 0;
        $failed = 0;

        // Allowed columns to update => type
        // type: i=int, f=float, s=string, d=date (Y-m-d)
        $allowed = [
            'program_id' => 'i',
            'study_mode' => 'i',
            'study_mode_rc' => 's',
            'sponsor' => 's',
            'current_sem' => 'i',
            'admission_year' => 's',
            'admission_date' => 'd',
            'status' => 'i',
            'phone_no' => 's',
            'personal_email' => 's',
            'address' => 's',
            'city' => 's',
            'nationality' => 'i',
            'citizenship' => 'i',
            'gender' => 'i',
            'marital_status' => 'i',
            'race' => 'i',
            'religion' => 'i',
            'field_id' => 'i',
            'related_university_id' => 'i',
            'outstanding_fee' => 'f',
            // optional extras commonly present
            'name' => 's',
            'nric' => 's',
            'date_birth' => 'd',
        ];

        while (($data = fgetcsv($fh)) !== false) {
            $row++;
            if ($row === 1) {
                // detect header and column positions
                $header = array_map('strtolower', $data);
                $cols = array_flip($header);
                $matricKey = null;
                if (isset($cols['matric_no'])) { $matricKey = 'matric_no'; }
                elseif (isset($cols['student_id'])) { $matricKey = 'student_id'; }

                if ($matricKey === null) {
                    echo "Header must include 'matric_no' or 'student_id' on first row." . "\n";
                    echo '</pre>';
                    fclose($fh);
                    return;
                }
                echo 'Detected columns: ' . implode(', ', $header) . "\n\n";
                // proceed to next row
                continue;
            }

            // Ensure header was read
            if (!$header) { $skipped++; continue; }

            $matric = '';
            if (isset($cols['matric_no']) && isset($data[$cols['matric_no']])) {
                $matric = trim((string)$data[$cols['matric_no']]);
            } elseif (isset($cols['student_id']) && isset($data[$cols['student_id']])) {
                $matric = trim((string)$data[$cols['student_id']]);
            }

            if ($matric === '') {
                echo 'Row ' . $row . ': SKIP (empty matric_no)' . "\n";
                $skipped++;
                continue;
            }

            $student = Student::find()->where(['matric_no' => $matric])->one();
            if (!$student) {
                // attempt to create new user + student
                $email = '';
                if (isset($cols['email']) && isset($data[$cols['email']])) {
                    $email = trim((string)$data[$cols['email']]);
                } elseif (isset($cols['personal_email']) && isset($data[$cols['personal_email']])) {
                    $email = trim((string)$data[$cols['personal_email']]);
                }

                $fullname = '';
                if (isset($cols['name']) && isset($data[$cols['name']])) {
                    $fullname = trim((string)$data[$cols['name']]);
                }

                $user = new User();
                $user->username = $matric;
                $user->email = $email ?: ($matric . '@example.com');
                $user->fullname = $fullname ?: $matric;
                $random = rand(30,30000);
                $user->password_hash = \Yii::$app->security->generatePasswordHash($random);
                $user->status = 10;

                if (!$user->save()) {
                    echo htmlspecialchars($matric) . ' : USER_CREATE_FAILED ' . json_encode($user->getErrors()) . "\n";
                    $failed++;
                    continue;
                }

                $student = new Student();
                $student->scenario = 'create';
                $student->user_id = $user->id;
                $student->matric_no = $matric;

                // program_id is required for create
                $progVal = null;
                if (isset($cols['program_id']) && isset($data[$cols['program_id']]) && trim((string)$data[$cols['program_id']]) !== '') {
                    $progVal = (int) trim((string)$data[$cols['program_id']]);
                }
                if ($progVal === null) {
                    echo htmlspecialchars($matric) . ' : SKIP_CREATE (missing program_id)' . "\n";
                    $skipped++;
                    continue;
                }
                $student->program_id = $progVal;

                // default status to active if missing
                $statusVal = null;
                if (isset($cols['status']) && isset($data[$cols['status']]) && trim((string)$data[$cols['status']]) !== '') {
                    $statusVal = (int) trim((string)$data[$cols['status']]);
                }
                $student->status = $statusVal !== null ? $statusVal : Student::STATUS_ACTIVE;

                // fill other allowed fields if present
                foreach ($allowed as $col => $type) {
                    if (in_array($col, ['program_id','status'], true)) { continue; }
                    if (!isset($cols[$col])) { continue; }
                    $idx = $cols[$col];
                    if (!isset($data[$idx])) { continue; }
                    $raw = trim((string)$data[$idx]);
                    if ($raw === '') { continue; }
                    switch ($type) {
                        case 'i': $val = (int)$raw; break;
                        case 'f': $val = (float)$raw; break;
                        case 'd':
                            $ts = strtotime($raw);
                            $val = $ts ? date('Y-m-d', $ts) : null;
                            if ($val === null) { continue 3; }
                            break;
                        default: $val = $raw;
                    }
                    $student->$col = $val;
                }

                if ($student->save()) {
                    echo htmlspecialchars($matric) . ' : CREATED' . "\n";
                    $updated++;
                } else {
                    echo htmlspecialchars($matric) . ' : CREATE_FAILED ' . json_encode($student->getErrors()) . "\n";
                    $failed++;
                }
                @ob_flush();
                flush();
                continue;
            }

            // set scenario to ensure validation applies appropriately
            $student->scenario = 'student_update';

            $changes = [];
            foreach ($allowed as $col => $type) {
                if (!isset($cols[$col])) { continue; }
                $idx = $cols[$col];
                if (!isset($data[$idx])) { continue; }
                $raw = trim((string)$data[$idx]);
                // allow empty to clear? Skip empty to avoid unintended clears
                if ($raw === '') { continue; }
                switch ($type) {
                    case 'i':
                        $val = (int)$raw;
                        break;
                    case 'f':
                        $val = (float)$raw;
                        break;
                    case 'd':
                        $ts = strtotime($raw);
                        $val = $ts ? date('Y-m-d', $ts) : null;
                        if ($val === null) { continue 2; }
                        break;
                    default:
                        $val = $raw;
                }
                $student->$col = $val;
                $changes[] = $col;
            }

            if (empty($changes)) {
                echo htmlspecialchars($matric) . ' : NO CHANGES' . "\n";
                $skipped++;
                continue;
            }

            if ($student->save()) {
                echo htmlspecialchars($matric) . ' : UPDATED [' . implode(', ', $changes) . ']' . "\n";
                $updated++;
            } else {
                echo htmlspecialchars($matric) . ' : FAILED ' . json_encode($student->getErrors()) . "\n";
                $failed++;
            }

            @ob_flush();
            flush();
        }

        fclose($fh);

        echo "\nSummary:" . "\n";
        echo 'Updated: ' . $updated . "\n";
        echo 'Skipped: ' . $skipped . "\n";
        echo 'Not Found: ' . $notFound . "\n";
        echo 'Failed: ' . $failed . "\n";
        echo '</pre>';
        return;
    }

    public function actionStudentExistFromCsv(){
        $webroot = \Yii::getAlias('@webroot');
        $path = $webroot . DIRECTORY_SEPARATOR . 'data.csv';

        // simple HTML output
        echo '<pre style="white-space: pre-wrap">';

        if (!file_exists($path)) {
            echo 'CSV not found at: ' . $path;
            echo '</pre>';
            return;
        }

        $fh = fopen($path, 'r');
        if (!$fh) {
            echo 'Unable to open CSV: ' . $path;
            echo '</pre>';
            return;
        }

        set_time_limit(0);

        $row = 0;
        $hasHeader = null; // null=unknown, true=header present
        $idCol = 0; // default to first column

        while (($data = fgetcsv($fh)) !== false) {
            $row++;
            // Detect header on first row
            if ($row === 1) {
                $lower = array_map('strtolower', $data);
                $posStudent = array_search('student_id', $lower, true);
                $posMatric = array_search('matric_no', $lower, true);
                if ($posStudent !== false) {
                    $hasHeader = true;
                    $idCol = (int)$posStudent;
                    // skip header row
                    continue;
                } elseif ($posMatric !== false) {
                    $hasHeader = true;
                    $idCol = (int)$posMatric;
                    // skip header row
                    continue;
                } else {
                    $hasHeader = false;
                    $idCol = 0;
                }
            }

            $studentId = '';
            if (isset($data[$idCol])) {
                $studentId = trim((string)$data[$idCol]);
            }

            if ($studentId === '') {
                echo 'Row ' . $row . ': EMPTY<br />';
                continue;
            }

            $exists = Student::find()->where(['matric_no' => $studentId])->exists();
            echo htmlspecialchars($studentId) . ' : ' . ($exists ? 'EXIST' : 'NOT FOUND') . '<br />';
            @ob_flush();
            flush();
        }

        fclose($fh);
        echo '</pre>';
        return;
        exit;
    }

    
}
