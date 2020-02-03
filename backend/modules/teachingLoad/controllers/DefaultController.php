<?php

namespace backend\modules\teachingLoad\controllers;

use Yii;
use yii\web\Controller;
use common\models\Model;
use backend\modules\teachingLoad\models\TaughtCourse;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

/**
 * Default controller for the `teaching-load` module
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
	
	public function actionTeachingForm(){
		$user = Yii::$app->user->identity;
		$model = $user->staff;
		
        $taughtCourses = $model->taughtCourses;
       
        if ($model->load(Yii::$app->request->post())) {
            
            $model->updated_at = new Expression('NOW()');    
            
            $oldIDs = ArrayHelper::map($taughtCourses, 'id', 'id');
            
            
            $taughtCourses = Model::createMultiple(TaughtCourse::classname(), $taughtCourses);
            
            Model::loadMultiple($taughtCourses, Yii::$app->request->post());
            
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($taughtCourses, 'id', 'id')));
            
            
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($taughtCourses) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            TaughtCourse::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($taughtCourses as $i => $course) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $course->staff_id = $model->id;

                            if (!($flag = $course->save(false))) {
                                break;
                            }
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
                            Yii::$app->session->addFlash('success', "Information updated");
                            return $this->redirect(['teaching-form']);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }

        
        
       

    }
    

		
		return $this->render('teaching-form', [
			'staff' => $model,
			'user' => $user,
			'taughtCourses' => (empty($taughtCourses)) ? [new TaughtCourse] : $taughtCourses
		]);
	}
}
