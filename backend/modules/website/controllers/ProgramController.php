<?php

namespace backend\modules\website\controllers;

use Yii;
use backend\modules\website\models\Program;
use backend\modules\website\models\ProgramRequirement;
use backend\modules\website\models\ProgramSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Model;
use yii\helpers\ArrayHelper;
use yii\db\Expression;


/**
 * ProgramController implements the CRUD actions for Program model.
 */
class ProgramController extends Controller
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
     * Lists all Program models.
     * @return mixed
     */
    public function actionIndex()
    {
		Program::syncProgram();
        $searchModel = new ProgramSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Program model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);
		
        return $this->render('view', [
            'model' => $model,
			
        ]);
    }


    /**
     * Updates an existing Program model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
	
	public function actionRequirement($program, $type)
    {
        $model = $this->findModel($program);
		$model->rtype = $type;
        $requirements = $model->requirements;
       
        if ($model->load(Yii::$app->request->post())) {
            
            $model->updated_at = new Expression('NOW()');    
            
            $oldIDs = ArrayHelper::map($requirements, 'id', 'id');
            
            
            $requirements = Model::createMultiple(ProgramRequirement::classname(), $requirements);
            
            Model::loadMultiple($requirements, Yii::$app->request->post());
            
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($requirements, 'id', 'id')));
            
            foreach ($requirements as $i => $requirement) {
                $requirement->req_order = $i;
            }
            
            
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($requirements) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            ProgramRequirement::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($requirements as $i => $requirement) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $requirement->program_id = $model->id;
							$requirement->req_type = $type;
							$requirement->updated_at = new Expression('NOW()');

                            if (!($flag = $requirement->save(false))) {
                                break;
                            }
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
                            Yii::$app->session->addFlash('success', "Requirements updated");
                            return $this->redirect(['view','id' => $model->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }
    }
	
	$types = $model->typeRequirement()[$type];
    
     return $this->render('requirement', [
            'model' => $model,
			'typeName' => $types[1],
            'requirements' => (empty($requirements)) ? [new ProgramRequirement] : $requirements
        ]);
    


    }



    /**
     * Finds the Program model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Program the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Program::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function findRequirementModel($program, $type)
    {
        if (($model = ProgramRequirement::findOne(['program_id' => $program, 'req_type' => $type])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
