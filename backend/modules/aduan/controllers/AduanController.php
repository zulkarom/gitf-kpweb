<?php

namespace backend\modules\aduan\controllers;

use Yii;
use backend\modules\aduan\models\Aduan;
use backend\modules\aduan\models\AduanTopic;
use backend\modules\aduan\models\AduanSearch;
use backend\modules\aduan\models\AduanAction;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\db\Expression;
use yii\helpers\FileHelper;

/**
 * AduanController implements the CRUD actions for Aduan model.
 */
class AduanController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all Aduan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AduanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Aduan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        
        $action =  AduanAction::find()->where(['aduan_id' => $id])->all();
        $actionCreate = new AduanAction();
        $aduan = $this->findModel($id);
        
        if ($actionCreate->load(Yii::$app->request->post()) && $aduan->load(Yii::$app->request->post())) {
            $post = $actionCreate->load(Yii::$app->request->post());
            $actionCreate->aduan_id = $id;
            $actionCreate->created_at = new Expression('NOW()'); 
            $actionCreate->created_by = 0;
            $actionCreate->save();
            $aduan->save();
            return $this->refresh();
        }

        return $this->render('view', [
            'model' => $aduan,
            'action' => $action,
            'actionCreate' => $actionCreate,

        ]);
    }

    /**
     * Creates a new Aduan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Aduan();
        $modelAction = new AduanAction();

        if ($model->load(Yii::$app->request->post())) {
            $year = date('Y') + 0 ;
            $time = time();
            $path = $year.'/'.$time.'/';
            $directory = Yii::getAlias('@upload/aduan/'.$path);

            if (!is_dir($directory)) {
                FileHelper::createDirectory($directory);
            }

            $uploadFile = UploadedFile::getInstance($model,'upload_url');

            $model->upload_url = $path.$uploadFile->name; 
            $model->progress_id = 1;
            $model->created_at = new Expression('NOW()'); 

            $uploadFile->saveAs($directory.'/'. $uploadFile->name);

            $model->save(false);

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDownload($id){
        $model = $this->findModel($id);
        
        $file = Yii::getAlias('@upload/aduan/' . $model->upload_url);
        
        
        if($model->upload_url){
            if (file_exists($file)) {
            $ext = pathinfo($model->upload_url, PATHINFO_EXTENSION);

            $filename = 'Aduan.' . $ext ;
            
            self::sendFile($file, $filename, $ext);
            
            
            }else{
                echo 'file not exist!';
            }
        }else{
            echo 'file not exist!';
        }
        
    }

    public static function sendFile($file, $filename, $ext){
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: inline; filename=" . $filename);
        header("Content-Type: " . self::mimeType($ext));
        header("Content-Length: " . filesize($file));
        header("Content-Transfer-Encoding: binary");
        readfile($file);
        exit;
    }

    public static function mimeType($ext){
        switch($ext){
            case 'pdf':
            $mime = 'application/pdf';
            break;
            
            case 'jpg':
            case 'jpeg':
            $mime = 'image/jpeg';
            break;
            
            case 'gif':
            $mime = 'image/gif';
            break;
            
            case 'png':
            $mime = 'image/png';
            break;
            
            default:
            $mime = '';
            break;
        }
        
        return $mime;
    }

    /**
     * Updates an existing Aduan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $oldfile = $model->upload_url;
            if($oldfile != ""){
                unlink(Yii::$app->basePath . '/web/upload/' . $oldfile);
            }

            $uploadFile = UploadedFile::getInstance($model,'upload_url');
            
            $model->upload_url = $uploadFile->name; 

            $model->save(false);

            $uploadFile->saveAs(Yii::$app->basePath . '/web/upload/' . $uploadFile->name);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

  

    /**
     * Deletes an existing Aduan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $oldfile = $model->upload_url;
        unlink(Yii::$app->basePath . '/web/upload/' . $oldfile);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Aduan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Aduan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Aduan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
