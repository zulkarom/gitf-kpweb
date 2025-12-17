<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use backend\modules\postgrad\models\Supervisor;
use backend\modules\postgrad\models\SupervisorSearch;
use backend\models\Semester;
use backend\modules\postgrad\models\StudentRegister;
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
        $semesterId = Yii::$app->request->get('semester_id');
        if (empty($semesterId)) {
            $currentSem = Semester::getCurrentSemester();
            $semesterId = $currentSem ? $currentSem->id : null;
        }

        $searchModel = new SupervisorSearch();
        $params = Yii::$app->request->queryParams;
        $params[$searchModel->formName()]['semester_id'] = $semesterId;
        $dataProvider = $searchModel->search($params);

        // KPI 1: total staff that has at least one as penyelia utama (sv_role = 1)
        $countStaffMain = (new \yii\db\Query())
            ->from(['a' => Supervisor::tableName()])
            ->innerJoin(['ss' => 'pg_student_sv'], 'ss.supervisor_id = a.id AND ss.sv_role = 1')
            ->innerJoin(['sr' => StudentRegister::tableName()], 'sr.student_id = ss.student_id AND sr.semester_id = :sem', [':sem' => (int)$semesterId])
            ->count('DISTINCT a.id');

        // KPI 2: total staff that has at least one as penyelia bersama (sv_role = 2)
        $countStaffSecond = (new \yii\db\Query())
            ->from(['a' => Supervisor::tableName()])
            ->innerJoin(['ss' => 'pg_student_sv'], 'ss.supervisor_id = a.id AND ss.sv_role = 2')
            ->innerJoin(['sr' => StudentRegister::tableName()], 'sr.student_id = ss.student_id AND sr.semester_id = :sem', [':sem' => (int)$semesterId])
            ->count('DISTINCT a.id');


        // Compute color category counts based on total supervisees per supervisor
        $rows = (new \yii\db\Query())
            ->select(['a.id AS sid', 'COUNT(sr.id) AS total'])
            ->from(['a' => Supervisor::tableName()])
            ->leftJoin(['ss' => 'pg_student_sv'], 'ss.supervisor_id = a.id')
            ->leftJoin(['sr' => StudentRegister::tableName()], 'sr.student_id = ss.student_id AND sr.semester_id = :sem', [':sem' => (int)$semesterId])
            ->groupBy(['a.id'])
            ->all();

        $countRed = 0;    // 0-3
        $countYellow = 0; // 4-7
        $countGreen = 0;  // 8+
        foreach ($rows as $r) {
            $t = (int)$r['total'];
            if ($t <= 3) {
                $countRed++;
            } elseif ($t <= 7) {
                $countYellow++;
            } else {
                $countGreen++;
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
        ]);
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
        if (empty($semesterId)) {
            $currentSem = Semester::getCurrentSemester();
            $semesterId = $currentSem ? $currentSem->id : null;
        }

        $model = $this->findModel($id);
        $supervisees = $model->getSupervisees()
        ->joinWith(['student' => function($q){
            $q->alias('st');
        }])
        ->innerJoin(['sr' => StudentRegister::tableName()], 'sr.student_id = st.id AND sr.semester_id = :sem', [':sem' => (int)$semesterId])
        ->all();

        $superviseeRegs = [];
        if ($supervisees) {
            $studentIds = [];
            foreach ($supervisees as $sv) {
                $studentIds[] = $sv->student_id;
            }
            if (!empty($studentIds)) {
                $regs = StudentRegister::find()
                ->where(['semester_id' => (int)$semesterId])
                ->andWhere(['student_id' => $studentIds])
                ->all();
                if ($regs) {
                    foreach ($regs as $r) {
                        $superviseeRegs[$r->student_id] = $r;
                    }
                }
            }
        }

        $examinees = $model->examinees;
        
        return $this->render('view', [
            'model' => $model,
            'supervisees' => $supervisees,
            'superviseeRegs' => $superviseeRegs,
            'examinees' => $examinees
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
