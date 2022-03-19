<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use backend\modules\postgrad\models\Supervisor;
use backend\modules\postgrad\models\SupervisorSearch;
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
        $searchModel = new SupervisorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        $model = $this->findModel($id);
        $supervisees = $model->supervisees;
        $examinees = $model->examinees;
        
        return $this->render('view', [
            'model' => $model,
            'supervisees' => $supervisees,
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
