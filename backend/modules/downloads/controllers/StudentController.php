<?php

namespace backend\modules\downloads\controllers;

use Yii;
use backend\modules\downloads\models\Student;
use backend\modules\downloads\models\StudentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

/**
 * StudentController implements the CRUD actions for Student model.
 */
class StudentController extends Controller
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
     * Lists all Student models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Student model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Student model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Student();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Student model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionSynchronize(){

        if (Yii::$app->request->post()) {
            $csv = array();
        // check there are no errors
        if($_FILES['csv']['error'] == 0){
            $name = $_FILES['csv']['name'];
            
            $arr = explode('.', $name);
            $en = end($arr);

            $ext = strtolower($en);

            $type = $_FILES['csv']['type'];
            $tmpName = $_FILES['csv']['tmp_name'];

            // check the file is a csv
            if($ext === 'csv'){
                if(($handle = fopen($tmpName, 'r')) !== FALSE) {
                    // necessary if a large csv file
                    set_time_limit(0);

                    $row = 0;

                    while(($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                        // number of fields in the csv
                        $col_count = count($data);

                        // get the values from the csv
                        $csv[$row][] = $data[0];
                        $csv[$row][] = $data[1];
                        $csv[$row][] = $data[2];
                        $csv[$row][] = $data[3];
                        $csv[$row][] = $data[4];

                        // inc the row
                        $row++;
                    }
                    fclose($handle);
                }
            }
        }

        if($csv){
            Student::updateAll(['sync' => 0],['is_active' => 1]);
            $new_student = array();
            $active = array();
            $nactive = array();
            foreach(array_slice($csv,1) as $stud){
                $name = $stud[1];
                $matric = $stud[2];
                $nric = $stud[3];
                $program = $stud[4];

                if(!empty($stud)){
                    $st = Student::findOne(['matric_no' => $matric]);
                    if($st === null){
                        $new = new Student;
                        $new->st_name = $name;
                        $new->matric_no = $matric;
                        $new->nric = $nric;
                        $new->program = $program;
						$new->faculty_id = 1;
                        $new->sync = 1;
                        if($new->save())
                        {
                            $new_student[] = 1;
                            
                        }else{
                            print_r($new->getErrors()); 
                        }
                        
                    }
                    else{
                        if($st->is_active == 1){
                            $st->sync = 1; 
                            if($st->save())
                            {
                                
                            }
                            else{
                                print_r($st->getErrors());  
                            }
                        }else{
                            $st->is_active = 1;
                            $st->sync = 1;
                            if($st->save())
                            {
                                $active[] = 1;
                            }
                            else{
                                print_r($st->getErrors());  
                            }
                        }
                    }
                }
            }
            

            $inactive = Student::find()->where(['is_active' => 1,'sync' => 0])->count();

            Student::updateAll(['is_active' => 0],['is_active' => 1,'sync' => 0]);

            
            $new_student = count($new_student);
            $active = count($active);

            if($new_student > 0){
                Yii::$app->session->addFlash('success', "New Student: ".$new_student);
            }

            if($active > 0){
                Yii::$app->session->addFlash('info', "Revert to active:  ".$active);
            }

            if($inactive > 0){
                Yii::$app->session->addFlash('info', "Become Inactive: ".$inactive);
            }

        }
    }
        return $this->render('synchronize', [

        ]);
    }

    /**
     * Deletes an existing Student model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Student model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Student the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
