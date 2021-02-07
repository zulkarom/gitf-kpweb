<?php

namespace backend\modules\students\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Expression;
use yii\web\UploadedFile;

use backend\modules\students\models\Student;
use backend\modules\students\models\Download;
use backend\modules\students\models\DownloadSearch;
use backend\modules\students\models\DownloadCategory;
use backend\modules\students\models\DownloadCategoryForm;
use backend\modules\students\models\UploadFile;
use backend\modules\students\models\UploadDownloadForm;


/**
 * DownloadController implements the CRUD actions for Download model.
 */
class DownloadController extends Controller
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
     * Lists all Download models.
     * @return mixed
     */
    public function actionIndex()
    {
		 $category = new DownloadCategoryForm;
        if(Yii::$app->getRequest()->getQueryParam('DownloadCategoryForm')){
            $cat = Yii::$app->getRequest()->getQueryParam('DownloadCategoryForm');
            $category->category_id = $cat['category_id'];
			$category->str_search = $cat['str_search'];

        }else{
            $category->category_id = DownloadCategory::getDefaultCategory()->id;
        }
		
		
        $searchModel = new DownloadSearch();
		$searchModel->category = $category->category_id;
		$searchModel->str_search = $category->str_search;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'category' => $category,
        ]);
    }

    /**
     * Displays a single Download model.
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
     * Creates a new Download model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Download();

        if ($model->load(Yii::$app->request->post())) {
			
			//check ada data
			$matric = $model->matric_no;
			$student = Student::findOne(['matric_no' => $matric]);
			if($student){
				if(empty($student->nric)){
					ii::$app->session->addFlash('error', "Student Ic Number is Empty. Make sure the the student ic number is set in Student data!");
				}else{
					$model->created_at = new Expression('NOW()');
					$model->created_by = Yii::$app->user->identity->id;
					if($model->save()){
						Yii::$app->session->addFlash('success', "Data Updated");
						return $this->redirect(['index']);
					}
				}
				
			}else{
				Yii::$app->session->addFlash('error', "Student Data not found. Make sure the the student exist in Student data!");
			}
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Download model.
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
     * Deletes an existing Download model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		$model = $this->findModel($id);
		$file = Yii::getAlias('@upload/student-download/'. $model->category_id .'/' . $model->matric_no . '.pdf');

        if($model->delete()){
            if (is_file($file)) {
                unlink($file);
                
            }
            Yii::$app->session->addFlash('success', "Data Deleted");
			return $this->redirect(['index']);
        }
		
		

		
		
    }

    /**
     * Finds the Download model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Download the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Download::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionDownloadFile($id){
		$model = $this->findModel($id);
		if(!UploadFile::downloadCategory($model)){
			echo 'File not exist!';
		}
	}
	
	public function actionUpload()
    {
        $model = new UploadDownloadForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->upload()) {
                return $this->redirect(['upload']);
            }
        }

        return $this->render('upload', ['model' => $model]);
    }
}
