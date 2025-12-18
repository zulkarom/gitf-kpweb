<?php

namespace backend\modules\staff\controllers;

use Yii;
use backend\modules\staff\models\Staff;
use backend\modules\staff\models\StaffSearch;
use backend\modules\staff\models\StaffInactiveSearch;
use backend\modules\staff\models\ExternalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use common\models\Upload;
use common\models\UploadFile;
use yii\helpers\Json;
use yii\db\Expression;
use yii\filters\AccessControl;

/**
 * StaffController implements the CRUD actions for Staff model.
 */
class StaffController extends Controller
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
     * Lists all Staff models.
     * @return mixed
     */
    public function actionIndex()
    {
		$tab = 'staff';
		$searchModel = new StaffSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		$tabCounts = [
			'staff' => (int)Staff::find()->where(['staff_active' => 1, 'faculty_id' => 1])->count(),
			'other' => (int)Staff::find()->where(['staff_active' => 1])->andWhere(['<>', 'faculty_id', 1])->count(),
			'inactive' => (int)Staff::find()->where(['staff_active' => 0])->count(),
		];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tab' => $tab,
            'tabCounts' => $tabCounts,
        ]);
    }
	
	public function actionInactive()
    {
		$tab = 'inactive';
		$searchModel = new StaffInactiveSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		$tabCounts = [
			'staff' => (int)Staff::find()->where(['staff_active' => 1, 'faculty_id' => 1])->count(),
			'other' => (int)Staff::find()->where(['staff_active' => 1])->andWhere(['<>', 'faculty_id', 1])->count(),
			'inactive' => (int)Staff::find()->where(['staff_active' => 0])->count(),
		];

		return $this->render('inactive', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'tab' => $tab,
			'tabCounts' => $tabCounts,
		]);
    }
	
	public function actionExternal()
    {
		$tab = 'other';
		$searchModel = new ExternalSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		$tabCounts = [
			'staff' => (int)Staff::find()->where(['staff_active' => 1, 'faculty_id' => 1])->count(),
			'other' => (int)Staff::find()->where(['staff_active' => 1])->andWhere(['<>', 'faculty_id', 1])->count(),
			'inactive' => (int)Staff::find()->where(['staff_active' => 0])->count(),
		];

		return $this->render('external', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'tab' => $tab,
			'tabCounts' => $tabCounts,
		]);
    }
	
	/* public function actionReset(){
		$staff = Staff::find()->all();
		foreach($staff as $s){
			$user = User::findOne(['email' => $s->staff_email]);
			$s->user_id = $user->id;
			$s->save();
		}
	} */
	
	/* public function actionReload()
    {
        $staff = Staff::find()->all();
		foreach($staff as $s){
			$user_id = $s->user_id;
			if($user_id == 0){
				$user = new User;
				$user->scenario = 'reload';
				if($s->staff_no){
					$user->username = $s->staff_no;
				}else if($s->staff_email){
					$user->username = $s->staff_email;
				}else{
					$user->username = rand(30,30000);
				}
				
				$user->password_hash = $s->user_password_hash;
				$user->email = $s->staff_email;
				$user->fullname = $s->staff_name;
				$user->created_at = time();
				$user->updated_at = time();
				$user->status = 10;
				$user->blocked_at = 0;
				$user->confirmed_at = time();
				$user->last_login_at = $s->user_last_login_timestamp;
				if($user->save()){
					//$st = Staff::findOne($s->staff_id);
					$s->scenario = 'reload';
					$s->user_id = $user->id;
					if(!$s->save()){
						return false;
					}
				}
			}
			
			
		}
    } */

    /**
     * Displays a single Staff model.
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
     * Creates a new Staff model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Staff();
		$user = new User;
		$user->scenario = 'staff_create';
	
        if ($model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {
			
			$transaction = Yii::$app->db->beginTransaction();
			try {
				$random = rand(30,30000);
				$user->password_hash = \Yii::$app->security->generatePasswordHash($random);
				
				$user->status = 10;
				$user->username = $model->staff_no;
				$user->confirmed_at = time();
				$user->created_at = time();
				$user->updated_at = time();
				if($user->save()){
					$model->user_id = $user->id;
					$model->faculty_id = Yii::$app->params['faculty_id'];
					if($model->save()){
						$transaction->commit();
						Yii::$app->session->addFlash('success', "Data Updated");
						return $this->redirect(['update', 'id' => $model->id]);
					}else{
						$model->flashError();
					}
				}else{
					$user->flashError();
					$transaction->rollBack();
				}
				
				
			}
			catch (\Exception $e) 
			{
				$transaction->rollBack();
				Yii::$app->session->addFlash('error', $e->getMessage());
			}
            
        }

        return $this->render('create', [
            'model' => $model,
			'user' => $user
        ]);
    }

    /**
     * Updates an existing Staff model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$user = $model->user;
		$user->scenario = 'update_external';
		
		if($this->storeUpdate($model, $user)){
			return $this->redirect(['index']);
		}
        
        return $this->render('update', [
            'model' => $model,
			'user' => $user
        ]);
    }
	
	public function actionUpdateExternal($id)
    {
        $model = $this->findModel($id);
		$user = $model->user;
		$user->scenario = 'update_external';
		
		if($this->storeUpdate($model, $user)){
			return $this->redirect(['external']);
		}
        
        return $this->render('update', [
            'model' => $model,
			'user' => $user
        ]);
    }
	
	public function actionUpdateInactive($id)
    {
        $model = $this->findModel($id);
		$user = $model->user;
		$user->scenario = 'update_external';
		
		if($this->storeUpdate($model, $user)){
			return $this->redirect(['inactive']);
		}
        
        return $this->render('update', [
            'model' => $model,
			'user' => $user
        ]);
    }
	
	private function storeUpdate($model, $user){
		if ($model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())) {
			$user->username = $model->staff_no;
			if($user->save() && $model->save()){
				Yii::$app->session->addFlash('success', "Data Updated");
				return true;
			}
            
        }
		return false;
	}
	
	public function actionRestore($id){
		$model = $this->findModel($id);
		$model->staff_active = 1;
		if($model->save()){
			return $this->redirect(['index']);
		}
		
	}

    /**
     * Deletes an existing Staff model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionRemove($id)
    {
        $model = $this->findModel($id);
		$model->staff_active = 0;
		if($model->save()){
			Yii::$app->session->addFlash('success', "Staff Removed");
			return $this->redirect(['index']);
		}

        
    }

    /**
     * Finds the Staff model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Staff the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Staff::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	
	public function actionImage(){
		$id = Yii::$app->user->identity->id;
        $model = $this->findModel(['user_id' => $id]);
		
		if($model->image_file){
			$file = Yii::getAlias('@upload/' . $model->image_file);
		}else{
			$file = Yii::getAlias('@img') . '/user.png';
		}
        
		
			if (file_exists($file)) {
			
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			
			$filename = Yii::$app->user->identity->fullname . '.' . $ext ;
			
			Upload::sendFile($file, $filename, $ext);
			
			}else{
				$ext = pathinfo($file, PATHINFO_EXTENSION);
				$filename = Yii::$app->user->identity->fullname . '.' . $ext ;
				$file = Yii::getAlias('@img') . '/user.png';
				Upload::sendFile($file, $filename, $ext);
			}
		
	}
	
	

	public function actionUploadFile($attr, $id){
		

        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $model->file_controller = 'staff';
		

        return UploadFile::upload($model, $attr, 'updated_at', 'profile');

    }

	protected function clean($string){
        $allowed = ['image'];
        
        foreach($allowed as $a){
            if($string == $a){
                return $a;
            }
        }
        
        throw new NotFoundHttpException('Invalid Attribute');

    }

	public function actionDeleteFile($attr, $id)
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

	public function actionDownloadFile($attr, $id, $identity = true){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $filename = strtoupper($attr) . ' ' . Yii::$app->user->identity->fullname;
        
        
        
        UploadFile::download($model, $attr, $filename);
    }
	



}
