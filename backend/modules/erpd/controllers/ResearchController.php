<?php

namespace backend\modules\erpd\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use backend\modules\erpd\models\Research;
use backend\modules\erpd\models\Researcher;
use backend\modules\erpd\models\ResearchSearch;
use backend\modules\erpd\models\ResearchAllSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use common\models\Model;
use common\models\UploadFile as Upload;
use yii\helpers\Json;

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
     * Lists all Research models.
     * @return mixed
     */
    public function actionAll()
    {
        $searchModel = new ResearchAllSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('all', [
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
	
	public function actionViewVerify($id)
    {
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post())) {
			$model->reviewed_at = new Expression('NOW()');
			$model->reviewed_by = Yii::$app->user->identity->id;
			$status = Yii::$app->request->post('wfaction');
			if($status == 'correction'){
				$model->status = 10;
			}else if($status == 'verify'){
				$model->status = 50;
			}
			if($model->save()){
				Yii::$app->session->addFlash('success', "Data Updated");
			}
		}
		
        return $this->render('view-verify', [
            'model' => $model,
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
		$model->scenario = 'res_entry';
		$researchers = $model->researchers;
		
		if ($model->load(Yii::$app->request->post())) {
            
			$model->res_staff = Yii::$app->user->identity->staff->id;
			$model->created_at = new Expression('NOW()');

            $oldResearcherIDs = ArrayHelper::map($researchers, 'id', 'id');
            
            $researchers = Model::createMultiple(Researcher::classname());
            
            Model::loadMultiple($researchers, Yii::$app->request->post());
            
            $valid = $model->validate();
            //print_r($model->getErrors());die();
            $valid = Model::validateMultiple($researchers) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        $me = false;
                        foreach ($researchers as $indexAu => $researcher) {
                            if($researcher->staff_id == Yii::$app->user->identity->staff->id){
								$me = true;
							}
                            if ($flag === false) {
                                break;
                            }
							
                            //do not validate this in model
                            $researcher->res_id = $model->id;

                            if (!($flag = $researcher->save(false))) {
                                break;
                            }else{
								$researcher->flashError();
							}
							
                        }
						
						if($me == false){
							Yii::$app->session->addFlash('error', "You must include yourself as one of the researchers.");
							$flag = false;
						}

                    }else{
						$model->flashError();
						$flag = false;
					}

                    if ($flag) {
                        $transaction->commit();
                            $action = Yii::$app->request->post('wfaction');
							if($action == 'save'){
								Yii::$app->session->addFlash('success', "Data saved");
								return $this->redirect(['/erpd/research/update', 'id' => $model->id]);
							}else if($action == 'next'){
								return $this->redirect(['/erpd/research/upload', 'id' => $model->id]);
							}
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
            'researchers' => (empty($researchers)) ? [new Researcher] : $researchers
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
		$model->scenario = 'res_update';
		$researchers = $model->researchers;
		
		if ($model->load(Yii::$app->request->post())) {
            
			$model->res_staff = Yii::$app->user->identity->staff->id;
			$model->modified_at = new Expression('NOW()');

            $oldResearcherIDs = ArrayHelper::map($researchers, 'id', 'id');
            
            $researchers = Model::createMultiple(Researcher::classname(), $researchers);
            
            Model::loadMultiple($researchers, Yii::$app->request->post());
			
			foreach ($researchers as $i => $researcher) {
                $researcher->res_order = $i;
            }

            
            $deletedResearcherIDs = array_diff($oldResearcherIDs, array_filter(ArrayHelper::map($researchers, 'id', 'id')));
            
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($researchers) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        
                        if (! empty($deletedResearcherIDs)) {
                            Researcher::deleteAll(['id' => $deletedResearcherIDs]);
                        }
                        $me = false;
                        foreach ($researchers as $indexAu => $researcher) {
                            
							if($researcher->staff_id == Yii::$app->user->identity->staff->id){
								$me = true;
							}
                            
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $researcher->res_id = $model->id;

                            if (!($flag = $researcher->save(false))) {
                                break;
                            }
                        }
						
						if($me == false){
							Yii::$app->session->addFlash('error', "You must include yourself as one of the researchers.");
							$flag = false;
						}

                    }

                    if ($flag) {
                        $transaction->commit();
                            $action = Yii::$app->request->post('wfaction');
							if($action == 'save'){
								Yii::$app->session->addFlash('success', "Data saved");
								return $this->redirect(['/erpd/research/update', 'id' => $model->id]);
							}else if($action == 'next'){
								return $this->redirect(['/erpd/research/upload', 'id' => $model->id]);
							}
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
        if (($model = Research::findOne($id)) !== null) {
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
				Yii::$app->session->addFlash('success', "Your research has been successfully submitted.");
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
        $model->file_controller = 'research';
		
		$year = date('Y') + 0 ;
		$path = $year . '/erpd/research';

        return Upload::upload($model, $attr, 'modified_at', $path);

    }

	protected function clean($string){
		$allowed = ['res'];
		
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
