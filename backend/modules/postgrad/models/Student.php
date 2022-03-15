<?php

namespace backend\modules\postgrad\models;

use Yii;
use common\models\User;
use common\models\Common;
use common\models\Country;
use backend\models\Campus;
use backend\models\Semester;
use backend\modules\esiap\models\Program;
/**
 * This is the model class for table "student_pg".
 *
 * @property int $id
 * @property string $matric_no
 * @property string $name
 * @property string $nric
 * @property string $date_birth
 * @property int $gender
 * @property int $marital_status
 * @property int $nationality
 * @property int $citizenship
 * @property string $program_code
 * @property int $study_mode
 * @property string $address
 * @property string $city
 * @property string $phone_no
 * @property string $personal_email
 * @property int $religion
 * @property int $race
 * @property string $bachelor_name
 * @property string $bachelor_university
 * @property string $bachelor_cgpa
 * @property string $bachelor_year
 * @property int $admission_semester
 * @property string $admission_year
 * @property string $admission_date
 * @property int $sponsor
 * @property int $current_sem
 * @property int $campus_id
 * @property int $status
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pg_student';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'matric_no', 'nric', 'date_birth', 'gender', 'marital_status', 'nationality', 'citizenship', 'program_code', 'study_mode', 'address', 'city', 'phone_no', 'personal_email', 'religion', 'race', 'bachelor_name', 'bachelor_university', 'bachelor_cgpa', 'bachelor_year', 'admission_semester', 'admission_year', 'admission_date', 'sponsor', 'current_sem', 'campus_id', 'status'], 'required' , 'on' => 'create'],

            [['date_birth', 'gender', 'marital_status', 'nationality', 'citizenship', 'program_code', 'study_mode', 'address', 'city', 'phone_no', 'personal_email', 'religion', 'race', 'bachelor_name', 'bachelor_university', 'bachelor_cgpa', 'bachelor_year', 'admission_semester', 'admission_year', 'admission_date', 'sponsor', 'current_sem', 'campus_id', 'status'], 'required' , 'on' => 'student_update'],

            [['personal_email'], 'email'],
            
            [['matric_no'], 'unique'],

             [['admission_year'], 'match' ,'pattern'=>'/^[0-9]+$/u', 'message'=> 'Tahun Kemasukan can contain only numeric characters.'],

             [['bachelor_year'], 'match' ,'pattern'=>'/^[0-9]+$/u', 'message'=> 'Tahun Sarjana Muda can contain only numeric characters.'],

            [['date_birth', 'admission_date'], 'safe'],
            [['gender', 'marital_status', 'nationality', 'citizenship', 'study_mode', 'religion', 'race', 'admission_semester', 'current_sem', 'campus_id', 'status'], 'integer'],
            [['matric_no', 'nric'], 'string', 'max' => 20],
            [['address', 'city', 'personal_email', 'bachelor_name', 'bachelor_university', 'sponsor'], 'string', 'max' => 225],
            [['program_code', 'bachelor_cgpa'], 'string', 'max' => 10],
            [['phone_no'], 'string', 'max' => 50],
            [['bachelor_year', 'admission_year'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'matric_no' => 'Matric No',
            'user_id' => 'User Id',
            'nric' => 'No IC / Passport',
            'date_birth' => 'Tarikh Lahir',
            'gender' => 'Jantina',
            'marital_status' => 'Taraf Perkahwinan',
            'nationality' => 'Negara Asal',
            'citizenship' => 'Kewarganegaraan',
            'program_code' => 'Program',
            'study_mode' => 'Taraf Pengajian',
            'address' => 'Alamat',
            'city' => 'Daerah',
            'phone_no' => 'No. Telefon',
            'personal_email' => 'Emel Personal',
            'religion' => 'Agama',
            'race' => 'Bangsa',
            'bachelor_name' => 'Nama Sarjana Muda',
            'bachelor_university' => 'Universiti Sarjana Muda',
            'bachelor_cgpa' => 'CGPA Sarjana Muda',
            'bachelor_year' => 'Tahun Sarjana Muda',
            'admission_semester' => 'Sesi Masuk',
            'admission_year' => 'Tahun Kemasukan',
            'admission_date' => 'Tahun Kemasukan Semester 1',
            'sponsor' => 'Pembiayaan Sendiri / Tajaan',
            'current_sem' => 'Semester Semasa Pelajar',
            'campus.campus_name' => 'Kampus',
            'status' => 'Status Pelajar',
        ];
    }
    
    public function statusList(){
        return [
            10 => 'Active',
            20 => 'Postponed',
            30 => 'Not Active',
            90 => 'Dropped',
            100 => 'Graduate'
        ];
    }
    
    public function getStatusText(){
        if($this->status > 0){
            return $this->statusList()[$this->status];
        }else{
            return '';
        }
    }

    public function getUser(){
         return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getCountry(){
         return $this->hasOne(Country::className(), ['id' => 'nationality']);
    }

    public function getSemester(){
         return $this->hasOne(Semester::className(), ['id' => 'admission_semester']);
    }
    
    public function getCampus(){
        return $this->hasOne(Campus::className(), ['id' => 'campus_id']);
    }
    
    public function getProgram(){
        return $this->hasOne(Program::className(), ['program_code' => 'program_code']);
    }

    public function getGenderText(){
        if($this->gender >= 0){
            return Common::gender()[$this->gender];
        }else{
            return '';
        }
    }
    
    

    public function getMaritalText(){
        if($this->marital_status > 0){
            return Common::marital2()[$this->marital_status];
        }else{
            return '';
        }
    }

    

    public function getStudyModeText(){
        if($this->study_mode > 0){
            return Common::studyMode()[$this->study_mode];
        }else{
            return '';
        }
    }

    public function getCitizenText(){
        if($this->citizenship > 0){
            return Common::citizenship()[$this->citizenship];
        }else{
            return '';
        }
    }

    public function getRaceText(){
        if($this->race > 0){
            return Common::race()[$this->race];
        }else{
            return '';
        }
    }

    public function getReligionText(){
        if($this->religion > 0){
            return Common::religion()[$this->religion];
        }else{
            return '';
        }
    }



    public function flashError(){
        if($this->getErrors()){
            foreach($this->getErrors() as $error){
                if($error){
                    foreach($error as $e){
                        Yii::$app->session->addFlash('error', $e);
                    }
                }
            }
        }

    }
}
