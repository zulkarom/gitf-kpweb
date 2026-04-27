<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use backend\modules\postgrad\models\Supervisor;
use backend\modules\postgrad\models\SupervisorSearch;
use backend\models\Semester;
use backend\modules\postgrad\models\StudentRegister;
use backend\modules\staff\models\Staff;
use backend\modules\postgrad\models\PgSetting;
use backend\modules\postgrad\models\Student;
use backend\modules\postgrad\models\StudentStage;
use backend\modules\postgrad\models\StudentSupervisor;
use backend\modules\postgrad\models\PgStudentThesis;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use backend\modules\postgrad\models\SupervisorField;

/**
 * SupervisorController implements the CRUD actions for Supervisor model.
 */
class SupervisorController extends Controller
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
     * Lists all Supervisor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $tab = Yii::$app->request->get('tab', 'academic');

        $semesterId = Yii::$app->request->get('semester_id');
        if (empty($semesterId)) {
            $currentSem = Semester::getCurrentSemester();
            $semesterId = $currentSem ? $currentSem->id : null;
        }

        $searchModel = new SupervisorSearch();
        $params = Yii::$app->request->queryParams;
        $params[$searchModel->formName()]['semester_id'] = $semesterId;

        switch (strtolower((string)$tab)) {
            case 'transferred':
            case 'transfer':
            case 'quit':
            case 'transferred-quit':
                $params[$searchModel->formName()]['is_internal'] = 1;
                $params[$searchModel->formName()]['faculty_scope'] = 'academic';
                $params[$searchModel->formName()]['staff_active'] = 0;
                $params[$searchModel->formName()]['require_students'] = 1;
                $tab = 'transferred';
                break;
            case 'external':
                $params[$searchModel->formName()]['is_internal'] = 0;
                $params[$searchModel->formName()]['require_students'] = 1;
                $tab = 'external';
                break;
            case 'other':
                $params[$searchModel->formName()]['is_internal'] = 1;
                $params[$searchModel->formName()]['faculty_scope'] = 'other';
                $params[$searchModel->formName()]['staff_active'] = 1;
                $params[$searchModel->formName()]['require_students'] = 1;
                $tab = 'other';
                break;
            case 'academic':
            default:
                $params[$searchModel->formName()]['is_internal'] = 1;
                $params[$searchModel->formName()]['faculty_scope'] = 'academic';
                $params[$searchModel->formName()]['staff_active'] = 1;
                $tab = 'academic';
                break;
        }

        // Sync pg_supervisor with Staff module on page load so counts/list match.
        // (Only internal supervisors are synced; external supervisors remain manual.)
        if ($tab === 'academic') {
            $this->syncInternalSupervisorsFromStaff(1, 1);
        } elseif ($tab === 'other') {
            $this->syncInternalSupervisorsFromStaff(null, 1);
        }

        $dataProvider = $searchModel->search($params);

        $countStaffMain = 0;
        $countStaffSecond = 0;
        $countRed = 0;
        $countYellow = 0;
        $countGreen = 0;

        $tabCounts = [
            'academic' => (int)Staff::find()->where(['staff_active' => 1, 'faculty_id' => 1])->count(),
            // match list behavior: only show if they have students in selected semester
            'other' => (int)(new \yii\db\Query())
                ->from(['a' => Supervisor::tableName()])
                ->innerJoin(['stf' => 'staff'], 'stf.id = a.staff_id AND stf.staff_active = 1 AND stf.faculty_id <> 1')
                ->leftJoin(['ss' => 'pg_student_sv'], 'ss.supervisor_id = a.id')
                ->innerJoin(['sr' => StudentRegister::tableName()], 'sr.student_id = ss.student_id AND sr.semester_id = :sem', [':sem' => (int)$semesterId])
                ->where(['a.is_internal' => 1])
                ->count('DISTINCT a.id'),
            'external' => (int)(new \yii\db\Query())
                ->from(['a' => Supervisor::tableName()])
                ->leftJoin(['ss' => 'pg_student_sv'], 'ss.supervisor_id = a.id')
                ->innerJoin(['sr' => StudentRegister::tableName()], 'sr.student_id = ss.student_id AND sr.semester_id = :sem', [':sem' => (int)$semesterId])
                ->where(['a.is_internal' => 0])
                ->andWhere(['>', 'a.external_id', 0])
                ->count('DISTINCT a.id'),
            'transferred' => (int)(new \yii\db\Query())
                ->from(['a' => Supervisor::tableName()])
                ->innerJoin(['stf' => 'staff'], 'stf.id = a.staff_id AND stf.staff_active = 0 AND stf.faculty_id = 1')
                ->leftJoin(['ss' => 'pg_student_sv'], 'ss.supervisor_id = a.id')
                ->innerJoin(['sr' => StudentRegister::tableName()], 'sr.student_id = ss.student_id AND sr.semester_id = :sem', [':sem' => (int)$semesterId])
                ->where(['a.is_internal' => 1])
                ->count('DISTINCT a.id'),
        ];

        if ($tab === 'academic') {
            // KPI 1: total staff that has at least one as penyelia utama (sv_role = 1)
            $countStaffMain = (new \yii\db\Query())
                ->from(['a' => Supervisor::tableName()])
                ->innerJoin(['stf' => 'staff'], 'stf.id = a.staff_id AND stf.faculty_id = 1')
                ->innerJoin(['ss' => 'pg_student_sv'], 'ss.supervisor_id = a.id AND ss.sv_role = 1')
                ->innerJoin(['sr' => StudentRegister::tableName()], 'sr.student_id = ss.student_id AND sr.semester_id = :sem', [':sem' => (int)$semesterId])
                ->count('DISTINCT a.id');

            // KPI 2: total staff that has at least one as penyelia bersama (sv_role = 2)
            $countStaffSecond = (new \yii\db\Query())
                ->from(['a' => Supervisor::tableName()])
                ->innerJoin(['stf' => 'staff'], 'stf.id = a.staff_id AND stf.faculty_id = 1')
                ->innerJoin(['ss' => 'pg_student_sv'], 'ss.supervisor_id = a.id AND ss.sv_role = 2')
                ->innerJoin(['sr' => StudentRegister::tableName()], 'sr.student_id = ss.student_id AND sr.semester_id = :sem', [':sem' => (int)$semesterId])
                ->count('DISTINCT a.id');

            // Compute color category counts based on total supervisees per supervisor
            $rows = (new \yii\db\Query())
                ->select(['a.id AS sid', 'COUNT(sr.id) AS total'])
                ->from(['a' => Supervisor::tableName()])
                ->innerJoin(['stf' => 'staff'], 'stf.id = a.staff_id AND stf.faculty_id = 1')
                ->leftJoin(['ss' => 'pg_student_sv'], 'ss.supervisor_id = a.id')
                ->leftJoin(['sr' => StudentRegister::tableName()], 'sr.student_id = ss.student_id AND sr.semester_id = :sem', [':sem' => (int)$semesterId])
                ->groupBy(['a.id'])
                ->all();

            foreach ($rows as $r) {
                $t = (int)$r['total'];
                $color = PgSetting::classifyTrafficLight('supervisor', $t);
                if ($color === 'green') {
                    $countGreen++;
                } elseif ($color === 'yellow') {
                    $countYellow++;
                } else {
                    $countRed++;
                }
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'countStaffMain' => (int)$countStaffMain,
            'countStaffSecond' => (int)$countStaffSecond,
            // Removed student supervision KPIs by user edit
            'countRed' => $countRed,
            'countYellow' => $countYellow,
            'countGreen' => $countGreen,
            'semesterId' => $semesterId,
            'tab' => $tab,
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

    /**
     * Displays a single Supervisor model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $semesterId = Yii::$app->request->get('semester_id');

        $model = $this->findModel($id);

        $superviseeFilterModel = new class([
            'sv_name' => null,
            'sv_program_id' => null,
            'sv_role' => null,
            'sv_status_daftar' => null,
        ]) extends \yii\base\DynamicModel {
            public function formName()
            {
                return '';
            }
        };
        $superviseeFilterModel->addRule(['sv_name', 'sv_program_id', 'sv_role', 'sv_status_daftar'], 'safe');
        $superviseeFilterModel->load(Yii::$app->request->get(), '');

        $superviseeQuery = $model->getSupervisees()->alias('ssv')
            ->joinWith(['student' => function($q){
                $q->alias('st');
            }])
            ->joinWith(['student.user u', 'student.program p']);

        $statusExpr = new \yii\db\Expression('st.last_status_daftar');
        if (!empty($semesterId)) {
            $superviseeQuery->innerJoin(
                ['sr' => StudentRegister::tableName()],
                'sr.student_id = st.id AND sr.semester_id = :sem',
                [':sem' => (int)$semesterId]
            );
        }

        if ($superviseeFilterModel->sv_name !== null && $superviseeFilterModel->sv_name !== '') {
            $name = trim((string)$superviseeFilterModel->sv_name);
            $superviseeQuery->andFilterWhere([
                'or',
                ['like', 'u.fullname', $name],
                ['like', 'st.matric_no', $name],
            ]);
        }

        if ($superviseeFilterModel->sv_program_id !== null && $superviseeFilterModel->sv_program_id !== '') {
            $superviseeQuery->andFilterWhere(['st.program_id' => (int)$superviseeFilterModel->sv_program_id]);
        }

        if ($superviseeFilterModel->sv_role !== null && $superviseeFilterModel->sv_role !== '') {
            $superviseeQuery->andFilterWhere(['ssv.sv_role' => (int)$superviseeFilterModel->sv_role]);
        }

        if ($superviseeFilterModel->sv_status_daftar !== null && $superviseeFilterModel->sv_status_daftar !== '') {
            $superviseeQuery->andFilterWhere(['st.last_status_daftar' => (int)$superviseeFilterModel->sv_status_daftar]);
        }

        $statusRankExpr = new \yii\db\Expression(
            'CASE WHEN ' . $statusExpr->expression . ' = :statusDaftar THEN 0 ELSE 1 END',
            [':statusDaftar' => (int)StudentRegister::STATUS_DAFTAR_DAFTAR]
        );

        $superviseeQuery->select(['ssv.*'])->addSelect([
            'status_code' => $statusExpr,
            'status_rank' => $statusRankExpr,
        ]);

        $superviseeProvider = new ActiveDataProvider([
            'query' => $superviseeQuery,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'status_rank' => SORT_ASC,
                    'sv_role' => SORT_ASC,
                ],
                'attributes' => [
                    'sv_role',
                    'status_rank',
                    'status_code',
                ],
            ],
        ]);

        $examineeFilterModel = new class([
            'ex_name' => null,
            'ex_stage_id' => null,
            'ex_committee_role' => null,
            'ex_result' => null,
        ]) extends \yii\base\DynamicModel {
            public function formName()
            {
                return '';
            }
        };
        $examineeFilterModel->addRule(['ex_name', 'ex_stage_id', 'ex_committee_role', 'ex_result'], 'safe');
        $examineeFilterModel->load(Yii::$app->request->get(), '');

        $examineeQuery = \backend\modules\postgrad\models\Student::find()->alias('a')
            ->select([
                'id' => 'a.id',
                'matric_no' => 'a.matric_no',
                'fullname' => 'u.fullname',
                'stage_id' => 's.stage_id',
                'stage_name' => 'r.stage_name',
                'stage_name_en' => 'r.stage_name_en',
                'stage_status' => 's.status',
                'committee_role' => 'e.committee_role',
                'committee_role_label' => new \yii\db\Expression(
                    "CASE e.committee_role "
                    . "WHEN 1 THEN 'Chairman' "
                    . "WHEN 2 THEN 'Deputy Chairman' "
                    . "WHEN 3 THEN 'Examiner 1' "
                    . "WHEN 4 THEN 'Examiner 2' "
                    . "ELSE '' END"
                ),
            ])
            ->joinWith(['user u']);

        if (!empty($semesterId)) {
            $examineeQuery->leftJoin('pg_student_stage s', 's.student_id = a.id AND s.semester_id = :sem', [':sem' => (int)$semesterId]);
            $examineeQuery->leftJoin(StudentRegister::tableName() . ' sr', 'sr.student_id = a.id AND sr.semester_id = :sem', [':sem' => (int)$semesterId]);
            $examineeQuery->addSelect(['status_daftar' => 'sr.status_daftar']);
        } else {
            $examineeQuery->leftJoin('pg_student_stage s', 's.student_id = a.id');
            $examineeQuery->addSelect(['status_daftar' => 'a.last_status_daftar']);
        }

        $examineeQuery
            ->innerJoin('pg_stage_examiner e', 'e.stage_id = s.id AND e.examiner_id = :examinerId', [':examinerId' => (int)$model->id])
            ->leftJoin('pg_res_stage r', 'r.id = s.stage_id');

        if ($examineeFilterModel->ex_name !== null && $examineeFilterModel->ex_name !== '') {
            $name = trim((string)$examineeFilterModel->ex_name);
            $examineeQuery->andFilterWhere([
                'or',
                ['like', 'u.fullname', $name],
                ['like', 'a.matric_no', $name],
            ]);
        }

        if ($examineeFilterModel->ex_stage_id !== null && $examineeFilterModel->ex_stage_id !== '') {
            $examineeQuery->andFilterWhere(['s.stage_id' => (int)$examineeFilterModel->ex_stage_id]);
        }

        if ($examineeFilterModel->ex_committee_role !== null && $examineeFilterModel->ex_committee_role !== '') {
            $examineeQuery->andFilterWhere(['e.committee_role' => (int)$examineeFilterModel->ex_committee_role]);
        }

        if ($examineeFilterModel->ex_result !== null && $examineeFilterModel->ex_result !== '') {
            $examineeQuery->andFilterWhere(['s.status' => (int)$examineeFilterModel->ex_result]);
        }

        $examineeProvider = new ActiveDataProvider([
            'query' => $examineeQuery,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'fullname' => SORT_ASC,
                ],
                'attributes' => [
                    'fullname' => [
                        'asc' => ['u.fullname' => SORT_ASC],
                        'desc' => ['u.fullname' => SORT_DESC],
                    ],
                    'matric_no' => [
                        'asc' => ['a.matric_no' => SORT_ASC],
                        'desc' => ['a.matric_no' => SORT_DESC],
                    ],
                ],
            ],
        ]);
        
        return $this->render('view', [
            'model' => $model,
            'superviseeProvider' => $superviseeProvider,
            'semesterId' => $semesterId,
            'examineeProvider' => $examineeProvider,
            'examineeFilterModel' => $examineeFilterModel,
            'superviseeFilterModel' => $superviseeFilterModel,
        ]);
    }

    public function actionStudentQuickView($student_id)
    {
        $semesterId = Yii::$app->request->get('semester_id');

        $student = Student::find()->where(['id' => (int)$student_id])->one();
        if (!$student) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $activeTitle = PgStudentThesis::find()
            ->where(['student_id' => (int)$student->id, 'is_active' => 1])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        $stages = StudentStage::find()->alias('a')
            ->where(['a.student_id' => (int)$student->id])
            ->joinWith(['stage stg', 'semester sem'])
            ->orderBy(['a.semester_id' => SORT_DESC, 'a.id' => SORT_DESC])
            ->all();

        $activeSupervisors = StudentSupervisor::find()->alias('ss')
            ->where(['ss.student_id' => (int)$student->id, 'ss.is_active' => 1])
            ->joinWith(['supervisor sv'])
            ->orderBy(['ss.sv_role' => SORT_ASC, 'ss.id' => SORT_ASC])
            ->all();

        $registrations = StudentRegister::find()->alias('sr')
            ->where(['sr.student_id' => (int)$student->id])
            ->joinWith(['semester sem'])
            ->orderBy(['sr.semester_id' => SORT_DESC, 'sr.id' => SORT_DESC])
            ->all();

        return $this->renderAjax('_student_quick_view', [
            'student' => $student,
            'semesterId' => $semesterId,
            'activeTitle' => $activeTitle,
            'stages' => $stages,
            'activeSupervisors' => $activeSupervisors,
            'registrations' => $registrations,
        ]);
    }

    /**
     * Creates a new Supervisor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Supervisor();

        if ($model->load(Yii::$app->request->post())) {
            
            $model->created_at = time();
            $model->updated_at = time();
            
            if($model->is_internal == 1){
                $model->external_id = null;
            }else{
                $model->staff_id = null;
            }
            
            
            $transaction = Yii::$app->db->beginTransaction();
            try {
                
                if($model->save()){
                    
                    if($this->updateFields($model)){
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                    
                }

            }
            catch (\Exception $e)
            {
                $transaction->rollBack();
                Yii::$app->session->addFlash('error', $e->getMessage());
            }
            
            
            
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    private function updateFields($model){
        $fields = $model->fields;
        //if($fields){
        
            
            $kira_post = $fields ? count($fields) : 0;
           // echo $kira_post; die();
            $kira_lama = count($model->svFields);
            if($kira_post > $kira_lama){
                
                $bil = $kira_post - $kira_lama;
                for($i=1;$i<=$bil;$i++){
                    //echo $bil;
                    //die();
                    $insert = new SupervisorField();
                    $insert->sv_id = $model->id;
                    $insert->field_id = null;
                    if(!$insert->save()){
                        print_r($insert->getErrors());
                    }
                }
            }else if($kira_post < $kira_lama){
                
                $bil = $kira_lama - $kira_post;
                $deleted = SupervisorField::find()
                ->where(['sv_id'=>$model->id])
                ->limit($bil)
                ->all();
                if($deleted){
                    foreach($deleted as $del){
                        $del->delete();
                    }
                }
            }
            
            $update_sv = SupervisorField::find()
            ->where(['sv_id' => $model->id])
            ->all();
            
            if($update_sv){
                $i=0;
                foreach($update_sv as $ut){
                    $ut->field_id = $fields[$i];
                    $ut->save();
                    $i++;
                }
            }
            
            
            
            
        //}//
        
        return true;
    }

    /**
     * Updates an existing Supervisor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->updated_at = time();
            
            if($model->is_internal == 1){
                $model->external_id = null;
            }else{
                $model->staff_id = null;
            }
            
            $transaction = Yii::$app->db->beginTransaction();
            try {
                
                if($model->save()){
                   // echo 'hai';die();
                    if($this->updateFields($model)){
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                    
                }else{
                    print_r($model->getErrors());
                    die();
                }
                
            }
            catch (\Exception $e)
            {
                $transaction->rollBack();
                echo $e->getMessage(); die();
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Supervisor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            $model = $this->findModel($id);
            $model->delete();
            Yii::$app->session->addFlash('success', "Supervisor Deleted");
        } catch(\yii\db\IntegrityException $e) {
            
            Yii::$app->session->addFlash('error', "Cannot delete supervisor at this stage");
            
        }
        
        
        
        
        return $this->redirect(['index']);
        
    }

    /**
     * Finds the Supervisor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Supervisor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Supervisor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
