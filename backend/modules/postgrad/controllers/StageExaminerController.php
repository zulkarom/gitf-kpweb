<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use backend\modules\postgrad\models\StageExaminer;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use backend\modules\postgrad\models\StudentStage;

/**
 * StageExaminerController implements the CRUD actions for StageExaminer model.
 */
class StageExaminerController extends Controller
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
     * Lists all StageExaminer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => StageExaminer::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StageExaminer model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new StageExaminer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($stage)
    {
        $model = new StageExaminer();
        $stage = $this->findStage($stage);

        if ($model->load(Yii::$app->request->post())) {
            $model->stage_id = $stage->id;
            if($model->save()){
                return $this->redirect(['student-stage/view', 'id' => $stage->id]);
            }
            
        }

        return $this->render('create', [
            'model' => $model,
            'stage' => $stage,
        ]);
    }

    /**
     * Updates an existing StageExaminer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['student-stage/view', 'id' => $model->stage_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing StageExaminer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            $model = $this->findModel($id);
            $s = $model->stage_id;
            $model->delete();
            Yii::$app->session->addFlash('success', "Examiner Deleted");
        } catch(\yii\db\IntegrityException $e) {
            
            Yii::$app->session->addFlash('error', "Cannot delete the examiner at this stage");
            
        }
        
        
        
        
        return $this->redirect(['student-stage/view', 'id' => $s]);
        
    }

    /**
     * Finds the StageExaminer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StageExaminer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StageExaminer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findStage($id)
    {
        if (($model = StudentStage::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
