<?php

namespace backend\modules\erpd\controllers;

use Yii;
use backend\modules\erpd\models\Consultation;
use backend\modules\erpd\models\ConsultationTag;
use backend\modules\erpd\models\ConsultationSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\UploadFile as Upload;
use yii\helpers\Json;
use yii\db\Expression;
use yii\filters\AccessControl;

/**
 * ConsultationController implements the CRUD actions for Consultation model.
 */
class ConsultationController extends Controller
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
     * Lists all Consultation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConsultationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	

    /**
     * Displays a single Consultation model.
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
     * Creates a new Consultation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Consultation();

        if ($model->load(Yii::$app->request->post()) ) {
			$model->csl_staff = Yii::$app->user->identity->staff->id;
			$model->created_at = new Expression('NOW()');
			if($model->save()){
				
				$tag = new ConsultationTag;
				$tag->consult_id = $model->id;
				$tag->staff_id = Yii::$app->user->identity->staff->id;
				$tag->save();
				
				$tag = Yii::$app->request->post('tagged_staff');
				
						if($tag){
							$kira_post = count($tag);
							$kira_lama = count($model->consultationTagsNotMe);
							if($kira_post > $kira_lama){
								$bil = $kira_post - $kira_lama;
								for($i=1;$i<=$bil;$i++){
									$insert = new ConsultationTag;
									$insert->consult_id = $model->id;
									$insert->save();
								}
							}else if($kira_post < $kira_lama){
	
								$bil = $kira_lama - $kira_post;
								$deleted = ConsultationTag::find()
								  ->where(['consult_id'=>$model->id])
								  ->andwhere(['<>', 'staff_id', Yii::$app->user->identity->staff->id])
								  ->limit($bil)
								  ->all();
								if($deleted){
									foreach($deleted as $del){
										$del->delete();
									}
								}
							}
							
							$update_tag = ConsultationTag::find()
							->where(['consult_id' => $model->id])
							->andWhere(['<>', 'staff_id', Yii::$app->user->identity->staff->id])
							->all();
	
							if($update_tag){
								$i=0;
								foreach($update_tag as $ut){
									$ut->staff_id = $tag[$i];
									$ut->save();
									$i++;
								}
							}
						}
				$action = Yii::$app->request->post('wfaction');
				if($action == 'save'){
					Yii::$app->session->addFlash('success', "Data saved");
					return $this->redirect(['/erpd/consultation/update', 'id' => $model->id]);
				}else if($action == 'next'){
					return $this->redirect(['/erpd/consultation/upload', 'id' => $model->id]);
				}
			}
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Consultation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
			$model->modified_at = new Expression('NOW()');
			if($model->save()){
				
				$tag = Yii::$app->request->post('tagged_staff');
				
						if($tag){
							$kira_post = count($tag);
							$kira_lama = count($model->consultationTagsNotMe);
							if($kira_post > $kira_lama){
								$bil = $kira_post - $kira_lama;
								for($i=1;$i<=$bil;$i++){
									$insert = new ConsultationTag;
									$insert->consult_id = $model->id;
									$insert->save();
								}
							}else if($kira_post < $kira_lama){
	
								$bil = $kira_lama - $kira_post;
								$deleted = ConsultationTag::find()
								  ->where(['consult_id'=>$model->id])
								  ->andwhere(['<>', 'staff_id', Yii::$app->user->identity->staff->id])
								  ->limit($bil)
								  ->all();
								if($deleted){
									foreach($deleted as $del){
										$del->delete();
									}
								}
							}
							
							$update_tag = ConsultationTag::find()
							->where(['consult_id' => $model->id])
							->andWhere(['<>', 'staff_id', Yii::$app->user->identity->staff->id])
							->all();
	
							if($update_tag){
								$i=0;
								foreach($update_tag as $ut){
									$ut->staff_id = $tag[$i];
									$ut->save();
									$i++;
								}
							}
						}
						
				$action = Yii::$app->request->post('wfaction');
				if($action == 'save'){
					Yii::$app->session->addFlash('success', "Data saved");
					return $this->redirect(['/erpd/consultation/update', 'id' => $model->id]);
				}else if($action == 'next'){
					return $this->redirect(['/erpd/consultation/upload', 'id' => $model->id]);
				}
			}
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Consultation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
		if($model->csl_staff == Yii::$app->user->identity->staff->id){
			$file = Yii::getAlias('@upload/' . $model->csl_file);
			if (is_file($file)) {
                unlink($file); 
            }
			if($model->delete()){
				Yii::$app->session->addFlash('success', "The consultation has been successfully deleted");
				return $this->redirect(['index']);
			}
			
		}
    }

    /**
     * Finds the Consultation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Consultation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Consultation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionUpload($id){
		$model = $this->findModel($id);
		if($model->status > 20 ){
			return $this->redirect(['view', 'id' => $id]);
		}
		$model->scenario = 'submit';
		
		if ($model->load(Yii::$app->request->post())) {
			$model->modified_at = new Expression('NOW()');
			if($model->status == 10){
				$model->status = 30;//updated
			}else{
				$model->status = 20;//submit
			}
			
			if($model->save()){
				Yii::$app->session->addFlash('success', "Your consultation has been successfully submitted.");
				return $this->redirect('index');
			}else{
				$model->flashError();
			}
		}
		
		 return $this->render('upload', [
            'model' => $model,
        ]);
	}
	
	public function actionUploadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $model->file_controller = 'consultation';
		
		$year = date('Y') + 0 ;
		$path = $year . '/erpd/consultation';

        return Upload::upload($model, $attr, 'modified_at', $path);

    }

	protected function clean($string){
		$allowed = ['csl'];
		
		foreach($allowed as $a){
			if($string == $a){
				return $a;
			}
		}
		
		throw new NotFoundHttpException('The requested page does not exist.');
    }

	public function actionDeleteFile($attr, $id)
    {
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $attr_db = $attr . '_file';
        
        $file = Yii::getAlias('@upload/' . $model->{$attr_db});
        
        $model->scenario = $attr . '_delete';
        $model->{$attr_db} = '';
        $model->modified_at = new Expression('NOW()');
        if($model->save()){
            if (is_file($file)) {
                unlink($file);
                
            }
            
            return Json::encode([
                        'good' => 1,
                    ]);
        }else{
            return Json::encode([
                        'errors' => $model->getErrors(),
                    ]);
        }
        


    }

	public function actionDownloadFile($attr, $id, $identity = true){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $filename = strtoupper($attr) . ' ' . Yii::$app->user->identity->fullname;
        
        
        
        Upload::download($model, $attr, $filename);
    }
}
