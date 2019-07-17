<?php

namespace backend\modules\erpd\controllers;

use Yii;
use backend\modules\erpd\models\Publication;
use backend\modules\erpd\models\Author;
use backend\modules\erpd\models\PubTag;
use backend\modules\erpd\models\Editor;
use backend\modules\erpd\models\PublicationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Model;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use common\models\Upload;
use yii\helpers\Json;
use yii\db\Expression;


/**
 * PublicationController implements the CRUD actions for Publication model.
 */
class PublicationController extends Controller
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
     * Lists all Publication models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PublicationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Publication model.
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
     * Creates a new Publication model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Publication();
		
		if ($model->load(Yii::$app->request->post())) {
			
							
			
			$model->staff_id = Yii::$app->user->identity->staff->id;
            
            $authors = Model::createMultiple(Author::classname());
            
            Model::loadMultiple($authors, Yii::$app->request->post());
			
			$editors = Model::createMultiple(Editor::classname());
            
            Model::loadMultiple($editors, Yii::$app->request->post());
            
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($authors) && Model::validateMultiple($editors) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
				
                try {
                    if ($flag = $model->save(false)) {
						
						//tag my self
						
						$tag = new PubTag;
						$tag->pub_id = $model->id;
						$tag->staff_id = Yii::$app->user->identity->staff->id;
						if (!($flag = $tag->save())) {
                                break;
                            }
                      
                        
                        foreach ($authors as $indexAu => $author) {
                            
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $author->pub_id = $model->id;

                            if (!($flag = $author->save(false))) {
                                break;
                            }
                        }
						foreach ($editors as $indexEd => $editor) {
                            
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $editor->pub_id = $model->id;
							if($editor->edit_name){
								if (!($flag = $editor->save(false))) {
									break;
								}
							}

                            
                        }
						
						$tag = Yii::$app->request->post('tagged_staff');
						if($tag){
							$kira_post = count($tag);
							$kira_lama = count($model->pubTagsNotMe);
							if($kira_post > $kira_lama){
								$bil = $kira_post - $kira_lama;
								for($i=1;$i<=$bil;$i++){
									$insert = new PubTag;
									$insert->pub_id = $model->id;
									$insert->save();
								}
							}else if($kira_post < $kira_lama){
	
								$bil = $kira_lama - $kira_post;
								$deleted = PubTag::find()
								  ->where(['pub_id'=>$model->id])
								  ->andwhere(['<>', 'staff_id', Yii::$app->user->identity->staff->id])
								  ->limit($bil)
								  ->all();
								if($deleted){
									foreach($deleted as $del){
										$del->delete();
									}
								}
							}
							
							$update_tag = PubTag::find()
							->where(['pub_id' => $model->id])
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
						
						

                    }else{
						$model->flashError();
					}

                    if ($flag) {
                        $transaction->commit();
                            
							$action = Yii::$app->request->post('wfaction');
							if($action == 'save'){
								Yii::$app->session->addFlash('success', "Data saved");
								return $this->redirect(['/erpd/publication/update', 'id' => $model->id]);
							}else if($action == 'next'){
								return $this->redirect(['/erpd/publication/upload', 'id' => $model->id]);
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
			'authors' => [new Author],
			'editors' => [new Editor]
		
        ]);
    }

    /**
     * Updates an existing Publication model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		if($model->status > 0 ){
			return $this->redirect(['view', 'id' => $id]);
		}
		
		$authors = $model->authors;
		$editors = $model->editors;

        if ($model->load(Yii::$app->request->post())) {
		

			
			$model->staff_id = Yii::$app->user->identity->staff->id;
			
			$oldAuthorIDs = ArrayHelper::map($authors, 'id', 'id');
			
			$oldEditorIDs = ArrayHelper::map($editors, 'id', 'id');
            
            $authors = Model::createMultiple(Author::classname());
			
			$editors = Model::createMultiple(Editor::classname());
            
           Model::loadMultiple($authors, Yii::$app->request->post());
			
			Model::loadMultiple($editors, Yii::$app->request->post());
			
			$deletedAuthorIDs = array_diff($oldAuthorIDs, array_filter(ArrayHelper::map($authors, 'id', 'id')));
			
			$deletedEditorIDs = array_diff($oldEditorIDs, array_filter(ArrayHelper::map($editors, 'id', 'id')));
			

			

            
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($authors) && Model::validateMultiple($editors) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
						
						if (! empty($deletedAuthorIDs)) {
                            Author::deleteAll(['id' => $deletedAuthorIDs]);

						}
						
						if (! empty($deletedEditorIDs)) {
                            Editor::deleteAll(['id' => $deletedEditorIDs]);

						}
                        
                        foreach ($authors as $indexAu => $author) {
                            
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $author->pub_id = $model->id;

                            if (!($flag = $author->save(false))) {
                                break;
                            }
                        }
						foreach ($editors as $indexEd => $editor) {
                            
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $editor->pub_id = $model->id;
							
							if($editor->edit_name){
								if (!($flag = $editor->save(false))) {
									break;
								}
							}

                        }
						//manage tag
						$tag = Yii::$app->request->post('tagged_staff');
						if($tag){
							$kira_post = count($tag);
							$kira_lama = count($model->pubTagsNotMe);
							if($kira_post > $kira_lama){
								$bil = $kira_post - $kira_lama;
								for($i=1;$i<=$bil;$i++){
									$insert = new PubTag;
									$insert->pub_id = $model->id;
									$insert->save();
								}
							}else if($kira_post < $kira_lama){
	
								$bil = $kira_lama - $kira_post;
								$deleted = PubTag::find()
								  ->where(['pub_id'=>$model->id])
								  ->andwhere(['<>', 'staff_id', Yii::$app->user->identity->staff->id])
								  ->limit($bil)
								  ->all();
								if($deleted){
									foreach($deleted as $del){
										$del->delete();
									}
								}
							}
							
							$update_tag = PubTag::find()
							->where(['pub_id' => $model->id])
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
						

                    }else{
						$model->flashError();
					}

                    if ($flag) {
                        $transaction->commit();
                            
							
							$action = Yii::$app->request->post('wfaction');
							if($action == 'save'){
								Yii::$app->session->addFlash('success', "Data saved");
								return $this->redirect(['/erpd/publication/update', 'id' => $model->id]);
							}else if($action == 'next'){
								return $this->redirect(['/erpd/publication/upload', 'id' => $model->id]);
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
			'authors' => (empty($authors)) ? [new Author] : $authors,
			'editors' => (empty($editors)) ? [new Editor] : $editors
        ]);
    }
	
	public function actionUpload($id){
		$model = $this->findModel($id);
		if($model->status > 0 ){
			return $this->redirect(['view', 'id' => $id]);
		}
		$model->scenario = 'submit';
		
		if ($model->load(Yii::$app->request->post())) {
			$model->status = 10;//submit
			if($model->save()){
				Yii::$app->session->addFlash('success', "Your publication has been successfully submitted.");
				return $this->redirect('index');
			}else{
				$model->flashError();
			}
		}
		
		 return $this->render('upload', [
            'model' => $model,
        ]);
	}

    /**
     * Deletes an existing Publication model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
       // $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Publication model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Publication the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Publication::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionUploadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $model->file_controller = 'publication';

        return Upload::upload($model, $attr, 'modified_at');

    }

	protected function clean($string){
		$allowed = ['pubupload'];
		
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
