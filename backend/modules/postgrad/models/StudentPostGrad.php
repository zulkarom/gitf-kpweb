<?php

namespace backend\modules\postgrad\models;

use Yii;
use common\models\User;
use common\models\Common;
use common\models\Country;
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
 * @property string $prog_code
 * @property int $edu_level
 * @property string $address
 * @property string $city
 * @property string $phone_no
 * @property string $personal_email
 * @property int $religion
 * @property int $race
 * @property string $bachelor_name
 * @property string $university_name
 * @property string $bachelor_cgpa
 * @property string $bachelor_year
 * @property int $session
 * @property string $admission_year
 * @property string $admission_date_sem1
 * @property int $sponsor
 * @property int $student_current_sem
 * @property int $city_campus
 * @property int $student_status
 */
class StudentPostGrad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student_pg';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'matric_no', 'nric', 'date_birth', 'gender', 'marital_status', 'nationality', 'citizenship', 'prog_code', 'edu_level', 'address', 'city', 'phone_no', 'personal_email', 'religion', 'race', 'bachelor_name', 'university_name', 'bachelor_cgpa', 'bachelor_year', 'session', 'admission_year', 'admission_date_sem1', 'sponsor', 'student_current_sem', 'city_campus', 'student_status'], 'required' , 'on' => 'create'],

            [['personal_email'], 'email'],

             [['admission_year'], 'match' ,'pattern'=>'/^[0-9]+$/u', 'message'=> 'Tahun Kemasukan can contain only numeric characters.'],

             [['bachelor_year'], 'match' ,'pattern'=>'/^[0-9]+$/u', 'message'=> 'Tahun Sarjana Muda can contain only numeric characters.'],

             [['bachelor_cgpa'], 'match' ,'pattern'=>'/^[0-9]+$/u', 'message'=> 'CGPA Sarjana Muda can contain only numeric characters.'],

            [['date_birth', 'admission_date_sem1'], 'safe'],
            [['gender', 'marital_status', 'nationality', 'citizenship', 'edu_level', 'religion', 'race', 'session', 'sponsor', 'student_current_sem', 'city_campus', 'student_status'], 'integer'],
            [['matric_no', 'nric'], 'string', 'max' => 20],
            [['address', 'city', 'personal_email', 'bachelor_name', 'university_name'], 'string', 'max' => 225],
            [['prog_code', 'bachelor_cgpa'], 'string', 'max' => 10],
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
            'prog_code' => 'Kod Program',
            'edu_level' => 'Taraf Pengajian',
            'address' => 'Alamat',
            'city' => 'Daerah',
            'phone_no' => 'No. Telefon',
            'personal_email' => 'Emel Personal',
            'religion' => 'Agama',
            'race' => 'Bangsa',
            'bachelor_name' => 'Nama Sarjana Muda',
            'university_name' => 'Universiti Sarjana Muda',
            'bachelor_cgpa' => 'CGPA Sarjana Muda',
            'bachelor_year' => 'Tahun Sarjana Muda',
            'session' => 'Sesi Masuk',
            'admission_year' => 'Tahun Kemasukan',
            'admission_date_sem1' => 'Tahun Kemasukan Semester 1',
            'sponsor' => 'Pembiayaan Sendiri / Tajaan',
            'student_current_sem' => 'Semester Semasa Pelajar',
            'city_campus' => 'Kampus',
            'student_status' => 'Status Pelajar',
        ];
    }

    public function getUser(){
         return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getCountry(){
         return $this->hasOne(Country::className(), ['id' => 'nationality']);
    }

    public function getGenderText(){
        if($this->gender > 0){
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

    public function getStdStatusText(){
        if($this->student_status > 0){
            return Common::studentStatus()[$this->student_status];
        }else{
            return '';
        }
    }

    public function getEduLvlText(){
        if($this->edu_level > 0){
            return Common::eduLevel()[$this->edu_level];
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

    public function getSponsorText(){
        if($this->sponsor > 0){
            return Common::sponsor()[$this->sponsor];
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
