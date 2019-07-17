<?php

namespace backend\modules\erpd\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use backend\modules\erpd\models\Research;
use backend\modules\erpd\models\Researchers;
use backend\modules\erpd\models\ResearchSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use common\models\Model;

/**
 * ResearchController implements the CRUD actions for Research model.
 */
class ResearchController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Research models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ResearchSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Research model.
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
     * Creates a new Research model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Research();
		$researchers = $model->researchers;
		
		if ($model->load(Yii::$app->request->post())) {
            
			$model->res_user = Yii::$app->user->identity->id;
			$model->created_at = new Expression('NOW()');

            $oldResearcherIDs = ArrayHelper::map($researchers, 'res_id', 'res_id');
            
            $researchers = Model::createMultiple(Researchers::classname());
            
            Model::loadMultiple($researchers, Yii::$app->request->post());
            
            $deletedResearcherIDs = array_diff($oldResearcherIDs, array_filter(ArrayHelper::map($researchers, 'res_id', 'res_id')));
            
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($researchers) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        
                        if (! empty($deletedResearcherIDs)) {
                            Researchers::deleteAll(['res_id' => $deletedResearcherIDs]);
                        }
                        
                        foreach ($researchers as $indexAu => $researcher) {
                            
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $researcher->res_id = $model->res_id;

                            if (!($flag = $researcher->save(false))) {
                                break;
                            }
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
                            Yii::$app->session->addFlash('success', "Research saved.");
                            return $this->redirect('index');
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }
		}
        
        
        return $this->render('create', [
            'model' => $model,
            'researchers' => (empty($researchers)) ? [new Researchers] : $researchers
        ]);

    }

    /**
     * Updates an existing Research model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
	{
        $model = $this->findModel($id);
		$researchers = $model->researchers;
		
		if ($model->load(Yii::$app->request->post())) {
            
			$model->res_user = Yii::$app->user->identity->id;
			$model->created_at = new Expression('NOW()');

            $oldResearcherIDs = ArrayHelper::map($researchers, 'res_id', 'res_id');
            
            $researchers = Model::createMultiple(Researchers::classname());
            
            Model::loadMultiple($researchers, Yii::$app->request->post());
            
            $deletedResearcherIDs = array_diff($oldResearcherIDs, array_filter(ArrayHelper::map($researchers, 'res_id', 'res_id')));
            
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($researchers) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        
                        if (! empty($deletedResearcherIDs)) {
                            Researchers::deleteAll(['res_id' => $deletedResearcherIDs]);
                        }
                        
                        foreach ($researchers as $indexAu => $researcher) {
                            
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $researcher->res_id = $model->res_id;

                            if (!($flag = $researcher->save(false))) {
                                break;
                            }
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
                            Yii::$app->session->addFlash('success', "Research saved.");
                            return $this->redirect('index');
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }
		}
        
        
        return $this->render('create', [
            'model' => $model,
            'researchers' => (empty($researchers)) ? [new Researchers] : $researchers
        ]);

    }

    /**
     * Deletes an existing Research model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Research model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Research the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Research::findOne(['res_id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
