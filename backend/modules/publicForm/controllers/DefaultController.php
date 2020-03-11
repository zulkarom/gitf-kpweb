<?php

namespace backend\modules\publicForm\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\publicForm\models\TeachForm;
use backend\modules\teachingLoad\models\TaughtCourse;
use backend\modules\teachingLoad\models\TeachCourse;
use backend\modules\staff\models\Staff;
use backend\modules\teachingLoad\models\Setting;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use common\models\Model;

/**
 * Default controller for the `publicForm` module
 */
class DefaultController extends Controller
{
	public $layout = 'main-public';
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

    }
	
	public function actionToughtCourses()
    {
		$setting = Setting::findOne(1);
		if(!$setting->formAccess){
			Yii::$app->session->addFlash('info', "The form has already been closed");
			//return $this->render('error');
		}
		
		$staff = new TeachForm;
		
		if ($staff->load(Yii::$app->request->post())) {
			
			$model = $this->findStaff($staff->staffno);
			
			if($model){
				return $this->redirect(['staff-tought-courses', 's' => $staff->staffno]);
			}else{
				Yii::$app->session->addFlash('info', "Sorry, data not found, please contact the administrator.");
			}
			
		}
		
        return $this->render('form', [
			'staff' => $staff,
			'setting' => $setting
		]);
    }
	
	
	public function actionStaffToughtCourses($s){
		$setting = Setting::findOne(1);
		if(!$setting->formAccess){
			return $this->redirect(['tought-courses']);
		}
		
		$model = $this->findStaff($s);
		
		if ($model->load(Yii::$app->request->post())) {
			return $this->processTeachingData($model);
		}else{
			if($model->teaching_submit == 1){
				Yii::$app->session->addFlash('info', "The form has already been submitted. You may view or change (before due date) the data by logging in to fkp-portal.umk.edu.my");
				return $this->redirect(['tought-courses']);
			}else{
				$taughtCourses = $model->taughtCourses;
				$teachCourses = $model->teachCourses;
				$kira = count($teachCourses);
				if($kira < 4){
					$brp = 4 - $kira;
					for($s=1;$s<=$brp;$s++){
						$kur = new TeachCourse;
						$kur->course_id = 0;
						$kur->staff_id = $model->id;
						$kur->save();
					}
				}
				unset($model->teachCourses);
				$teachCourses = $model->teachCourses;
				$r = 1;
				foreach($teachCourses as $t){
					$t->rank = $r;
					$t->save();
					$r++;
				}
				return $this->render('form2', [
					'model' => $model,
					
					'taughtCourses' => (empty($taughtCourses)) ? [new TaughtCourse] : $taughtCourses,
					'teachCourses' => (empty($teachCourses)) ? [new TeachCourse] : $teachCourses,
					'setting' => $setting
				]);
			}
		}
		
		
		
	}
	
	protected function processTeachingData($model){
			$taughtCourses = $model->taughtCourses;
			$teachCourses = $model->teachCourses;
				
            $model->updated_at = new Expression('NOW()');    
            $model->teaching_submit_at = new Expression('NOW()');
			$model->teaching_submit = 1;
			
            $oldIDs = ArrayHelper::map($taughtCourses, 'id', 'id');
			$teach_oldIDs = ArrayHelper::map($teachCourses, 'id', 'id');
			
            
            $taughtCourses = Model::createMultiple(TaughtCourse::classname(), $taughtCourses);
			$teachCourses = Model::createMultiple(TeachCourse::classname(), $teachCourses);
			
            
            Model::loadMultiple($taughtCourses, Yii::$app->request->post());
			Model::loadMultiple($teachCourses, Yii::$app->request->post());
			
            
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($taughtCourses, 'id', 'id')));
			$teach_deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($teachCourses, 'id', 'id')));
			
            
            
            $valid = $model->validate();
            $valid = Model::validateMultiple($taughtCourses) && $valid;
			
			$valid = Model::validateMultiple($teachCourses) && $valid;

            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
					
                    if ($flag = $model->save(false)) {
						
                        if (! empty($deletedIDs)) {
                            TaughtCourse::deleteAll(['id' => $deletedIDs]);
                        }
						
						if (! empty($teach_deletedIDs)) {
                            TeachCourse::deleteAll(['id' => $teach_deletedIDs]);
                        }
                        foreach ($taughtCourses as $i => $course) {
                            if ($flag === false) {
								
                                break;
                            }
                            //do not validate this in model
                            $course->staff_id = $model->id;

                            if (!($flag = $course->save(false))) {
								Yii::$app->session->addFlash('error', "taught course error");
                                break;
                            }
                        }
						
						foreach ($teachCourses as $i => $teach) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $teach->staff_id = $model->id;

                            if (!($flag = $teach->save(false))) {
								Yii::$app->session->addFlash('error', "teach course error");
                                break;
                            }
                        }
						

                    }else{
						Yii::$app->session->addFlash('error', "model error");
						$model->flashError();
					}

                    if ($flag) {
                        $transaction->commit();
                            Yii::$app->session->addFlash('info', "Thank your, your teaching Information has been submitted. To view or change (before due date), you may log in to fkp-portal.umk.edu.my");
                            return $this->redirect(['tought-courses']);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }

        
	}

	
	protected function findStaff($no){
		return Staff::findOne(['staff_no' => $no, 'is_academic' => 1]);
	}
}
