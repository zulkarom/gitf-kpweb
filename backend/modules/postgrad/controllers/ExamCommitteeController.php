<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\db\Query;
use yii\data\ArrayDataProvider;
use backend\models\Semester;
use backend\modules\postgrad\models\StageExaminer;
use backend\modules\postgrad\models\StudentStage;
use backend\modules\postgrad\models\Supervisor;
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
                if ($t <= 3) {
                    $countGreen++;
                } elseif ($t <= 7) {
                    $countYellow++;
                } else {
                    $countRed++;
                }
            }

            $data = $baseData;
            if (!empty($kpi)) {
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
                            return (int)$r['total'] >= 0 && (int)$r['total'] <= 3;
                        case 'yellow':
                            return (int)$r['total'] >= 4 && (int)$r['total'] <= 7;
                        case 'red':
                            return (int)$r['total'] >= 8;
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
