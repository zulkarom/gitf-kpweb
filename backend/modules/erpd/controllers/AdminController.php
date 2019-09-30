<?php

namespace backend\modules\erpd\controllers;

use Yii;
use yii\db\Expression;
use backend\modules\erpd\models\Research;
use backend\modules\erpd\models\ResearchAllSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use backend\modules\erpd\models\Publication;
use backend\modules\erpd\models\PublicationAllSearch;
use backend\modules\erpd\models\Membership;
use backend\modules\erpd\models\MembershipAllSearch;
use backend\modules\erpd\models\Award;
use backend\modules\erpd\models\AwardAllSearch;
use backend\modules\erpd\models\ConsultationAllSearch;
use backend\modules\erpd\models\Consultation;
use backend\modules\erpd\models\KnowledgeTransferAllSearch;
use backend\modules\erpd\models\KnowledgeTransfer;

/**
 * ResearchController implements the CRUD actions for Research model.
 */
class AdminController extends Controller
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
		return $this->render('index', [

        ]);
    }
	
	/**
     * Lists all Research models.
     * @return mixed
     */
    public function actionResearch()
    {
        $searchModel = new ResearchAllSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('research', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

	public function actionViewResearch($id)
    {
		$model = $this->findResearch($id);
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
		
        return $this->render('view-research', [
            'model' => $model,
        ]);
    }
	
    /**
     * Finds the Research model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Research the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findResearch($id)
    {
        if (($model = Research::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionPublication()
    {
        $searchModel = new PublicationAllSearch();
        
		$r = Yii::$app->request->queryParams;
		if(!array_key_exists('PublicationAllSearch', $r)){
			$searchModel->pub_year = date('Y');
		}
		
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
        return $this->render('publication', [
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
    public function actionViewPublication($id)
    {
		$model = $this->findPublication($id);
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
		
        return $this->render('view-publication', [
            'model' => $model,
        ]);
    }
	
	/**
     * Finds the Publication model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Publication the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findPublication($id)
    {
        if (($model = Publication::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	 public function actionMembership()
    {
        $searchModel = new MembershipAllSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('membership', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionViewMembership($id)
    {
		$model = $this->findMembership($id);
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
		
        return $this->render('view-membership', [
            'model' => $model,
        ]);
    }
	
	/**
     * Finds the Membership model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Membership the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findMembership($id)
    {
        if (($model = Membership::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionAward()
    {
        $searchModel = new AwardAllSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('award', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionViewAward($id)
    {
		$model = $this->findAward($id);
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
		
        return $this->render('view-award', [
            'model' => $model,
        ]);
    }
	
	/**
     * Finds the Award model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Award the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findAward($id)
    {
        if (($model = Award::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionConsultation()
    {
        $searchModel = new ConsultationAllSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('consultation', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionViewConsultation($id)
    {
		$model = $this->findConsultation($id);
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
		
        return $this->render('view-consultation', [
            'model' => $model,
        ]);
    }
	
	/**
     * Finds the Consultation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Consultation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findConsultation($id)
    {
        if (($model = Consultation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionKnowledgeTransfer()
    {
        $searchModel = new KnowledgeTransferAllSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('knowledge-transfer', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionViewKnowledgeTransfer($id)
    {
		$model = $this->findKnowledgeTransfer($id);
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
		
        return $this->render('view-knowledge-transfer', [
            'model' => $model,
        ]);
    }
	
	/**
     * Finds the KnowledgeTransfer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return KnowledgeTransfer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findKnowledgeTransfer($id)
    {
        if (($model = KnowledgeTransfer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
