<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\modules\manual\models\Section;
use backend\modules\manual\models\Title;
use backend\modules\manual\models\Module;
use common\models\Upload;


/**
 * Site controller
 */
class UserManualController extends Controller
{

    public $layout = 'main_guide';

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
		]);
    }
    
	
    public function actionTitles($s){
        $section = $this->findSection($s);
        $titles = $section->titles;
        
        return $this->render('titles', [
            'section' => $section,
            'titles' => $titles
        ]);
    }
    
    public function actionModuleSections($m){
        $module = $this->findModule($m);
        $sections = $module->sections;
        
        return $this->render('module-sections', [
            'module' => $module,
            'sections' => $sections
        ]);
    }
    
    public function actionItemSteps($t){
        $title = $this->findTitle($t);
        $items = $title->items;
        
        return $this->render('item-steps', [
            'title' => $title,
            'items' => $items
        ]);
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
    
    protected function findModule($id)
    {
        if (($model = Module::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
    protected function findSection($id)
    {
        if (($model = Section::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findTitle($id)
    {
        if (($model = Title::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	
}
