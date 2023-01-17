<?php

namespace backend\modules\postgrad\controllers;

use backend\models\Semester;
use backend\models\SemesterForm;
use backend\modules\courseFiles\models\StudentLecture;
use backend\modules\postgrad\models\CourseworkSearch;
use backend\modules\postgrad\models\Student;
use backend\modules\teachingLoad\models\CourseOffered;
use common\models\Common;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\modules\postgrad\models\Report;
use backend\modules\postgrad\models\MarkReport;

/**
 * Default controller for the `postgrad` module
 */
class CourseworkController extends Controller
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
		$semester = new SemesterForm();
		$session = Yii::$app->session;
        if(Yii::$app->getRequest()->getQueryParam('SemesterForm')){
            $sem = Yii::$app->getRequest()->getQueryParam('SemesterForm');
            $semester->semester_id = $sem['semester_id'];
            $semester->program_id = $sem['program_id'];
			$session->set('semester', $sem['semester_id']);
        }else if($session->has('semester')){
			$semester->semester_id = $session->get('semester');
		}else{
            $semester->semester_id = Semester::getCurrentSemester()->id;
        }
	

        $searchModel = new CourseworkSearch();
        $searchModel->semester = $semester->semester_id;
        $searchModel->program_id = $semester->program_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'semester' => $semester
        ]);
    }

    public function actionViewCourse($id){
        $offer = $this->findOffered($id);
        //senarai pelajar by course offered
        $students = StudentLecture::find()->alias('a')
        ->joinWith(['courseLecture cl'])
        ->where(['cl.offered_id' => $id])
        //->innerJoin('tld_course_lec cl', 'cl.id = a.lecture_id')
        ->all();
        return $this->render('view-course', [
            'offer' => $offer,
            'students' => $students
        ]);
    }

    public function actionBar($data, $tofile = false){
        Report::barChart($data, $tofile);
        exit;
    }


    protected function findOffered($id)
    {
        if (($model = CourseOffered::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPull($s){
        //senarai course offer program 81,82
        $query = CourseOffered::find()->alias('a')
        ->select('a.*, c.program_id ')
        ->joinWith('course c')
        ->where(['c.program_id' => Common::arrayPgCoursework(), 'semester_id' => $s])
        ->all();
        if($query){
            foreach($query as $q){
                $program = $q->program_id;
                /* echo $q->course->course_name;
                echo '<br />'; */
                //setiap course tgk student dlm lecture
                //get lecture list

                $lec = $q->courseLectures;
                if($lec){
                    foreach($lec as $l){
                       /* echo  $l->lec_name;
                       echo '<br />'; */
                       //setiap student tu tarik masuk pg
                        $s = $l->students;
                        if($s){
                            foreach($s as $t){
                                if(strlen($t->matric_no) > 4){
                                    /*  echo $t->matric_no;
                                    echo ' name ' . $t->student->st_name;
                                    echo ' program_id ' . $program;
                                    echo '<br />';  */
                                   $this->processAddingStudentLecturePg($program, $t->matric_no, $t->student->st_name);
                                }
                                
                            }
                        }
                    }
                }


            }
        }
        
       exit; 
    }

    public function actionMarkPdf($id){

        $pdf = new MarkReport;
        
		
        $offer = $this->findOffered($id);
        //senarai pelajar by course offered
        $students = StudentLecture::find()->alias('a')
        ->joinWith(['courseLecture cl'])
        ->where(['cl.offered_id' => $id])
        //->innerJoin('tld_course_lec cl', 'cl.id = a.lecture_id')
        ->all();

        $pdf->offer = $offer;
        $pdf->students = $students;
		
		$pdf->generatePdf();
    }

    private function processAddingStudentLecturePg($pg, $matric, $name){
        $st = Student::find()->where(['matric_no' => $matric])->one();
        if(!$st){
            $exist = User::findOne(['username' => $matric]);
            if($exist){
                $user = $exist;
            }else{
                $user = new User();
                $user->username = $matric;
                $user->fullname = $name;
                $random = rand(30,30000);
                $user->password_hash = \Yii::$app->security->generatePasswordHash($random);
                $user->status = 10;
                $user->email = 'dummy.'. strtolower($matric).'@email.com';
                if($user->save()){
                    echo 'user ' . $user->fullname . ' added <br />';
                }
                
            }

            $new = new Student();
            $new->user_id = $user->id;
            $new->matric_no = $matric;
            $new->status = 10; //aktif
            $new->program_id = $pg;
            $new->created_at = time();
            $new->updated_at = time();
            if($new->save()){
                echo 'student ' . $user->fullname . ' added to pg data <br />';
            } else {
                $new->flashError();
            }
        }
    }
}
