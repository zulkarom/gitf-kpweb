<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use backend\modules\postgrad\models\StudentPostGrad;
use backend\modules\postgrad\models\StudentPostGradSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;

/**
 * StudentPostGradController implements the CRUD actions for StudentPostGrad model.
 */
class StudentPostGradController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all StudentPostGrad models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentPostGradSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StudentPostGrad model.
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
     * Creates a new StudentPostGrad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StudentPostGrad();
        $modelUser = new User();
        $model->scenario = 'create';
        $modelUser->scenario = 'studPost';

        $random = rand(30,30000);

        if ($model->load(Yii::$app->request->post()) 
            && $modelUser->load(Yii::$app->request->post())) {

            $modelUser->username = $model->matric_no;
            $modelUser->password_hash = \Yii::$app->security->generatePasswordHash($random);
            $modelUser->status = 10;
            if($modelUser->save()){

                $model->user_id = $modelUser->id;

                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    $model->flashError();
                }
            }else{
                $modelUser->flashError();
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelUser' => $modelUser,
        ]);
    }

    /**
     * Updates an existing StudentPostGrad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelUser = User::findOne($model->user_id);

        if ($model->load(Yii::$app->request->post()) 
            && $modelUser->load(Yii::$app->request->post())) {

            if($modelUser->save()){

                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    $model->flashError();
                }
            }else{
                $modelUser->flashError();
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelUser' => $modelUser,
        ]);
    }

    /**
     * Deletes an existing StudentPostGrad model.
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
     * Finds the StudentPostGrad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StudentPostGrad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StudentPostGrad::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
