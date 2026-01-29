<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\Semester;
use backend\modules\postgrad\models\ResearchStage;
use backend\modules\postgrad\models\StageExaminer;
use backend\modules\postgrad\models\Student;
use backend\modules\postgrad\models\StudentStage;
use backend\modules\postgrad\models\Supervisor;
use backend\modules\postgrad\models\PgSetting;

class MycommitteeController extends Controller
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

        $query = StageExaminer::find()->alias('se')
            ->innerJoin(['stg' => StudentStage::tableName()], 'stg.id = se.stage_id')
            ->innerJoin(['s' => Student::tableName()], 's.id = stg.student_id')
            ->leftJoin(['u' => 'user'], 'u.id = s.user_id')
            ->leftJoin(['rs' => ResearchStage::tableName()], 'rs.id = stg.stage_id')
            ->select([
                'se.id',
                'se.stage_id',
                'se.examiner_id',
                'se.committee_role',
                'se.appoint_date',
                'student_id' => 's.id',
                'matric_no' => 's.matric_no',
                'student_name' => 'u.fullname',
                'semester_id' => 'stg.semester_id',
                'stage_name' => 'rs.stage_name',
                'stage_name_en' => 'rs.stage_name_en',
                'stage_status' => 'stg.status',
                'committee_role_label' => new Expression(
                    "CASE se.committee_role "
                    . "WHEN 1 THEN 'Chairman' "
                    . "WHEN 2 THEN 'Deputy Chairman' "
                    . "WHEN 3 THEN 'Examiner 1' "
                    . "WHEN 4 THEN 'Examiner 2' "
                    . "ELSE '' END"
                ),
            ])
            ->asArray()
            ->andWhere(['stg.semester_id' => (int)$semesterId]);

        if ($supervisorId) {
            $query->andWhere(['se.examiner_id' => (int)$supervisorId]);
        } else {
            $query->andWhere('0=1');
        }

        $stats = [
            'chairman' => 0,
            'deputy' => 0,
            'examiner1' => 0,
            'examiner2' => 0,
            'total' => 0,
            'total_color' => 'red',
        ];

        if ($supervisorId) {
            $roleRows = StageExaminer::find()->alias('se')
                ->select([
                    'se.committee_role',
                    'cnt' => 'COUNT(*)',
                ])
                ->innerJoin(['stg' => StudentStage::tableName()], 'stg.id = se.stage_id')
                ->where([
                    'se.examiner_id' => (int)$supervisorId,
                    'stg.semester_id' => (int)$semesterId,
                    'se.committee_role' => [1, 2, 3, 4],
                ])
                ->groupBy(['se.committee_role'])
                ->asArray()
                ->all();

            foreach ($roleRows as $r) {
                $role = (int)($r['committee_role'] ?? 0);
                $cnt = (int)($r['cnt'] ?? 0);
                if ($role === 1) { $stats['chairman'] = $cnt; }
                if ($role === 2) { $stats['deputy'] = $cnt; }
                if ($role === 3) { $stats['examiner1'] = $cnt; }
                if ($role === 4) { $stats['examiner2'] = $cnt; }
                $stats['total'] += $cnt;
            }

            $stats['total_color'] = PgSetting::classifyTrafficLight('exam_committee', (int)$stats['total']);
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
                    'committee_role' => [
                        'asc' => ['se.committee_role' => SORT_ASC],
                        'desc' => ['se.committee_role' => SORT_DESC],
                    ],
                    'stage_name' => [
                        'asc' => ['rs.stage_name' => SORT_ASC],
                        'desc' => ['rs.stage_name' => SORT_DESC],
                    ],
                ],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'semesterId' => $semesterId,
            'stats' => $stats,
        ]);
    }
}
