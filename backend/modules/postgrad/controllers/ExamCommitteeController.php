<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\db\Query;
use yii\data\ArrayDataProvider;
use backend\models\Semester;
use backend\modules\postgrad\models\ExamCommitteeUploadForm;
use backend\modules\postgrad\models\PgStudentThesis;
use backend\modules\postgrad\models\Student;
use backend\modules\postgrad\models\StageExaminer;
use backend\modules\postgrad\models\StudentStage;
use backend\modules\postgrad\models\Supervisor;
use backend\modules\postgrad\models\PgSetting;
use backend\modules\staff\models\Staff;

class ExamCommitteeController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($semester_id = null, $tab = 'academic')
    {
        if ($semester_id === null) {
            $current = Semester::getCurrentSemester();
            $semester_id = $current ? (int)$current->id : null;
        } else {
            $semester_id = (int)$semester_id;
        }

        $semester = $semester_id ? Semester::findOne($semester_id) : null;

        // normalise tab, mirror logic from SupervisorController
        $tab = strtolower((string)$tab);
        switch ($tab) {
            case 'transferred':
            case 'transfer':
            case 'quit':
            case 'transferred-quit':
                $tab = 'transferred';
                break;
            case 'external':
                $tab = 'external';
                break;
            case 'other':
                $tab = 'other';
                break;
            case 'academic':
            default:
                $tab = 'academic';
                break;
        }

        $kpi = Yii::$app->request->get('kpi');

        $rows = [];
        $countChairman = 0;
        $countDeputy = 0;
        $countExaminer1 = 0;
        $countExaminer2 = 0;
        $countGreen = 0;
        $countYellow = 0;
        $countRed = 0;
        $tabCounts = [
            'academic' => 0,
            'other' => 0,
            'external' => 0,
            'transferred' => 0,
        ];
        if ($semester) {
            if ($tab === 'academic') {
                $this->syncInternalSupervisorsFromStaff(1, 1);
            } elseif ($tab === 'other') {
                $this->syncInternalSupervisorsFromStaff(null, 1);
            } elseif ($tab === 'transferred') {
                $this->syncInternalSupervisorsFromStaff(1, 0);
            }

            // academic tab matches staff module; other/external/transferred match the involved committee list for semester
            $tabCounts['academic'] = (int)Staff::find()->where(['staff_active' => 1, 'faculty_id' => 1])->count();
            $tabCounts['other'] = (int)(new Query())
                ->from(['se' => StageExaminer::tableName()])
                ->innerJoin(['st' => StudentStage::tableName()], 'st.id = se.stage_id')
                ->innerJoin(['sv' => Supervisor::tableName()], 'sv.id = se.examiner_id')
                ->innerJoin(['stf' => Staff::tableName()], 'stf.id = sv.staff_id AND stf.staff_active = 1 AND stf.faculty_id <> 1')
                ->where(['st.semester_id' => $semester_id, 'sv.is_internal' => 1])
                ->count('DISTINCT se.examiner_id');
            $tabCounts['transferred'] = (int)(new Query())
                ->from(['se' => StageExaminer::tableName()])
                ->innerJoin(['st' => StudentStage::tableName()], 'st.id = se.stage_id')
                ->innerJoin(['sv' => Supervisor::tableName()], 'sv.id = se.examiner_id')
                ->innerJoin(['stf' => Staff::tableName()], 'stf.id = sv.staff_id AND stf.staff_active = 0 AND stf.faculty_id = 1')
                ->where(['st.semester_id' => $semester_id, 'sv.is_internal' => 1])
                ->count('DISTINCT se.examiner_id');
            $tabCounts['external'] = (int)(new Query())
                ->from(['se' => StageExaminer::tableName()])
                ->innerJoin(['st' => StudentStage::tableName()], 'st.id = se.stage_id')
                ->innerJoin(['sv' => Supervisor::tableName()], 'sv.id = se.examiner_id')
                ->where(['st.semester_id' => $semester_id, 'sv.is_internal' => 0])
                ->andWhere(['>', 'sv.external_id', 0])
                ->count('DISTINCT se.examiner_id');

            $baseCountQuery = (new Query())
                ->from(['se' => StageExaminer::tableName()])
                ->innerJoin(['st' => StudentStage::tableName()], 'st.id = se.stage_id')
                ->innerJoin(['sv' => Supervisor::tableName()], 'sv.id = se.examiner_id')
                ->where(['st.semester_id' => $semester_id]);

            $supervisors = [];
            if ($tab === 'external') {
                $supervisors = Supervisor::find()->alias('sv')
                    ->where(['sv.is_internal' => 0])
                    ->andWhere(['>', 'sv.external_id', 0])
                    ->indexBy('id')
                    ->all();

                $baseCountQuery->andWhere(['sv.is_internal' => 0])
                    ->andWhere(['>', 'sv.external_id', 0]);
            } else {
                $svQuery = Supervisor::find()->alias('sv')
                    ->innerJoin(['stf' => Staff::tableName()], 'stf.id = sv.staff_id')
                    ->where(['sv.is_internal' => 1]);

                if ($tab === 'academic') {
                    $svQuery->andWhere(['stf.faculty_id' => 1, 'stf.staff_active' => 1]);
                } elseif ($tab === 'other') {
                    $svQuery->andWhere(['<>', 'stf.faculty_id', 1])->andWhere(['stf.staff_active' => 1]);
                } elseif ($tab === 'transferred') {
                    $svQuery->andWhere(['stf.faculty_id' => 1, 'stf.staff_active' => 0]);
                }

                $supervisors = $svQuery->indexBy('id')->all();

                if ($tab === 'academic') {
                    $baseCountQuery->innerJoin(['stf' => Staff::tableName()], 'stf.id = sv.staff_id AND stf.faculty_id = 1 AND stf.staff_active = 1')
                        ->andWhere(['sv.is_internal' => 1]);
                } elseif ($tab === 'other') {
                    $baseCountQuery->innerJoin(['stf' => Staff::tableName()], 'stf.id = sv.staff_id AND stf.staff_active = 1 AND stf.faculty_id <> 1')
                        ->andWhere(['sv.is_internal' => 1]);
                } elseif ($tab === 'transferred') {
                    $baseCountQuery->innerJoin(['stf' => Staff::tableName()], 'stf.id = sv.staff_id AND stf.faculty_id = 1 AND stf.staff_active = 0')
                        ->andWhere(['sv.is_internal' => 1]);
                }
            }

            $countChairman = (int)(clone $baseCountQuery)
                ->andWhere(['se.committee_role' => 1])
                ->count('DISTINCT se.examiner_id');

            $countDeputy = (int)(clone $baseCountQuery)
                ->andWhere(['se.committee_role' => 2])
                ->count('DISTINCT se.examiner_id');

            $countExaminer1 = (int)(clone $baseCountQuery)
                ->andWhere(['se.committee_role' => 3])
                ->count('DISTINCT se.examiner_id');

            $countExaminer2 = (int)(clone $baseCountQuery)
                ->andWhere(['se.committee_role' => 4])
                ->count('DISTINCT se.examiner_id');

            $countsBySupervisor = [];
            if (!empty($supervisors)) {
                $ids = array_keys($supervisors);
                $countRows = (new Query())
                    ->select([
                        'supervisor_id' => 'se.examiner_id',
                        'pengerusi' => "SUM(CASE WHEN se.committee_role = 1 THEN 1 ELSE 0 END)",
                        'penolong' => "SUM(CASE WHEN se.committee_role = 2 THEN 1 ELSE 0 END)",
                        'pemeriksa1' => "SUM(CASE WHEN se.committee_role = 3 THEN 1 ELSE 0 END)",
                        'pemeriksa2' => "SUM(CASE WHEN se.committee_role = 4 THEN 1 ELSE 0 END)",
                        'total' => "SUM(CASE WHEN se.committee_role IN (1,2,3,4) THEN 1 ELSE 0 END)",
                    ])
                    ->from(['se' => StageExaminer::tableName()])
                    ->innerJoin(['st' => StudentStage::tableName()], 'st.id = se.stage_id')
                    ->where([
                        'st.semester_id' => $semester_id,
                        'se.examiner_id' => $ids,
                    ])
                    ->groupBy(['se.examiner_id'])
                    ->all();

                foreach ($countRows as $r) {
                    $countsBySupervisor[(int)$r['supervisor_id']] = [
                        'pengerusi' => (int)$r['pengerusi'],
                        'penolong' => (int)$r['penolong'],
                        'pemeriksa1' => (int)$r['pemeriksa1'],
                        'pemeriksa2' => (int)$r['pemeriksa2'],
                        'total' => (int)$r['total'],
                    ];
                }
            }

            $allData = [];
            if (!empty($supervisors)) {
                foreach ($supervisors as $sid => $sup) {
                    $c = $countsBySupervisor[(int)$sid] ?? [
                        'pengerusi' => 0,
                        'penolong' => 0,
                        'pemeriksa1' => 0,
                        'pemeriksa2' => 0,
                        'total' => 0,
                    ];
                    $allData[] = [
                        'supervisor' => $sup,
                        'sv_name' => $sup ? $sup->svName : '-',
                        'pengerusi' => (int)$c['pengerusi'],
                        'penolong' => (int)$c['penolong'],
                        'pemeriksa1' => (int)$c['pemeriksa1'],
                        'pemeriksa2' => (int)$c['pemeriksa2'],
                        'total' => (int)$c['total'],
                    ];
                }
            }

            $baseData = $allData;
            if ($tab !== 'academic') {
                $baseData = array_values(array_filter($baseData, function ($r) {
                    return (int)($r['total'] ?? 0) > 0;
                }));
            }

            foreach ($baseData as $r) {
                $t = (int)($r['total'] ?? 0);
                $color = PgSetting::classifyTrafficLight('exam_committee', $t);
                if ($color === 'green') {
                    $countGreen++;
                } elseif ($color === 'yellow') {
                    $countYellow++;
                } else {
                    $countRed++;
                }
            }

            $data = $baseData;
            if (!empty($kpi)) {
                $ranges = PgSetting::trafficLightRanges('exam_committee');
                $data = array_values(array_filter($data, function ($r) use ($kpi) {
                    switch ((string)$kpi) {
                        case 'chairman':
                            return (int)$r['pengerusi'] > 0;
                        case 'deputy':
                            return (int)$r['penolong'] > 0;
                        case 'examiner1':
                            return (int)$r['pemeriksa1'] > 0;
                        case 'examiner2':
                            return (int)$r['pemeriksa2'] > 0;
                        case 'green':
                            $ranges = PgSetting::trafficLightRanges('exam_committee');
                            $min = (int)($ranges['green']['min'] ?? 0);
                            $max = $ranges['green']['max'] ?? null;
                            if ($max === null) { return (int)$r['total'] >= $min; }
                            return (int)$r['total'] >= $min && (int)$r['total'] <= (int)$max;
                        case 'yellow':
                            $ranges = PgSetting::trafficLightRanges('exam_committee');
                            $min = (int)($ranges['yellow']['min'] ?? 0);
                            $max = $ranges['yellow']['max'] ?? null;
                            if ($max === null) { return (int)$r['total'] >= $min; }
                            return (int)$r['total'] >= $min && (int)$r['total'] <= (int)$max;
                        case 'red':
                            $ranges = PgSetting::trafficLightRanges('exam_committee');
                            $min = (int)($ranges['red']['min'] ?? 0);
                            $max = $ranges['red']['max'] ?? null;
                            if ($max === null) { return (int)$r['total'] >= $min; }
                            return (int)$r['total'] >= $min && (int)$r['total'] <= (int)$max;
                        default:
                            return true;
                    }
                }));
            }

            $rows = $data;
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $rows,
            'pagination' => [
                'pageSize' => 50,
            ],
            'sort' => [
                'attributes' => [
                    'sv_name',
                    'pengerusi',
                    'penolong',
                    'pemeriksa1',
                    'pemeriksa2',
                    'total',
                ],
                'defaultOrder' => [
                    'total' => SORT_DESC,
                ],
            ],
        ]);

        $semesterList = Semester::listSemesterArray();

        return $this->render('index', [
            'semester' => $semester,
            'semester_id' => $semester_id,
            'semesterList' => $semesterList,
            'dataProvider' => $dataProvider,
            'tab' => $tab,
            'kpi' => $kpi,
            'countChairman' => $countChairman,
            'countDeputy' => $countDeputy,
            'countExaminer1' => $countExaminer1,
            'countExaminer2' => $countExaminer2,
            'countGreen' => $countGreen,
            'countYellow' => $countYellow,
            'countRed' => $countRed,
            'tabCounts' => $tabCounts,
        ]);
    }

    public function actionImport()
    {
        $model = new ExamCommitteeUploadForm();

        $preview = null;
        $summary = null;

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $model->load($post);

            $token = (string)Yii::$app->request->post('csv_token', '');
            $token = trim($token);

            if ($token === '') {
                $summary = ['error' => 'Please upload a CSV file first'];
            } else {
                $map = Yii::$app->session->get('postgrad_exam_committee_csv_tokens', []);
                $path = isset($map[$token]) ? $map[$token] : null;

                if (!$path || !is_string($path) || !is_file($path)) {
                    $summary = ['error' => 'Uploaded CSV file not found. Please upload again.'];
                } else {
                    [$preview, $summary] = $this->processCsv($path, false);

                    $applyIntent = (string)Yii::$app->request->post('apply_intent', '0');
                    $applyIntent = trim($applyIntent);

                    if ($applyIntent === '1') {
                        [$preview, $summary] = $this->processCsv($path, true);
                    }
                }
            }
        }

        return $this->render('import', [
            'model' => $model,
            'preview' => $preview,
            'summary' => $summary,
        ]);
    }

    private function processCsv($path, $apply)
    {
        set_time_limit(0);

        $fh = fopen($path, 'r');
        if (!$fh) {
            return [[], ['error' => 'Unable to open uploaded CSV file']];
        }

        $row = 0;
        $cols = [];

        $stats = [
            'processed' => 0,
            'updated' => 0,
            'created' => 0,
            'skipped' => 0,
            'not_found' => 0,
            'semester_not_found' => 0,
            'invalid' => 0,
            'errors' => 0,
            'applied' => $apply ? 1 : 0,
        ];

        $resultCounts = [
            'READY' => 0,
            'NO_CHANGES' => 0,
            'NOT_FOUND' => 0,
            'SEMESTER_NOT_FOUND' => 0,
            'INVALID' => 0,
            'UPDATED' => 0,
            'CREATED' => 0,
            'FAILED' => 0,
        ];

        $preview = [];

        // Preload staff map for matching (active staff only)
        $staffRows = Staff::find()->alias('stf')
            ->select(['stf.id AS staff_id', 'u.fullname AS fullname'])
            ->innerJoin(['u' => \common\models\User::tableName()], 'u.id = stf.user_id')
            ->where(['stf.staff_active' => 1])
            ->asArray()
            ->all();

        $staffMap = [];
        foreach ($staffRows as $sr) {
            $sid = (int)($sr['staff_id'] ?? 0);
            $nm = $this->normalizePersonName($sr['fullname'] ?? '');
            if ($sid > 0 && $nm !== '') {
                $staffMap[$nm] = $sid;
            }
        }

        while (($data = fgetcsv($fh)) !== false) {
            $row++;

            if ($row === 1) {
                $header = array_map(function ($h) {
                    $h = strtolower(trim((string)$h));
                    if ($h !== '') {
                        $h = preg_replace('/^\xEF\xBB\xBF/', '', $h);
                    }
                    return $h;
                }, $data);
                $cols = array_flip($header);

                $required = ['student_id', 'stage_id', 'chairman', 'deputy_chairman', 'panel1', 'panel2'];
                $missing = [];
                foreach ($required as $r) {
                    if (!isset($cols[$r])) {
                        $missing[] = $r;
                    }
                }
                if (!isset($cols['thesis_title'])) {
                    $missing[] = 'thesis_title';
                }
                if (!isset($cols['date'])) {
                    $missing[] = 'date';
                }
                if (!isset($cols['time'])) {
                    $missing[] = 'time';
                }

                if (!empty($missing)) {
                    fclose($fh);
                    return [[], ['error' => 'Missing required columns: ' . implode(', ', $missing)]];
                }

                continue;
            }

            $studentMatric = trim((string)($data[$cols['student_id']] ?? ''));
            $stageId = trim((string)($data[$cols['stage_id']] ?? ''));
            $stageDate = trim((string)($data[$cols['date']] ?? ''));
            $stageTime = trim((string)($data[$cols['time']] ?? ''));
            $thesisTitle = trim((string)($data[$cols['thesis_title']] ?? ''));

            $rowSemesterId = $this->findSemesterIdByDate($stageDate);
            if (!$rowSemesterId) {
                $stats['semester_not_found']++;
                $resultCounts['SEMESTER_NOT_FOUND']++;
                $preview[] = [
                    'student_id' => $studentMatric,
                    'semester_id' => null,
                    'stage_id' => is_numeric($stageId) ? (int)$stageId : $stageId,
                    'date' => $stageDate,
                    'time' => $stageTime,
                    'thesis_title' => $thesisTitle,
                    'chairman' => trim((string)($data[$cols['chairman']] ?? '')),
                    'deputy_chairman' => trim((string)($data[$cols['deputy_chairman']] ?? '')),
                    'panel1' => trim((string)($data[$cols['panel1']] ?? '')),
                    'panel2' => trim((string)($data[$cols['panel2']] ?? '')),
                    'result' => 'SEMESTER_NOT_FOUND',
                    'message' => 'No semester matches date_start/date_end for this date',
                ];
                continue;
            }

            $chairmanName = trim((string)($data[$cols['chairman']] ?? ''));
            $deputyName = trim((string)($data[$cols['deputy_chairman']] ?? ''));
            $panel1Name = trim((string)($data[$cols['panel1']] ?? ''));
            $panel2Name = trim((string)($data[$cols['panel2']] ?? ''));

            if ($studentMatric === '' || $stageId === '') {
                $stats['skipped']++;
                continue;
            }

            if (!is_numeric($stageId)) {
                $stats['invalid']++;
                $resultCounts['INVALID']++;
                $preview[] = [
                    'student_id' => $studentMatric,
                    'semester_id' => (int)$rowSemesterId,
                    'stage_id' => $stageId,
                    'date' => $stageDate,
                    'time' => $stageTime,
                    'thesis_title' => $thesisTitle,
                    'chairman' => $chairmanName,
                    'deputy_chairman' => $deputyName,
                    'panel1' => $panel1Name,
                    'panel2' => $panel2Name,
                    'result' => 'INVALID',
                    'message' => 'Invalid stage_id',
                ];
                continue;
            }

            $student = Student::find()->where(['matric_no' => $studentMatric])->one();
            if (!$student) {
                $stats['not_found']++;
                $resultCounts['NOT_FOUND']++;
                $preview[] = [
                    'student_id' => $studentMatric,
                    'semester_id' => (int)$rowSemesterId,
                    'stage_id' => (int)$stageId,
                    'date' => $stageDate,
                    'time' => $stageTime,
                    'thesis_title' => $thesisTitle,
                    'chairman' => $chairmanName,
                    'deputy_chairman' => $deputyName,
                    'panel1' => $panel1Name,
                    'panel2' => $panel2Name,
                    'result' => 'NOT_FOUND',
                    'message' => 'Student not found',
                ];
                continue;
            }

            $stage = StudentStage::find()->where([
                'student_id' => (int)$student->id,
                'semester_id' => (int)$rowSemesterId,
                'stage_id' => (int)$stageId,
            ])->one();

            $isNewStage = false;
            if (!$stage) {
                $stage = new StudentStage();
                $stage->student_id = (int)$student->id;
                $stage->semester_id = (int)$rowSemesterId;
                $stage->stage_id = (int)$stageId;
                $isNewStage = true;
            }

            $beforeDate = (string)$stage->stage_date;
            $beforeTime = (string)$stage->stage_time;
            $beforeTitle = (string)$stage->thesis_title;

            $stage->stage_date = $stageDate !== '' ? $stageDate : $stage->stage_date;
            $stage->stage_time = $stageTime !== '' ? $stageTime : $stage->stage_time;
            $stage->thesis_title = $thesisTitle !== '' ? $thesisTitle : $stage->thesis_title;

            $changedStage = ($beforeDate !== (string)$stage->stage_date) || ($beforeTime !== (string)$stage->stage_time) || ($beforeTitle !== (string)$stage->thesis_title);

            // Thesis table: keep an active record per student
            $thesis = PgStudentThesis::find()->where(['student_id' => (int)$student->id, 'is_active' => 1])->one();
            $isNewThesis = false;
            if (!$thesis) {
                $thesis = new PgStudentThesis();
                $thesis->student_id = (int)$student->id;
                $thesis->is_active = 1;
                $isNewThesis = true;
            }

            $beforeThesisTitle = (string)$thesis->thesis_title;
            $thesis->thesis_title = $thesisTitle !== '' ? $thesisTitle : $thesis->thesis_title;
            $changedThesis = ($beforeThesisTitle !== (string)$thesis->thesis_title);

            $roles = [
                1 => $chairmanName,
                2 => $deputyName,
                3 => $panel1Name,
                4 => $panel2Name,
            ];

            $roleMatches = [];
            $roleMissing = [];
            foreach ($roles as $roleId => $name) {
                $roleMatches[$roleId] = null;
                if (trim((string)$name) === '') {
                    $roleMissing[$roleId] = 'Empty name';
                    continue;
                }

                $staffId = $this->matchStaffIdByName($name, $staffMap);
                if ($staffId) {
                    $svId = $this->ensureInternalSupervisorId($staffId);
                    if ($svId) {
                        $roleMatches[$roleId] = (int)$svId;
                    } else {
                        $roleMissing[$roleId] = 'Unable to create supervisor';
                    }
                } else {
                    $roleMissing[$roleId] = 'Staff not matched';
                }
            }

            $changedExam = false;
            $examChanges = [];

            if (!$apply) {
                $resultCounts['READY']++;
                $preview[] = [
                    'student_id' => $studentMatric,
                    'semester_id' => (int)$rowSemesterId,
                    'stage_id' => (int)$stageId,
                    'date' => $stageDate,
                    'time' => $stageTime,
                    'thesis_title' => $thesisTitle,
                    'chairman' => $chairmanName,
                    'deputy_chairman' => $deputyName,
                    'panel1' => $panel1Name,
                    'panel2' => $panel2Name,
                    'matched' => $roleMatches,
                    'missing' => $roleMissing,
                    'result' => 'READY',
                    'message' => '',
                ];
                $stats['processed']++;
                continue;
            }

            // Apply mode
            $tx = Yii::$app->db->beginTransaction();
            try {
                $stageOk = true;
                $thesisOk = true;

                if ($isNewStage) {
                    $stageOk = $stage->save();
                } elseif ($changedStage) {
                    $stageOk = $stage->save();
                }

                if ($isNewThesis) {
                    $thesisOk = $thesis->save();
                } elseif ($changedThesis) {
                    $thesisOk = $thesis->save();
                }

                if (!$stageOk || !$thesisOk) {
                    throw new \Exception('Unable to save stage/thesis');
                }

                foreach ($roleMatches as $roleId => $svId) {
                    if (!$svId) {
                        continue;
                    }

                    $ex = StageExaminer::find()->where([
                        'stage_id' => (int)$stage->id,
                        'committee_role' => (int)$roleId,
                    ])->one();

                    if ($ex) {
                        if ((int)$ex->examiner_id !== (int)$svId) {
                            $examChanges[] = (int)$roleId;
                            $ex->examiner_id = (int)$svId;
                            $ex->appoint_date = $stageDate !== '' ? $stageDate : $ex->appoint_date;
                            if (!$ex->save()) {
                                throw new \Exception('Unable to update examiner');
                            }
                            $changedExam = true;
                        }
                    } else {
                        $ex = new StageExaminer();
                        $ex->stage_id = (int)$stage->id;
                        $ex->committee_role = (int)$roleId;
                        $ex->examiner_id = (int)$svId;
                        $ex->appoint_date = $stageDate !== '' ? $stageDate : null;
                        if (!$ex->save()) {
                            throw new \Exception('Unable to create examiner');
                        }
                        $changedExam = true;
                    }
                }

                $tx->commit();

                if ($isNewStage || $isNewThesis) {
                    $stats['created']++;
                    $resultCounts['CREATED']++;
                    $previewResult = 'CREATED';
                } elseif ($changedStage || $changedThesis || $changedExam) {
                    $stats['updated']++;
                    $resultCounts['UPDATED']++;
                    $previewResult = 'UPDATED';
                } else {
                    $stats['skipped']++;
                    $resultCounts['NO_CHANGES']++;
                    $previewResult = 'NO_CHANGES';
                }

                $preview[] = [
                    'student_id' => $studentMatric,
                    'semester_id' => (int)$rowSemesterId,
                    'stage_id' => (int)$stageId,
                    'date' => $stageDate,
                    'time' => $stageTime,
                    'thesis_title' => $thesisTitle,
                    'chairman' => $chairmanName,
                    'deputy_chairman' => $deputyName,
                    'panel1' => $panel1Name,
                    'panel2' => $panel2Name,
                    'matched' => $roleMatches,
                    'missing' => $roleMissing,
                    'result' => $previewResult,
                    'message' => '',
                ];

                $stats['processed']++;
            } catch (\Throwable $e) {
                $tx->rollBack();
                $stats['errors']++;
                $resultCounts['FAILED']++;
                $preview[] = [
                    'student_id' => $studentMatric,
                    'semester_id' => (int)$rowSemesterId,
                    'stage_id' => (int)$stageId,
                    'date' => $stageDate,
                    'time' => $stageTime,
                    'thesis_title' => $thesisTitle,
                    'chairman' => $chairmanName,
                    'deputy_chairman' => $deputyName,
                    'panel1' => $panel1Name,
                    'panel2' => $panel2Name,
                    'matched' => $roleMatches,
                    'missing' => $roleMissing,
                    'result' => 'FAILED',
                    'message' => $e->getMessage(),
                ];
            }
        }

        fclose($fh);
        $stats['result_counts'] = $resultCounts;
        return [$preview, $stats];
    }

    private function normalizePersonName($name)
    {
        $name = strtolower(trim((string)$name));
        $name = preg_replace('/[\.,]+/', ' ', $name);
        $name = preg_replace('/\s+/', ' ', $name);
        $name = trim($name);

        $titles = [
            'prof madya dr',
            'prof madya',
            'prof dr',
            'prof',
            'dr',
            'madya',
        ];
        foreach ($titles as $t) {
            if (strpos($name, $t . ' ') === 0) {
                $name = trim(substr($name, strlen($t)));
                break;
            }
        }
        return trim($name);
    }

    private function matchStaffIdByName($rawName, array $staffMap)
    {
        $key = $this->normalizePersonName($rawName);
        if ($key === '') {
            return null;
        }

        if (isset($staffMap[$key])) {
            return (int)$staffMap[$key];
        }

        // best-effort contains match
        foreach ($staffMap as $nm => $sid) {
            if ($nm !== '' && (strpos($key, $nm) !== false || strpos($nm, $key) !== false)) {
                return (int)$sid;
            }
        }

        return null;
    }

    private function findSemesterIdByDate($date)
    {
        $date = trim((string)$date);
        if ($date === '') {
            return null;
        }

        $ts = strtotime($date);
        if ($ts === false) {
            return null;
        }

        $d = date('Y-m-d', $ts);

        // 1) Exact match by date range
        $id = Semester::find()
            ->select(['id'])
            ->andWhere(['<=', 'date_start', $d])
            ->andWhere(['>=', 'date_end', $d])
            ->orderBy(['id' => SORT_DESC])
            ->scalar();

        $id = (int)$id;
        if ($id > 0) {
            return $id;
        }

        // 2) Approximate by month/session rule
        // - session 1: September (year1) until January (year2)
        // - session 2: February until August (year2)
        $y = (int)date('Y', $ts);
        $m = (int)date('n', $ts);

        $yearStart = null;
        $session = null;
        if ($m >= 9) {
            $yearStart = $y;
            $session = 1;
        } elseif ($m <= 1) {
            $yearStart = $y - 1;
            $session = 1;
        } else {
            $yearStart = $y - 1;
            $session = 2;
        }

        $yearEnd = $yearStart + 1;
        $approxId = (int)($yearStart . $yearEnd . $session);
        $sem = Semester::findOne($approxId);
        if ($sem) {
            return (int)$approxId;
        }

        return null;
    }

    private function ensureInternalSupervisorId($staffId)
    {
        $staffId = (int)$staffId;
        if ($staffId <= 0) {
            return null;
        }

        $sv = Supervisor::find()->where(['is_internal' => 1, 'staff_id' => $staffId])->one();
        if ($sv) {
            return (int)$sv->id;
        }

        $sv = new Supervisor();
        $sv->is_internal = 1;
        $sv->staff_id = $staffId;
        $sv->external_id = null;
        $sv->created_at = time();
        $sv->updated_at = time();
        if ($sv->save(false)) {
            return (int)$sv->id;
        }

        return null;
    }

    private function syncInternalSupervisorsFromStaff($facultyId = null, $staffActive = 1)
    {
        $q = Staff::find()->select(['id'])
            ->andWhere(['staff_active' => (int)$staffActive]);

        if ($facultyId !== null) {
            $q->andWhere(['faculty_id' => (int)$facultyId]);
        }

        $staffIds = $q->column();
        if (empty($staffIds)) {
            return;
        }

        $existing = Supervisor::find()
            ->select(['staff_id'])
            ->where(['is_internal' => 1])
            ->andWhere(['staff_id' => $staffIds])
            ->indexBy('staff_id')
            ->column();

        foreach ($staffIds as $sid) {
            if (isset($existing[$sid])) {
                continue;
            }

            $sv = new Supervisor();
            $sv->is_internal = 1;
            $sv->staff_id = (int)$sid;
            $sv->external_id = null;
            $sv->created_at = time();
            $sv->updated_at = time();
            $sv->save(false);
        }
    }
}
