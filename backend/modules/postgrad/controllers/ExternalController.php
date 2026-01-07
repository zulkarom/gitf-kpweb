<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use backend\modules\postgrad\models\External;
use backend\modules\postgrad\models\ExternalSearch;
use backend\modules\postgrad\models\Supervisor;
use backend\modules\postgrad\models\SupervisorField;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

/**
 * ExternalController implements the CRUD actions for External model.
 */
class ExternalController extends Controller
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
     * Lists all External models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExternalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single External model.
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
     * Creates a new External model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new External();

        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = time();
            $model->updated_at = time();

            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->save()) {
                    // ensure there is a corresponding external Supervisor record
                    $supervisor = new Supervisor();
                    $supervisor->is_internal = 0;
                    $supervisor->external_id = $model->id;
                    $supervisor->staff_id = null;
                    $supervisor->created_at = time();
                    $supervisor->updated_at = time();

                    if ($supervisor->save(false)) {
                        // attach selected fields, if any
                        if (!empty($model->fields) && is_array($model->fields)) {
                            foreach ($model->fields as $fieldId) {
                                $sf = new SupervisorField();
                                $sf->sv_id = $supervisor->id;
                                $sf->field_id = (int)$fieldId;
                                $sf->save(false);
                            }
                        }

                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }

                $transaction->rollBack();
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing External model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // preload existing expertise fields
        if (Yii::$app->request->isGet) {
            $model->fields = ArrayHelper::getColumn($model->svFields, 'field_id');
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->updated_at = time();

            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->save()) {
                    // ensure there is a corresponding external Supervisor record
                    $supervisor = $model->supervisor;
                    if (!$supervisor) {
                        $supervisor = new Supervisor();
                        $supervisor->is_internal = 0;
                        $supervisor->external_id = $model->id;
                        $supervisor->staff_id = null;
                        $supervisor->created_at = time();
                        $supervisor->updated_at = time();
                        $supervisor->save(false);
                    }

                    // sync selected expertise fields
                    SupervisorField::deleteAll(['sv_id' => (int)$supervisor->id]);
                    if (!empty($model->fields) && is_array($model->fields)) {
                        foreach ($model->fields as $fieldId) {
                            $sf = new SupervisorField();
                            $sf->sv_id = (int)$supervisor->id;
                            $sf->field_id = (int)$fieldId;
                            $sf->save(false);
                        }
                    }

                    $transaction->commit();
                    return $this->redirect(['index']);
                }
                $transaction->rollBack();
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing External model.
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
            Yii::$app->session->addFlash('success', "Examiner Deleted");
        } catch(\yii\db\IntegrityException $e) {
            
            Yii::$app->session->addFlash('error', "Cannot delete the external at this stage");
            
        }
        
        
        
        
        return $this->redirect(['index']);
        
    }

    /**
     * Finds the External model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return External the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = External::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
