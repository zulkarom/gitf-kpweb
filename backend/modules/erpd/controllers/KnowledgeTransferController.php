<?php

namespace backend\modules\erpd\controllers;

use Yii;
use backend\modules\erpd\models\KnowledgeTransfer;
use backend\modules\erpd\models\KnowledgeTransferMember;
use backend\modules\erpd\models\KnowledgeTransferSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use common\models\Model;
use common\models\Upload;
use yii\helpers\Json;

/**
 * KnowledgeTransferController implements the CRUD actions for KnowledgeTransfer model.
 */
class KnowledgeTransferController extends Controller
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
     * Lists all KnowledgeTransfer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KnowledgeTransferSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	

    /**
     * Displays a single KnowledgeTransfer model.
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
     * Creates a new KnowledgeTransfer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new KnowledgeTransfer();
		$model->scenario = 'ktp_entry';
		$members = $model->members;

        if ($model->load(Yii::$app->request->post())) {
            
			$model->staff_id = Yii::$app->user->identity->staff->id;
			$model->created_at = new Expression('NOW()');
            
            $members = Model::createMultiple(KnowledgeTransferMember::classname());
            
            Model::loadMultiple($members, Yii::$app->request->post());
            
            $valid = $model->validate();
            //print_r($model->getErrors());die();
            $valid = Model::validateMultiple($members) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        $me = false;
                        foreach ($members as $indexAu => $member) {
							
							if($member->staff_id == Yii::$app->user->identity->staff->id){
								$me = true;
							}
                            
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $member->ktp_id = $model->id;

                            if (!($flag = $member->save(false))) {
                                break;
                            }else{
								$member->flashError();
							}
                        }
						
						if($me == false){
							Yii::$app->session->addFlash('error', "You must include yourself as one of the members.");
							$flag = false;
						}

                    }else{
						$model->flashError();
					}

                    if ($flag) {
                        $transaction->commit();
                            $action = Yii::$app->request->post('wfaction');
							if($action == 'save'){
								Yii::$app->session->addFlash('success', "Data saved");
								return $this->redirect(['/erpd/knowledge-transfer/update', 'id' => $model->id]);
							}else if($action == 'next'){
								return $this->redirect(['/erpd/knowledge-transfer/upload', 'id' => $model->id]);
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
			'members' => (empty($members)) ? [new KnowledgeTransferMember] : $members
        ]);
    }

    /**
     * Updates an existing KnowledgeTransfer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$model->scenario = 'ktp_update';
		$members = $model->members;

        if ($model->load(Yii::$app->request->post())) {
            
            
			$model->staff_id = Yii::$app->user->identity->staff->id;
			$model->modified_at = new Expression('NOW()');

            $oldIDs = ArrayHelper::map($members, 'id', 'id');
            
            $members = Model::createMultiple(KnowledgeTransferMember::classname(), $members);
            
            Model::loadMultiple($members, Yii::$app->request->post());
			
			foreach ($members as $i => $member) {
                $member->ktp_order = $i;
            }

            
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($members, 'id', 'id')));
            
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($members) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        
                        if (! empty($deletedIDs)) {
                            KnowledgeTransferMember::deleteAll(['id' => $deletedIDs]);
                        }
						
                        $me = false;
                        foreach ($members as $indexAu => $member) {
							
							if($member->staff_id == Yii::$app->user->identity->staff->id){
								$me = true;
							}
                            
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $member->ktp_id = $model->id;

                            if (!($flag = $member->save(false))) {
                                break;
                            }
                        }
						
						if($me == false){
							Yii::$app->session->addFlash('error', "You must include yourself as one of the members.");
							$flag = false;
						}

                    }

                    if ($flag) {
                        $transaction->commit();
                            $action = Yii::$app->request->post('wfaction');
							if($action == 'save'){
								Yii::$app->session->addFlash('success', "Data saved");
								return $this->redirect(['/erpd/knowledge-transfer/update', 'id' => $model->id]);
							}else if($action == 'next'){
								return $this->redirect(['/erpd/knowledge-transfer/upload', 'id' => $model->id]);
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
			'members' => (empty($members)) ? [new KnowledgeTransferMember] : $members
        ]);
    }

    /**
     * Deletes an existing KnowledgeTransfer model.
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
     * Finds the KnowledgeTransfer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return KnowledgeTransfer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = KnowledgeTransfer::findOne($id)) !== null) {
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
				Yii::$app->session->addFlash('success', "Your knowledge transfer program has been successfully submitted.");
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
        $model->file_controller = 'knowledge-transfer';

        return Upload::upload($model, $attr, 'modified_at');

    }

	protected function clean($string){
		$allowed = ['ktp'];
		
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
