<?php

namespace backend\modules\manual\controllers;

use Yii;
use backend\modules\manual\models\Item;
use backend\modules\manual\models\Step;
use backend\modules\manual\models\StepSearch;
use common\models\Upload;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * StepController implements the CRUD actions for Step model.
 */
class StepController extends Controller
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
     * Lists all Step models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StepSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Step model.
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
     * Creates a new Step model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($item)
    {
        $model = new Step();
        $item = $this->findItem($item);
        $model->item_id = $item->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['item/view', 'id' => $item->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'item' => $item
        ]);
    }

    /**
     * Updates an existing Step model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['item/view', 'id' => $model->item_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Step model.
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
     * Finds the Step model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Step the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Step::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findItem($id)
    {
        if (($model = Item::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionUploadImage(){
        $accepted_origins = array("http://localhost", "https://fkp-portal.umk.edu.my");
        
        /*********************************************
         * Change this line to set the upload folder *
         *********************************************/
        
        
        
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            // same-origin requests won't set an origin. If the origin is set, it must be valid.
            if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
                header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
            } else {
                header("HTTP/1.1 403 Origin Denied");
                return;
            }
        }
        
        // Don't attempt to process the upload on an OPTIONS request
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            header("Access-Control-Allow-Methods: POST, OPTIONS");
            return;
        }
        
        reset ($_FILES);
        $temp = current($_FILES);
        if (is_uploaded_file($temp['tmp_name'])){
            /*
             If your script needs to receive cookies, set images_upload_credentials : true in
             the configuration and enable the following two headers.
             */
            // header('Access-Control-Allow-Credentials: true');
            // header('P3P: CP="There is no P3P policy."');
            
            // Sanitize input
            if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
                header("HTTP/1.1 400 Invalid file name.");
                return;
            }
            
            // Verify extension
            
            $extension = strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION));
            $new_file_name = uniqid(time(), true) . '.' . $extension;
            if (!in_array($extension, array("gif", "jpg", "png", "jpeg"))) {
                header("HTTP/1.1 400 Invalid extension.");
                return;
            }
            
            $imageFolder = Yii::getAlias('@upload/manual/');
            
            // Accept upload if there was no origin, or if it is an accepted origin
            $filetowrite = $imageFolder . $new_file_name;
            move_uploaded_file($temp['tmp_name'], $filetowrite);
            
            // Determine the base URL
            // $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? "https://" : "http://";
            //$baseurl = $protocol . $_SERVER["HTTP_HOST"] . rtrim(dirname($_SERVER['REQUEST_URI']), "/") . "/";
            
            // Respond to the successful upload with JSON.
            // Use a location key to specify the path to the saved image resource.
            // { location : '/your/uploaded/image/file'}
            $url = Url::to(['/manual/step/show-image', 'file' => $new_file_name]);
            // $filetowrite = 'egayong/mahaguru/' . $new_file_name;
            echo json_encode(array('location' => $url));
            //echo json_encode(array('location' => $baseurl . $filetowrite));
        } else {
            // Notify editor that the upload failed
            header("HTTP/1.1 500 Server Error");
        }
        
        exit;
    }
    
    public function actionShowImage($file){
        
        $file_path = Yii::getAlias('@upload/manual/'.$file);
        
        if (file_exists($file_path)) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            
            Upload::sendFile($file_path, $file, $ext);
            
            
        }else{
            echo 'file not exist';
        }
        
    }
    
    public function beforeAction($action)
    {
        if ($action->id == 'upload-image') {
            $this->enableCsrfValidation = false;
        }
        
        return parent::beforeAction($action);
    }
    

}