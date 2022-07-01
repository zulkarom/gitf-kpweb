<?php

namespace backend\modules\sae\controllers;

use Yii;
use backend\modules\sae\models\Candidate;
use backend\modules\sae\models\GradeCategory;
use backend\modules\sae\models\Question;
use backend\modules\sae\models\ResultSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\sae\models\pdf\pdf_individual;
use backend\modules\sae\models\pdf\pdf_result;
use backend\modules\sae\models\AnalysisDomain;
use backend\modules\sae\models\AnalysisDemographic;
use backend\modules\sae\models\AnalysisForm;
use backend\modules\sae\models\Domain;
use backend\modules\sae\models\Demographic;
use backend\modules\sae\models\Batch;
use backend\modules\sae\models\Answer;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
/**
 * ResultController implements the CRUD actions for Candidate model.
 */
class ResultController extends Controller
{
    /**
     * @inheritDoc
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
     * Lists all Candidate models.
     * @return mixed
     */
    public function actionIndex($bat_id)
    {
        $domains = Domain::find()->where(['bat_id' => $bat_id])->all();
        $demos = Demographic::find()->select('DISTINCT(column_id)')->where(['bat_id' => $bat_id])->all();
        $batch = Batch::findOne($bat_id);
        $searchModel = new ResultSearch();
        $searchModel->bat_id = $bat_id;
        $searchModel->limit = $batch->result_limit;
        $searchModel->point_min = $batch->point_min;
        $searchModel->point_min_total = $batch->point_min_total;
        $dataProvider = $searchModel->search();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'domains' => $domains,
            'demos' => $demos,
            'batch' => $batch,
        ]);
    }

    public function actionAnalysis($id, $reset = false, $redirect = false)
    {
		//print_r(Yii::$app->request->post());die();
		$batch = $this->findBatch($id);
		$analysis = new AnalysisForm($batch, $reset);
		if($redirect){
			return $this->redirect(['index', 'bat_id' => $id]);
		}

        if ($analysis->load(Yii::$app->request->post())) {
			if($analysis->saveAnalysis()){
				return $this->redirect(['index', 'bat_id' => $id]);
			}
        }

        return $this->render('analysis', [
			'analysis' => $analysis,
			'batch' => $batch
        ]);
    }

    

    /**
     * Displays a single Candidate model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionIndividualPdf($id){

        $model = $this->findModel($id);
        $pdf = new pdf_individual;
        $pdf->gcat = GradeCategory::allDomains();
        $pdf->user = $model;
        $pdf->generatePdf();
    }

    public function actionIndividualResult($id,$batch_id){

        $model = $this->findModel($id);
        $gcat = GradeCategory::allDomains();
        $answer = Answer::find()->where(['can_id' => $id, 'bat_id' =>$batch_id])->one();
        $batch = $this->findBatch($batch_id);

        return $this->render('individualresult', [
            'user' => $model,
            'gcat' => $gcat,
            'answer' => $answer,
			'batch' => $batch
        ]);
    }

    public function actionResultPdf($id){

        $pdf = new pdf_result;
        $pdf->gcat = GradeCategory::allDomains();
        $pdf->users = Candidate::find()
                    ->alias('a')
                    ->select($this->columResultAnswers())
                    ->joinWith(['batch b', 'answer c'])
                    ->where(['!=' ,'a.id', 1])
                    ->all();

        $pdf->generatePdf();
        exit();
    }

    private function columResultAnswers(){
        $result = GradeCategory::allDomains();
        $colum = ["a.id", "a.username", "a.can_name", "a.department", "a.can_zone", "a.can_batch",  "b.bat_text" ,
        "a.answer_status", "a.overall_status", "a.finished_at"];
        $c=1;
        
        foreach($result as $row){
        if($c==1){$comma="";}else{$comma=", ";}
            $str = "";
            $quest = Question::find()->where(['grade_cat' => $row->id])->all();
            $i=1;
            $jumq = count($quest);
            // echo $jumq;die();
            foreach($quest as $rq){
                if($i == $jumq){$plus = "";}else{$plus=" + ";}
                $str .= "IF(q".$rq->que_id ." > 0,1,0) ". $plus ;
            $i++;
            }
            $str .= " as c". $row->id;
        $c++;  
        $colum[] = $str; 
        }
        return $colum;
    }

    public function actionUploadResult($id){

        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->renderAjax('upload-result', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Candidate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Candidate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Candidate::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function findBatch($id)
    {
        if (($model = Batch::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
