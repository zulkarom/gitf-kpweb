<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\db\Query;
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

        $rows = [];
        if ($semester) {
            $query = (new Query())
                ->select([
                    'supervisor_id' => 'se.examiner_id',
                    'pengerusi' => "SUM(CASE WHEN se.committee_role = 1 THEN 1 ELSE 0 END)",
                    'penolong' => "SUM(CASE WHEN se.committee_role = 2 THEN 1 ELSE 0 END)",
                    'pemeriksa1' => "SUM(CASE WHEN se.committee_role = 3 THEN 1 ELSE 0 END)",
                    'pemeriksa2' => "SUM(CASE WHEN se.committee_role = 4 THEN 1 ELSE 0 END)",
                ])
                ->from(['se' => StageExaminer::tableName()])
                ->innerJoin(['st' => StudentStage::tableName()], 'st.id = se.stage_id')
                ->innerJoin(['sv' => Supervisor::tableName()], 'sv.id = se.examiner_id')
                ->where(['st.semester_id' => $semester_id]);

            if ($tab === 'external') {
                // External examiners: non-internal supervisors with an external record
                $query->andWhere(['sv.is_internal' => 0])
                    ->andWhere(['>', 'sv.external_id', 0]);
            } else {
                // Internal staff, filter by staff faculty/active status using Staff table
                if ($tab === 'academic') {
                    // FKP active staff
                    $query->innerJoin(['stf' => Staff::tableName()], 'stf.id = sv.staff_id AND stf.faculty_id = 1 AND stf.staff_active = 1')
                        ->andWhere(['sv.is_internal' => 1]);
                } elseif ($tab === 'other') {
                    // Other faculty active staff
                    $query->innerJoin(['stf' => Staff::tableName()], 'stf.id = sv.staff_id AND stf.staff_active = 1 AND stf.faculty_id <> 1')
                        ->andWhere(['sv.is_internal' => 1]);
                } elseif ($tab === 'transferred') {
                    // FKP transferred/quit staff
                    $query->innerJoin(['stf' => Staff::tableName()], 'stf.id = sv.staff_id AND stf.faculty_id = 1 AND stf.staff_active = 0')
                        ->andWhere(['sv.is_internal' => 1]);
                }
            }

            $rows = $query
                ->groupBy(['se.examiner_id'])
                ->all();
        }

        // attach supervisor models
        $data = [];
        if ($rows) {
            $ids = array_column($rows, 'supervisor_id');
            $supers = Supervisor::find()->where(['id' => $ids])->indexBy('id')->all();
            foreach ($rows as $r) {
                $sup = isset($supers[$r['supervisor_id']]) ? $supers[$r['supervisor_id']] : null;
                $data[] = [
                    'supervisor' => $sup,
                    'pengerusi' => (int)$r['pengerusi'],
                    'penolong' => (int)$r['penolong'],
                    'pemeriksa1' => (int)$r['pemeriksa1'],
                    'pemeriksa2' => (int)$r['pemeriksa2'],
                ];
            }
        }

        $semesterList = Semester::listSemesterArray();

        return $this->render('index', [
            'semester' => $semester,
            'semester_id' => $semester_id,
            'semesterList' => $semesterList,
            'data' => $data,
            'tab' => $tab,
        ]);
    }
}
