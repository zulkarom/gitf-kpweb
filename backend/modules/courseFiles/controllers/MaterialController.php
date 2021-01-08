<?php

namespace backend\modules\courseFiles\controllers;

use Yii;
use backend\modules\courseFiles\models\Material;
use backend\modules\courseFiles\models\MaterialItem;
use backend\modules\esiap\models\Course;
use backend\modules\courseFiles\models\MaterialSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use backend\modules\courseFiles\models\AddMaterialForm;
use yii\filters\AccessControl;
use common\models\UploadFile;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * MaterialController implements the CRUD actions for Material model.
 */
class MaterialController extends Controller
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
     * Lists all Material models.
     * @return mixed
     */
    public function actionIndex($course)
    {
        $searchModel = new MaterialSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$course = $this->findCourse($course);
		

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'course' => $course
        ]);
    }

    /**
     * Displays a single Material model.
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
     * Creates a new Material model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($course)
    {
        $model = new Material();
		$course = $this->findCourse($course);

        if ($model->load(Yii::$app->request->post())) {
			$model->created_by = Yii::$app->user->identity->id;
			$model->course_id = $course->id;
			$model->created_at = new Expression('NOW()');
			if($model->save()){
				return $this->redirect(['update', 'id' => $model->id]);
			}else{
				$model->flashError();
			}
        }

        return $this->render('create', [
            'model' => $model,
			'course' => $course
        ]);
    }

    /**
     * Updates an existing Material model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$course_id = $model->course_id;
		$course = $this->findCourse($course_id);
		$addMaterial = new AddMaterialForm;
		
        if ($model->load(Yii::$app->request->post())) {
			if($model->save()){
				return $this->redirect(['update', 'id' => $model->id]);
			}
        }
		
		if ($addMaterial->load(Yii::$app->request->post())) {
			$count = $addMaterial->material_number;
			if($count>0){
				for($i=1;$i<=$count;$i++){
					$item = new MaterialItem;
					$item->material_id = $model->id;
					$item->item_category = 2;
					$item->save();
				}				
			}
			Yii::$app->session->addFlash('success', 'Material Added');
			return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
			'course' => $course,
			'addMaterial' => $addMaterial
        ]);
    }

    /**
     * Deletes an existing Material model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteGroup($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
	public function actionDelete($attr, $id)
    {
                    
        $attr = $this->clean($attr);
        $model = $this->findMaterialItem($id);

        $attr_db = $attr . '_file';
        
        $file = Yii::getAlias('@upload/' . $model->{$attr_db});

        if($model->delete()){
            if (is_file($file)) {
                unlink($file);
                
            }
            
            return Json::encode([
                        'good' => 2,
                    ]);
            
        }else{
            return Json::encode([
                        'errors' => $model->getErrors(),
                    ]);
        }
        


    }

    /**
     * Finds the Material model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Material the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Material::findOne($id)) !== null) {
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
	
	public function actionDeleteRow($id){
        $model = $this->findMaterialItem($id);
        if($model->delete()){
            return $this->redirect(['update', 'id' => $model->id]);
        }
    }
    
    public function actionUploadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findMaterialItem($id);
		$code = $model->material->course->course_code;
		
        $model->file_controller = 'material';
        $path = 'teaching-materials/'.$code.'/'.$model->material_id.'/'.$model->item_category;
        return UploadFile::upload($model, $attr, 'updated_at', $path);

    }
    
    public function actionDownload($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findMaterialItem($id);
        $filename = $model->item_name;
        UploadFile::download($model, $attr, $filename);
    }

    protected function findMaterialItem($id)
    {
        if (($model = MaterialItem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
/*     public function actionDelete($attr, $id)
    {
                    
        $attr = $this->clean($attr);
        $model = $this->findMaterialItem($id);

        $attr_db = $attr . '_file';
        
        $file = Yii::getAlias('@upload/' . $model->{$attr_db});

        if($model->delete()){
            if (is_file($file)) {
                unlink($file);
                
            }
            
            return Json::encode([
                        'good' => 2,
                    ]);
            
        }else{
            return Json::encode([
                        'errors' => $model->getErrors(),
                    ]);
        }
    } */
	
	protected function clean($string){
        $allowed = ['item'];
		if(in_array($string,$allowed)){
			return $string;
		}
        throw new NotFoundHttpException('Invalid Attribute');
    }

}
