<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use backend\modules\postgrad\models\Student;
use backend\modules\postgrad\models\StudentData;
use backend\modules\postgrad\models\StudentPostGradSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use common\models\User;
use backend\modules\postgrad\models\StudentData2;
use backend\modules\postgrad\models\StudentData4;

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

   public function actionPutProgram(){
        $list = Student::find()->all();
        foreach($list as $s){
            if($s->program_code == 'DOK'){
                $s->program_id = 85;
                $s->save();
            }else if($s->program_code == 'SAR'){
                $s->program_id = 84;
                $s->save();
            }
        }
    }
    
    public function actionImport(){
        $list = StudentData::find()->all();
        foreach($list as $stud){
            //lets create user first 
            //how? 
            //check whether email  exist
            $student = new Student();
            
            $username = $stud->NO_MATRIK;
            $exist = User::findOne(['username' => $username]);
            if($exist){
                $user = $exist;
               
            }else{
                $user = new User();
                $user->username = $stud->NO_MATRIK;
                $random = rand(30,30000);
                $user->password_hash = \Yii::$app->security->generatePasswordHash($random);

                $user->email = $stud->EMEL_PELAJAR;
                
            }
            $user->fullname = $stud->NAMA_PELAJAR;
            $user->status = 10;
            if($user->save()){
                //for student data
                $student->user_id = $user->id;
                $student->matric_no = $stud->NO_MATRIK;
                $student->nric = str_replace("-","",$stud->NO_IC);
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
				
				if($student->bachelor_year > 0){
					$student->bachelor_year = $stud->TAHUN_SARJANA_MUDA;
				}else{
					$student->bachelor_year = null;
				}
                
                
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
	
	
	/* public function actionBaikiData(){
        $list = StudentData4::find()->all();
        foreach($list as $stud){
			$matric = $stud->matric;
			$ori = StudentData2::findOne(['NO_MATRIK' => $matric]);
			$ori->TAHUN_KEMASUKAN = $stud->admission_year;
			$ori->TARIKH_KEMASUKAN = $stud->admission_date;
			$ori->PEMBIAYAAN = $stud->sponsor;
			$ori->SEMESTER = $stud->semester;
			if($ori->save()){
				echo 'SUCCESS: ' . $matric . '<br />';
			}else{
				print_r($ori->getErrors());
			}
		}
	}
	
	public function actionImportStudent2(){
        $list = StudentData2::find()->all();
        foreach($list as $stud){
            //lets create user first 
            //how? 
            //check whether email  exist
            
            
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
				$ada = Student::findOne(['matric_no' => $stud->NO_MATRIK]);
				if($ada){
					$student = $ada;
				}else{
					$student = new Student();
					$student->matric_no = $stud->NO_MATRIK;
				}
                $student->user_id = $user->id;
                
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
				
				
				$code = 158;
				switch($stud->NEGARA_ASAL){
					case 'Banglade';
					$code = 19;
					break;
					
					case 'Senegal':
					$code = 205;
					break;
					
					case 'Ghana':
					$code = 82;
					break;
					
					case 'Nigeria':
					$code = 164;
					break;
					
					case 'Indonesi':
					$code = 101;
					break;
					
					case 'Thailand':
					$code = 218;
					break;
					
					case 'Pakistan':
					$code = 178;
					break;
				}
                
                $student->nationality = $code;
                
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
				
				$agama = [1 => 'Islam', 2 => 'Buddh', 3 => 'Krist' , 4 => 'Hindu', 5 => 'Others'];
				$p = false;
				foreach($agama as $key => $val){
                    if(strtolower($stud->AGAMA) == strtolower($val)){
						$p = true;
                        $student->religion = $key;
                    }
                }
				if($p == false){
					$student->religion = 5;
				}
				
				$bangsa = [1 => 'melayu', 2 => 'cina', 3 => 'Indian' , 4 => 'Others'];
				$b = false;
				foreach($agama as $key => $val){
                    if(strtolower($stud->BANGSA) == strtolower($val)){
						$b = true;
                        $student->race = $key;
                    }
                }
				if($b == false){
					$student->race = 4;
				}
				

				
				
                $student->bachelor_name = $stud->NAMA_SARJANA_MUDA;
                $student->bachelor_university = $stud->UNIVERSITI_SARJANA_MUDA;
                if($student->bachelor_cgpa > 0){
					$student->bachelor_cgpa = $stud->CGPA_SARJANA_MUDA;
				} else{
					$student->bachelor_cgpa = null;
				}
				
                if($student->bachelor_year > 0){
					$student->bachelor_year = $stud->TAHUN_SARJANA_MUDA;
				}else{
					$student->bachelor_year = null;
				}
				
				$student->master_name = $stud->NAMA_SARJANA;
                $student->master_university = $stud->UNIVERSITI_SARJANA;
                $student->master_cgpa = $stud->CGPA_SARJANA;
                $student->master_year = $stud->TAHUN_SARJANA;
				
				if($student->master_year > 0){
					$student->master_year = $stud->TAHUN_SARJANA;
				}else{
					$student->master_year = null;
				}
                
                $sesi = [
				'201020112' => 'SEMESTER FEBRUARI SESI AKADEMIK 2010/2011',
				'201220132' => 'SEMESTER FEBRUARI SESI AKADEMIK 2012/2013',
				'201420152' => 'SEMESTER FEBRUARI SESI AKADEMIK 2014/2015',
				'201520162' => 'SEMESTER FEBRUARI SESI AKADEMIK 2015/2016',
				'201620172' => 'SEMESTER FEBRUARI SESI AKADEMIK 2016/2017',
				'201720182' => 'SEMESTER FEBRUARI SESI AKADEMIK 2017/2018',
				'201820192' => 'SEMESTER FEBRUARI SESI AKADEMIK 2018/2019',
				'201920202' => 'SEMESTER FEBRUARI SESI AKADEMIK 2019/2020',
				'202020212' => 'SEMESTER FEBRUARI SESI AKADEMIK 2020/2021',
				'201120121' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2011/2012',
				'201220131' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2012/2013',
				'201320141' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2013/2014',
				'201420151' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2014/2015',
				'201520161' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2015/2016',
				'201620171' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2016/2017',
				'201720181' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2017/2018',
				'201820191' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2018/2019',
				'201920201' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2019/2020',
				'202020211' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2020/2021',
				'202120221' => 'SEMESTER SEPTEMBER SESI AKADEMIK 2021/2022',
				];
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
                if($student->save()){
					$stud->done_import = 1;
					$stud->save();
					echo 'SUCSESS: ' . $stud->NAMA_PELAJAR . '<br />';
				}else{
					echo 'FAILED: ';
					print_r($student->getErrors());
				}
                
                
                
                
            }else{
				echo 'FAILED AT USER: ' . $stud->NO_MATRIK . ' ' . $stud->EMEL_PELAJAR . ' ';
					print_r($user->getErrors());
			}
            
            
           
            
            
        }
        
    } */

    /**
     * Displays a single StudentPostGrad model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $semesters = $model->studentSemesters;
        $supervisors = $model->supervisors;
        $stages = $model->stages;
        
        return $this->render('view', [
            'model' => $model,
            'semesters' => $semesters,
            'supervisors' => $supervisors,
            'stages' => $stages
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
        $model = $this->findModel($id);
        try {
            $model->delete();
            Yii::$app->session->addFlash('success', "Student Deleted");
            return $this->redirect(['index']);
        } catch(\yii\db\IntegrityException $e) {
            Yii::$app->session->addFlash('error', "Cannot delete the student at this stage");
            return $this->redirect(['view', 'id' => $model->id]);
            
        }

        
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
