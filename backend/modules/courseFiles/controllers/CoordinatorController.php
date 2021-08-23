<?php

namespace backend\modules\courseFiles\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\db\Expression;
use yii\web\NotFoundHttpException;
use backend\models\Semester;
use backend\modules\esiap\models\Course;
use backend\modules\teachingLoad\models\CourseOffered;


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
	
	
}
