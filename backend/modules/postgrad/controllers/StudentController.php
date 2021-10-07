<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use backend\modules\postgrad\models\Student;
use backend\modules\postgrad\models\StudentPostGradSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use common\models\User;
use student\models\StudentData;

/**
 * StudentPostGradController implements the CRUD actions for StudentPostGrad model.
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
     * Lists all StudentPostGrad models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentPostGradSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionImport41rh23dfgpqjh4uy32(){
        $list = StudentData::find()->all();
        foreach($list as $stud){
            //lets create user first 
            //how? 
            //check whether email  exist
            $student = new Student();
            
            $email = $stud->EMEL_PELAJAR;
            $exist = User::findOne(['email' => $email]);
            if($exist){
                $user = $exist;
               
            }else{
                $user = new User();
                $user->username = $stud->NO_MATRIK;
                $random = rand(30,30000);
                $user->password_hash = \Yii::$app->security->generatePasswordHash($random);

                $user->email = $email;
                
            }
            $user->fullname = $stud->NAMA_PELAJAR;
            $user->status = 10;
            if($user->save()){
                //for student data
                $student->user_id = $user->id;
                $student->matric_no = $stud->NO_MATRIK;
                $student->nric = $stud->NO_IC;
                $student->date_birth = date('Y-m-d', strtotime($stud->TARIKH_LAHIR));
                if($stud->TARAF_PERKAHWINAN == 'Berkahwin'){
                    $student->marital_status = 1;
                }else{
                    $student->marital_status = 2;
                }
                
                if($stud->JANTINA == 'LELAKI'){
                    $student->gender = 1;
                }else{
                    $student->gender = 0;
                }
                
                if($stud->NEGARA_ASAL == 'Malaysia'){
                    $student->nationality = 158;
                }else if($stud->NEGARA_ASAL == 'Pakistan'){
                    $student->nationality = 178;
                }else{
                    $student->nationality = 0;
                }
                
                if($stud->KEWARGANEGARAAN == 'Tempatan'){
                    $student->citizenship = 1;
                }else{
                    $student->citizenship = 2;
                }
                
                $student->program_code = $stud->KOD_PROGRAM;
                
                if($stud->TARAF_PENGAJIAN == 'Penuh Masa'){
                    $student->study_mode = 1;
                }else{
                    $student->study_mode = 2;
                }
                
                $student->address = $stud->ALAMAT;
                $student->city = $stud->DAERAH;
                $student->phone_no = $stud->NO_TELEFON;
                $student->personal_email = $stud->EMEL_PERSONAL;
                $student->religion = 1;
                $student->race = 1;
                $student->bachelor_name = $stud->NAMA_SARJANA_MUDA;
                $student->bachelor_university = $stud->UNIVERSITI_SARJANA_MUDA;
                $student->bachelor_cgpa = $stud->CGPA_SARJANA_MUDA;
                $student->bachelor_year = $stud->TAHUN_SARJANA_MUDA;
                
                $sesi = ['201920201' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020', '201920202' => 'SEMESTER FEBRUARI SESI AKADEMIK 2019/2020', '202020211' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021', '202020212' => 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021'];
                foreach($sesi as $key => $val){
                    if($stud->SESI_MASUK == $val){
                        $student->admission_semester = $key;
                    }
                }
                
                $student->admission_year = $stud->TAHUN_KEMASUKAN;
                $student->admission_date = date('Y-m-d', strtotime($stud->TARIKH_KEMASUKAN));
                $student->sponsor = $stud->PEMBIAYAAN;
                $student->current_sem = $stud->SEMESTER;
                $student->campus_id = 2;
                $student->status = 1;
                $student->save();
                
                
                
                
            }
            
            
           
            
            
        }
        
    }

    /**
     * Displays a single StudentPostGrad model.
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
     * Creates a new StudentPostGrad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Student();
        $modelUser = new User();
        $model->scenario = 'create';
        $modelUser->scenario = 'studPost';

        

        if ($model->load(Yii::$app->request->post()) 
            && $modelUser->load(Yii::$app->request->post())) {
            //check email exist  
            $email = $modelUser->email;
                $user = User::find()
                ->where(['or',
                    ['email' => $email],
                    ['username' => $email]
                ])->one();
                if($user){
                    $modelUser = $user;
                }else{
                    $random = rand(30,30000);
                    $modelUser->username = $model->matric_no;
                    $modelUser->password_hash = \Yii::$app->security->generatePasswordHash($random);
                }
                $modelUser->status = 10;
            
            if($modelUser->save()){

                $model->user_id = $modelUser->id;

                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    $model->flashError();
                }
            }else{
                $modelUser->flashError();
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelUser' => $modelUser,
        ]);
    }

    /**
     * Updates an existing StudentPostGrad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelUser = User::findOne($model->user_id);

        if ($model->load(Yii::$app->request->post()) 
            && $modelUser->load(Yii::$app->request->post())) {

            if($modelUser->save()){

                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    $model->flashError();
                }
            }else{
                $modelUser->flashError();
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelUser' => $modelUser,
        ]);
    }

    /**
     * Deletes an existing StudentPostGrad model.
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
     * Finds the StudentPostGrad model based on its primary key value.
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
