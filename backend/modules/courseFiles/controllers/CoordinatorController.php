<?php

namespace backend\modules\courseFiles\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\db\Expression;
use yii\web\NotFoundHttpException;
use backend\models\Semester;
use backend\modules\esiap\models\Course;
use backend\modules\teachingLoad\models\CourseOffered;
use common\models\UploadFile;


/**
 * Default controller for the `course-files` module
 */
class CoordinatorController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
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
    
    public function actionCourseCqi($id)
    {
        $model = $this->findOffered($id);
		
		if ($model->load(Yii::$app->request->post())) {
			if(Yii::$app->request->post('na') == 1){
				$model->progressCqi = 1;
				$model->na_cqi = 1;
			}else if($model->course_cqi){
				$model->progressCqi = 1;
				$model->na_cqi = 0;
			}else{
				$model->progressCqi = 0;
				$model->na_cqi = 0;
			}
			
			if($model->save()){
				Yii::$app->session->addFlash('success', "Data Updated");
				return $this->redirect(['default/teaching-assignment-coordinator', 'id' => $id]);
			}

		}

        return $this->render('course-cqi', [
            'model' => $model,
        ]);
    }
	
	protected function findOffered($id)
    {
        if (($model = CourseOffered::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findCourse($id)
    {
        if (($model = Course::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionCurrentCoordinatorPage($course){
	    $session = Yii::$app->session;
	    if($session->get('semester')){
	        $semester = $session->get('semester');
	    }else{
	        $semester = Semester::getCurrentSemester()->id;
	    }
	    
	    
		$offer = CourseOffered::find()
		->where(['semester_id' => $semester, 'course_id' => $course])->one();
		if($offer){
			return $this->redirect(['/course-files/default/teaching-assignment-coordinator', 'id' => $offer->id]);
		}
		
		
		//jadi kena cari offer id 
		
	}
	
	public function actionUploadFile($attr, $id){
	    $attr = $this->clean($attr);
	    $model = $this->findOffered($id);
	    $model->file_controller = 'coordinator';
	    
	    $path = 'course-files/'.$model->semester_id.'/'.$model->course->course_code;
	    
	    return UploadFile::upload($model, $attr, 'updated_at', $path);
	    
	}
	
	protected function clean($string){
	    $allowed = ['coorsign'];
	    if(in_array($string,$allowed)){
	        return $string;
	    }
	    throw new NotFoundHttpException('Invalid Attribute');
	}
	
	public function actionDeleteFile($attr, $id)
	{
	    $attr = $this->clean($attr);
	    $model = $this->findOffered($id);
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
	    $model = $this->findOffered($id);
	    $filename = 'COOR_SIGN_' . $model->course->course_code;
	    
	    
	    
	    UploadFile::download($model, $attr, $filename);
	}
	
	
}
