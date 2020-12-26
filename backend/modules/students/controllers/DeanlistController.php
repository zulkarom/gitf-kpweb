<?php

namespace backend\modules\students\controllers;

use Yii;
use backend\models\SemesterForm;
use backend\modules\students\models\Student;
use backend\modules\students\models\DeanList;
use backend\modules\students\models\DeanListSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Semester;
use yii\filters\AccessControl;
use yii\db\Expression;
use backend\modules\students\models\UploadFile;
use backend\modules\students\models\UploadDeanListForm;
use yii\web\UploadedFile;

/**
 * DeanlistController implements the CRUD actions for DeanList model.
 */
class DeanlistController extends Controller
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
     * Lists all DeanList models.
     * @return mixed
     */
    public function actionIndex()
    {
		 $semester = new SemesterForm;
        if(Yii::$app->getRequest()->getQueryParam('SemesterForm')){
            $sem = Yii::$app->getRequest()->getQueryParam('SemesterForm');
            $semester->semester_id = $sem['semester_id'];
			$semester->str_search = $sem['str_search'];

        }else{
            $semester->semester_id = Semester::getCurrentSemester()->id;
        }
		
		
        $searchModel = new DeanListSearch();
		$searchModel->semester = $semester->semester_id;
		$searchModel->str_search = $semester->str_search;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'semester' => $semester,
        ]);
    }

    /**
     * Displays a single DeanList model.
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
     * Creates a new DeanList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DeanList();

        if ($model->load(Yii::$app->request->post())) {
			
			//check ada data
			$matric = $model->matric_no;
			$student = Student::findOne(['matric_no' => $matric]);
			if($student){
				$model->created_at = new Expression('NOW()');
				$model->created_by = Yii::$app->user->identity->id;
				if($model->save()){
					Yii::$app->session->addFlash('success', "Data Updated");
					return $this->redirect(['index']);
				}
			}else{
				Yii::$app->session->addFlash('error', "Student not found!");
			}
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DeanList model.
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

    /**
     * Deletes an existing DeanList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
		Yii::$app->session->addFlash('success', "Data Updated");
        return $this->redirect(['index']);
    }

    /**
     * Finds the DeanList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DeanList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DeanList::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionDownloadFile($id){
		$model = $this->findModel($id);
		if(!UploadFile::download($model, 'file', $model->matric_no, $model->semester_id)){
			echo 'File not exist!';
		}
	}
	
	public function actionUpload()
    {
        $model = new UploadDeanListForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->upload()) {
                Yii::$app->session->addFlash('success', "file is uploaded successfully"); 
                return $this->redirect(['index']);
            }
        }

        return $this->render('upload', ['model' => $model]);
    }
}
