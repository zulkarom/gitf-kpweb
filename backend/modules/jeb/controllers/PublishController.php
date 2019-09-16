<?php

namespace backend\modules\jeb\controllers;

use Yii;
use backend\modules\jeb\models\Article;
use backend\modules\jeb\models\PublishSearch;
use yii\db\Expression;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use raoul2000\workflow\validation\WorkflowScenario;
use common\models\Model;
use backend\modules\jeb\models\ArticleAuthor;
use common\models\Upload;
use yii\filters\AccessControl;

class PublishController extends \yii\web\Controller
{
	

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

    public function actionIndex()
    {
        $searchModel = new PublishSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionAssign($id)
    {
		$model = $this->findModel($id);
		$model->scenario = WorkflowScenario::enterStatus('qa-publish');
		if ($model->load(Yii::$app->request->post())) {
			
			$model->journal_by = Yii::$app->user->identity->id;
			$model->journal_at = new Expression('NOW()');
			$model->sendToStatus('qa-publish');
			
			if($model->save()){
				
				Yii::$app->session->addFlash('success', "The article has been successfully assigned to journal.");
				return $this->redirect('index');
			}
		}
		return $this->render('assign', [
			'model' => $model,
		]);
    }
	
	public function actionUpdate($id)
    {
		$model = $this->findModel($id);
		
		$authors = $model->articleAuthors;
        
        if ($model->load(Yii::$app->request->post())) {
			
			$oldAuthorIDs = ArrayHelper::map($authors, 'id', 'id');
            
            $authors = Model::createMultiple(ArticleAuthor::classname());
			
            Model::loadMultiple($authors, Yii::$app->request->post());
			
			$deletedAuthorIDs = array_diff($oldAuthorIDs, array_filter(ArrayHelper::map($authors, 'id', 'id')));
            
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($authors) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
						
						if (! empty($deletedAuthorIDs)) {
                            ArticleAuthor::deleteAll(['id' => $deletedAuthorIDs]);
                        }
                        
                        foreach ($authors as $indexAu => $author) {
                            
                            if ($flag === false) {
                                break;
                            }

                            $author->article_id = $model->id;

                            if (!($flag = $author->save(false))) {
                                break;
                            }
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
						Yii::$app->session->addFlash('success', "Update Successful");
                        return $this->redirect(['update', 'id' => $model->id]);
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
			'authors' => (empty($authors)) ? [new ArticleAuthor] : $authors
		]);
    }
	
	/**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionDelete($attr, $id)
	{
		$attr = $this->clean($attr);
        $model = $this->findModel($id);
		$attr_db = $attr . '_file';
		
		$file = Yii::getAlias('@upload/' . $model->{$attr_db});
		
		$model->scenario = $attr . '_delete';
		$model->{$attr_db} = '';
		$model->updated_at = new Expression('NOW()');
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
	
	public function actionUpload($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $model->file_controller = 'publish';

        return Upload::upload($model, $attr, 'updated_at');

    }
	
	protected function clean($string){
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
	}
	
	public function actionDownload($attr, $id, $identity = true){
		$attr = $this->clean($attr);
        $model = $this->findModel($id);
		$filename = strtoupper($attr);
		Upload::download($model, $attr, $filename);
	}
}
