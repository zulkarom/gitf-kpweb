<?php

namespace backend\modules\teachingLoad\controllers;

use Yii;
use yii\web\Controller;
use common\models\Model;
use common\models\UploadFile;
use backend\modules\teachingLoad\models\TaughtCourse;
use backend\modules\teachingLoad\models\TeachCourse;
use backend\modules\teachingLoad\models\Setting;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\filters\AccessControl;
use backend\modules\teachingLoad\models\AppointmentLetter;
use backend\modules\teachingLoad\models\AppointmentLetterFile;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `teaching-load` module
 */
class DefaultController extends Controller
{
	    
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
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
		$teaching_load = false;
		if(Yii::$app->user->can('teaching-load-manager') or Yii::$app->user->can('teaching-load-program-coor')){
			$teaching_load = true;
		}
		if(Yii::$app->user->can('teaching-load-manager')){
			return $this->redirect(['/teaching-load/course-offered']);
		}
		if(Yii::$app->user->can('teaching-load-program-coor')){
			return $this->redirect(['/teaching-load/course-offered/program-coor']);
		}
        return $this->render('index');
    }
	
	public function actionTeachingView(){
		$user = Yii::$app->user->identity;
		$model = $user->staffTeaching;
		$setting = Setting::findOne(1);
		
		

		if(!$setting->formAccess){
			Yii::$app->session->addFlash('info', "The teaching information form has been closed.");
		}
		
		if($model->teaching_submit == 0 and $setting->formAccess){
			return $this->redirect('teaching-form');
		}
		
		return $this->render('teaching-view', [
			'model' => $model,
			'user' => $user,
			'setting' => $setting
		]);
	}

	
	
	public function actionTeachingForm(){
		
		$setting = Setting::findOne(1);
		if(!$setting->formAccess){
			return $this->redirect(['teaching-view']);
		}
		
		$user = Yii::$app->user->identity;
		$model = $user->staff;
		$model->scenario = 'teaching';
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
		
		
		
		
        if ($model->load(Yii::$app->request->post())) {
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
                            Yii::$app->session->addFlash('success', "Teaching Information has been submitted");
                            return $this->redirect(['teaching-view']);
                    } else {
						Yii::$app->session->addFlash('error', "flag false");
                        $transaction->rollBack();
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    
                }
            }

        
        
       

    }
    

		
		return $this->render('teaching-form', [
			'staff' => $model,
			'user' => $user,
			'taughtCourses' => (empty($taughtCourses)) ? [new TaughtCourse] : $taughtCourses,
			'teachCourses' => (empty($teachCourses)) ? [new TeachCourse] : $teachCourses,
			'setting' => $setting
		]);
	}
	
	public function actionAppointmentLetter($id){
        $model = $this->findModel($id);
        $model->setProgressAppointment();
        $model->save();
        $pdf = new AppointmentLetterFile;
        $pdf->model = $model;
        $pdf->generatePdf();
        exit;
    }
    
    public function actionAppointmentLetterManual($id){
        $model = $this->findModel($id);
        $filename = 'appointment-letter';
        UploadFile::download($model, 'manual', $filename);
    }
    
    

    protected function findModel($id)
    {
        if (($model = AppointmentLetter::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}