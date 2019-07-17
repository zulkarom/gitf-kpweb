<?php

namespace backend\modules\staff\controllers;

use Yii;
use backend\modules\staff\models\Staff;
use backend\modules\staff\models\StaffSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use common\models\Upload;

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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
        $searchModel = new StaffSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->staff_id]);
        }

        return $this->render('create', [
            'model' => $model,
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->staff_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Staff model.
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
		
		if($model->staff_img){
			$file = Yii::getAlias('@upload/profile/' . $model->staff_img);
		}else{
			$file = Yii::getAlias('@img') . '/user.png';
		}
        
		
			if (file_exists($file)) {
			
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			
			$filename = Yii::$app->user->identity->fullname . '.' . $ext ;
			
			Upload::sendFile($file, $filename, $ext);
			
			}
		
	}
}
