<?php

namespace backend\modules\manual\controllers;

use common\models\Upload;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Default controller for the `manual` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
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
    

}
