<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\User;
use common\models\Country;
use backend\modules\esiap\models\Program;
use backend\modules\postgrad\models\Field;
use backend\modules\postgrad\models\Student;
use backend\modules\postgrad\models\StudentPostGradSearch;
use backend\modules\postgrad\models\Supervisor;
use backend\modules\postgrad\models\StudentSupervisor;

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

        return $this->render('/student/mystudents', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionStats()
    {
        $user = Yii::$app->user->identity;
        $staff = $user && isset($user->staff) ? $user->staff : null;

        if (!$staff) {
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

            return $this->render('/student/mystats', [
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

            return $this->render('/student/mystats', [
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

        $activeCount = (int) (new \yii\db\Query())
            ->from(['s' => $studentTable])
            ->innerJoin(['ss' => $svTable], 'ss.student_id = s.id')
            ->where([
                'ss.supervisor_id' => $supervisor->id,
                's.status' => Student::STATUS_ACTIVE,
            ])
            ->count('*');

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

        $masterRows = (new \yii\db\Query())
            ->select([
                's.study_mode_rc',
                'cnt' => 'COUNT(*)',
            ])
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
        foreach ($masterRows as $r) {
            $key = (string)$r['study_mode_rc'];
            if (isset($masterRc[$key])) { $masterRc[$key] = (int)$r['cnt']; }
        }

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

        return $this->render('/student/mystats', [
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
}
