<?php

namespace backend\modules\questbank\controllers;

use Yii;
use backend\modules\questbank\models\Course;
use backend\modules\questbank\models\Question;
use backend\modules\questbank\models\Msword;
use backend\modules\questbank\models\QuestionOption;
use backend\modules\questbank\models\QuestionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use common\models\Model;
use yii\helpers\ArrayHelper;
use yii\db\Expression;


/**
 * QuestionController implements the CRUD actions for Question model.
 */
class QuestionController extends Controller
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
     * Lists all Question models.
     * @return mixed
     */
    public function actionIndex($course)
    {
		$course = $this->findCourse($course);
        $searchModel = new QuestionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'course' => $course
        ]);
    }

    /**
     * Displays a single Question model.
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
     * Creates a new Question model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Question();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Question model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $options = $model->options;

        if ($model->load(Yii::$app->request->post())) {
			
			$model->updated_at = new Expression('NOW()');    
            
            $oldIDs = ArrayHelper::map($options, 'id', 'id');
            
            
            $options = Model::createMultiple(QuestionOption::classname(), $options);
            
            Model::loadMultiple($options, Yii::$app->request->post());
            
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($options, 'id', 'id')));
            
            foreach ($options as $i => $option) {
                $option->option_order = $i;
            }
            
            
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($options) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            QuestionOption::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($options as $i => $option) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $option->question_id = $model->id;

                            if (!($flag = $option->save(false))) {
                                break;
                            }
                        }

                    }else{
						$model->flashError();
					}

                    if ($flag) {
                        $transaction->commit();
                            Yii::$app->session->addFlash('success', "Question updated");
                            return $this->redirect(['update','id' => $id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }

        }

        return $this->render('update', [
            'model' => $model,
			'options' => (empty($options)) ? [new QuestionOption] : $options
        ]);
    }

    /**
     * Deletes an existing Question model.
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
     * Finds the Question model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Question the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Question::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function findCourse($id)
    {
        if (($model = Course::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionMsword($course){
		
		$model = $this->findCourse($course);
		$word = new Msword;
		$word->model = $model;
		$word->generate();
		exit();
		
	}
}
