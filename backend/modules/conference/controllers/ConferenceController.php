<?php

namespace backend\modules\conference\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use backend\modules\conference\models\UploadConfFile as UploadFile;
use common\models\Model;
use backend\modules\conference\models\ConfDate;
use backend\modules\conference\models\ConfFee;
use backend\modules\conference\models\ConfFeeInfo;
use backend\modules\conference\models\TentativeDay;
use backend\modules\conference\models\TentativeTime;
use backend\modules\conference\models\Conference;
use backend\modules\conference\models\ConferenceSearch;
use backend\modules\conference\models\EmailSearch;
use backend\modules\conference\models\EmailSet;
use backend\modules\conference\models\EmailTemplate;


/**
 * ConferenceController implements the CRUD actions for Conference model.
 */
class ConferenceController extends Controller
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
     * Lists all Conference models.
     * @return mixed
     */
    public function actionIndex()
    {
		$searchModel = new ConferenceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	/**
     * Creates a new Conference model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Conference();

        if ($model->load(Yii::$app->request->post())) {
			$model->created_at = new Expression('NOW()');
			if($model->save()){
				//insert template email
				$list = EmailSet::find()->all();
				if($list){
					foreach($list as $row){
						$tmpl = new EmailTemplate;
						$tmpl->templ_id = $row->id;
						$tmpl->conf_id = $model->id;
						$tmpl->subject = $row->subject;
						$tmpl->content = $row->content;
						$tmpl->save();
					}
				}
				return $this->redirect(['index']);
			}else{
				$model->flashError();
			}
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Conference model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */



    /**
     * Updates an existing Conference model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($conf)
    {
        $model = $this->findModel($conf);
		
        //not using this due to editor
        /* if ($model->load(Yii::$app->request->post())) {
			$model->page_menu = json_encode(Yii::$app->request->post('page-menu'));
			$model->page_featured = json_encode(Yii::$app->request->post('page-featured'));
			if($model->save()){
				Yii::$app->session->addFlash('success', "Website Content Updated");
				return $this->redirect(['update', 'conf' => $conf]);
			}
			
        } */

        return $this->render('update', [
            'model' => $model,
        ]);
    }
	
    

    /**
     * Finds the Conference model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Conference the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Conference::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	


	public function actionUploadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $model->file_controller = 'conference';

        return UploadFile::upload($model, $attr, 'updated_at');

    }

	protected function clean($string){
        $allowed = ['banner'];
        
        foreach($allowed as $a){
            if($string == $a){
                return $a;
            }
        }
        
        throw new NotFoundHttpException('Invalid Attribute');

    }

	public function actionDeleteFile($attr, $id)
    {
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
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
        $model = $this->findModel($id);
        $filename = strtoupper($attr) . ' ' . Yii::$app->user->identity->fullname;
        
        
        
        UploadFile::download($model, $attr, $filename);
    }


	public function actionDates($conf)
    {
		for($n=1;$n<=8;$n++){
			$kira = ConfDate::find()
			->where(['conf_id' => $conf, 'date_id' => $n])->count();
			if($kira == 0){
				$date = new ConfDate;
				$date->conf_id = $conf;
				$date->date_id = $n;
				$date->date_start = date('Y-m-d');
				$date->published = 1;
				$date->date_order = $n;
				$date->save();
			}
			
		}
		$model = $this->findModel($conf);
		$dates = $model->confDates;
		
		//kena check list
       
        if ($model->load(Yii::$app->request->post())) {
            
            $model->updated_at = new Expression('NOW()');    
            
            $oldIDs = ArrayHelper::map($dates, 'id', 'id');
			
            
            $dates = Model::createMultiple(ConfDate::classname(), $dates);
            
            Model::loadMultiple($dates, Yii::$app->request->post());
			
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($dates, 'id', 'id')));
	
			foreach ($dates as $i => $date) {
                $date->date_order = $i;
            }
			
			
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($dates) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            ConfDate::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($dates as $i => $date) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $date->conf_id = $model->id;

                            if (!($flag = $date->save(false))) {
                                break;
                            }
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
                            Yii::$app->session->addFlash('success', "Dates updated");
							return $this->redirect(['dates','conf' => $conf]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    
                }
            }

        
        
       

    }
	
	 return $this->render('dates', [
            'model' => $model,
            'dates' => (empty($dates)) ? [new ConfDate] : $dates
        ]);
	}
	
	public function actionFees($conf)
    {
		$model = $this->findModel($conf);
		$fees = $model->confFees;
       
        if ($model->load(Yii::$app->request->post())) {
           // print_r(Yii::$app->request->post());die();
            $model->updated_at = new Expression('NOW()');    
            
            $oldIDs = ArrayHelper::map($fees, 'id', 'id');
			
            $fees = Model::createMultiple(ConfFee::classname(), $fees);
			//echo count($fees);die();
			//$dates = Model::createMultiple(ConfDate::classname(), $dates);
            
            Model::loadMultiple($fees, Yii::$app->request->post());
			//echo count($fees);die();
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($fees, 'id', 'id')));
			
		
	
			foreach ($fees as $i => $fee) {
                $fee->fee_order = $i;
            }
			
				//print_r(ArrayHelper::map($fees, 'id', 'id'));die();
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($fees) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            ConfFee::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($fees as $i => $fee) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $fee->conf_id = $model->id;

                            if (!($flag = $fee->save(false))) {
                                break;
                            }
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
                            Yii::$app->session->addFlash('success', "Fees updated");
							return $this->redirect(['fees','conf' => $conf]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    
                }
            }


    }
	 return $this->render('fees', [
            'model' => $model,
            'fees' => (empty($fees)) ? [new ConfFee] : $fees
        ]);
	
	
	
	}
	
	
	public function actionTentative($conf)
    {
		$model = $this->findModel($conf);
	
        $modelsDay = $model->tentativeDays;
        $modelsTime = [];
        $oldTimes = [];

        if (!empty($modelsDay)) {
            foreach ($modelsDay as $indexDay => $modelDay) {
                $times = $modelDay->tentativeTimes;
                $modelsTime[$indexDay] = $times;
                $oldTimes = ArrayHelper::merge(ArrayHelper::index($times, 'id'), $oldTimes);
            }
        }

        if ($model->load(Yii::$app->request->post())) {
			
			//echo '<pre>';
			//print_r(Yii::$app->request->post());die();

            // reset
            $modelsTime = [];

            $oldDayIDs = ArrayHelper::map($modelsDay, 'id', 'id');
            $modelsDay = Model::createMultiple(TentativeDay::classname(), $modelsDay);
            Model::loadMultiple($modelsDay, Yii::$app->request->post());
            $deletedDayIDs = array_diff($oldDayIDs, array_filter(ArrayHelper::map($modelsDay, 'id', 'id')));

            // validate person and days models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsDay) && $valid;

            $timesIDs = [];
			//print_r( $_POST['Time']);die();
            if (isset($_POST['TentativeTime'][0][0])) {
                foreach ($_POST['TentativeTime'] as $indexDay => $times) {
					//echo '<pre>';print_r($times);die();
                    $timesIDs = ArrayHelper::merge($timesIDs, array_filter(ArrayHelper::getColumn($times, 'id')));
					//print_r(ArrayHelper::getColumn($times, 'id'));die();
                    foreach ($times as $indexTime => $time) {
						//echo '<pre>';print_r($time);die();
                        $data['TentativeTime'] = $time;
                        $modelTime = (isset($time['id']) && isset($oldTimes[$time['id']])) ? $oldTimes[$time['id']] : new TentativeTime;
						//echo '<pre>';print_r($modelTime);echo '<br /><br /><br /><br />';
                        $modelTime->load($data);
						//echo '<pre>';print_r($modelTime);die();
                        $modelsTime[$indexDay][$indexTime] = $modelTime;
                        $valid = $modelTime->validate();
                    }
                }
            }

            $oldTimesIDs = ArrayHelper::getColumn($oldTimes, 'id');
            $deletedTimesIDs = array_diff($oldTimesIDs, $timesIDs);

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {

                        if (! empty($deletedTimesIDs)) {
                            TentativeTime::deleteAll(['id' => $deletedTimesIDs]);
                        }

                        if (! empty($deletedDayIDs)) {
                            TentativeDay::deleteAll(['id' => $deletedDayIDs]);
                        }

                        foreach ($modelsDay as $indexDay => $modelDay) {

                            if ($flag === false) {
                                break;
                            }

                            $modelDay->conf_id = $model->id;

                            if (!($flag = $modelDay->save(false))) {
                                break;
                            }

                            if (isset($modelsTime[$indexDay]) && is_array($modelsTime[$indexDay])) {
								
                                foreach ($modelsTime[$indexDay] as $indexTime => $modelTime) {
									//echo '<pre>';print_r($modelTime);die();
                                    $modelTime->day_id = 
									$modelDay->id;
                                    if (!($flag = $modelTime->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
						Yii::$app->session->addFlash('success', "Data Updated");
                        return $this->redirect(['tentative', 'conf' => $conf]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
		
		

        return $this->render('tentative', [
            'model' => $model,
            'days' => (empty($modelsDay)) ? [new TentativeDay] : $modelsDay,
            'times' => (empty($modelsTime)) ? [[new TentativeTime]] : $modelsTime
        ]);
		

    }
	



}
