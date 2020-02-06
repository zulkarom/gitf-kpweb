<?php

namespace backend\modules\teachingLoad\controllers;

use Yii;
use yii\web\Controller;
use common\models\Model;
use backend\modules\teachingLoad\models\TaughtCourse;
use backend\modules\teachingLoad\models\TeachCourse;
use backend\modules\teachingLoad\models\OutCourse;
use backend\modules\teachingLoad\models\PastExperience;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\filters\AccessControl;
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
        return $this->render('index');
    }
	
	public function actionTeachingForm(){
		$user = Yii::$app->user->identity;
		$model = $user->staff;
		$model->scenario = 'teaching';
        $taughtCourses = $model->taughtCourses;
		$outCourses = $model->otherTaughtCourses;
		$pastExpes = $model->pastExperiences;
		
		
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
            
            $oldIDs = ArrayHelper::map($taughtCourses, 'id', 'id');
			$teach_oldIDs = ArrayHelper::map($teachCourses, 'id', 'id');
			$out_oldIDs = ArrayHelper::map($outCourses, 'id', 'id');
            $past_oldIDs = ArrayHelper::map($pastExpes, 'id', 'id');
            
            $taughtCourses = Model::createMultiple(TaughtCourse::classname(), $taughtCourses);
			$teachCourses = Model::createMultiple(TeachCourse::classname(), $teachCourses);
			$outCourses = Model::createMultiple(OutCourse::classname(), $outCourses);
			$pastExpes = Model::createMultiple(PastExperience::classname(), $pastExpes);
            
            Model::loadMultiple($taughtCourses, Yii::$app->request->post());
			Model::loadMultiple($teachCourses, Yii::$app->request->post());
			Model::loadMultiple($outCourses, Yii::$app->request->post());
			Model::loadMultiple($pastExpes, Yii::$app->request->post());		
            
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($taughtCourses, 'id', 'id')));
			$teach_deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($teachCourses, 'id', 'id')));
			$out_deletedIDs = array_diff($out_oldIDs, array_filter(ArrayHelper::map($outCourses, 'id', 'id')));
			$past_deletedIDs = array_diff($past_oldIDs, array_filter(ArrayHelper::map($pastExpes, 'id', 'id')));
            
            
            $valid = $model->validate();
            $valid = Model::validateMultiple($taughtCourses) && $valid;
			
			$valid = Model::validateMultiple($teachCourses) && $valid;
			$valid = Model::validateMultiple($outCourses) && $valid;
			$valid = Model::validateMultiple($pastExpes) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
					
                    if ($flag = $model->save(false)) {
						
                        if (! empty($deletedIDs)) {
                            TaughtCourse::deleteAll(['id' => $deletedIDs]);
                        }
						if (! empty($out_deletedIDs)) {
                            OutCourse::deleteAll(['id' => $out_deletedIDs]);
                        }
						if (! empty($past_deletedIDs)) {
                            PastExperience::deleteAll(['id' => $past_deletedIDs]);
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
						
						foreach ($outCourses as $i => $out_course) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $out_course->staff_id = $model->id;

                            if (!($flag = $out_course->save(false))) {
								Yii::$app->session->addFlash('error', "out course error");
                                break;
                            }
                        }
						
						foreach ($pastExpes as $i => $pastExpe) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $pastExpe->staff_id = $model->id;

                            if (!($flag = $pastExpe->save(false))) {
								Yii::$app->session->addFlash('error', "past expe error");
                                break;
                            }
                        }

                    }else{
						Yii::$app->session->addFlash('error', "model error");
						$model->flashError();
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
			'taughtCourses' => (empty($taughtCourses)) ? [new TaughtCourse] : $taughtCourses,
			'teachCourses' => (empty($teachCourses)) ? [new TeachCourse] : $teachCourses,
			'outCourses' => (empty($outCourses)) ? [new OutCourse] : $outCourses,
			'pastExpes' => (empty($pastExpes)) ? [new PastExperience] : $pastExpes,
		]);
	}
}
