<?php

namespace backend\modules\postgrad\models;

use Yii;
use common\models\User;
use common\models\Common;
use common\models\Country;
use backend\models\Campus;
use backend\models\Semester;
use backend\modules\esiap\models\Program;
use backend\models\University;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
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
 * @property string $program_id
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
 * @property int $status_daftar
 * @property int $status_aktif
 */
class Student extends \yii\db\ActiveRecord
{
	const STATUS_NOT_ACTIVE = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_DEFERRED = 2;
	const STATUS_WITHDRAWN = 3;
	const STATUS_TERMINATED = 4;
	const STATUS_GRADUATED = 5;

    public $stage_name;
    public $fullname;
    public $stage_status;
    public $committee_role;
    public $committee_role_label;

    public function attributes()
    {
        return array_merge(parent::attributes(), ['status_daftar', 'status_aktif']);
    }

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
            [['user_id', 'matric_no', 'program_id'], 'required' , 'on' => 'create'],
            
            [['user_id', 'matric_no', 'program_id'], 'required' , 'on' => 'student_update'],

           // [['date_birth', 'gender', 'marital_status', 'nationality', 'citizenship', 'program_id', 'study_mode', 'address', 'city', 'phone_no', 'personal_email', 'religion', 'race', 'bachelor_name', 'bachelor_university', 'bachelor_cgpa', 'bachelor_year', 'admission_semester', 'admission_year', 'admission_date', 'sponsor', 'current_sem', 'campus_id', 'status'], 'required' , 'on' => 'student_update'],

            [['personal_email'], 'email'],
            
            [['matric_no'], 'unique'],

             [['admission_year'], 'match' ,'pattern'=>'/^[0-9]+$/u', 'message'=> 'Tahun Kemasukan can contain only numeric characters.'],

             [['bachelor_year'], 'match' ,'pattern'=>'/^[0-9]+$/u', 'message'=> 'Tahun Sarjana Muda can contain only numeric characters.'],

             [['master_year'], 'match' ,'pattern'=>'/^[0-9]+$/u', 'message'=> 'Tahun Sarjana can contain only numeric characters.'],

            [['date_birth', 'admission_date'], 'safe'],
            
            [['gender', 'marital_status', 'nationality', 'citizenship', 'study_mode', 'religion', 'race', 'admission_semester', 'current_sem', 'campus_id', 'field_id', 'related_university_id'], 'integer'],
            
            [['matric_no', 'nric'], 'string', 'max' => 20],
            
            [['address', 'city', 'personal_email', 'bachelor_name', 'bachelor_university',  'master_name', 'master_university', 'sponsor'], 'string', 'max' => 225],
            
            [['remark'], 'string'],
            
            [['outstanding_fee', 'bachelor_cgpa', 'master_cgpa'], 'number'],
            
            [['program_id', 'status_daftar', 'status_aktif'], 'integer'],
            
            [['phone_no'], 'string', 'max' => 50],
            
            [['bachelor_year', 'admission_year', 'master_year'], 'string', 'max' => 4],
            [['status_daftar', 'status_aktif'], 'integer'],

            [['study_mode_rc'], 'in', 'range' => ['research', 'coursework']],




        ];
    }

    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        $programId = (int)$this->program_id;
        if (in_array($programId, [84, 85], true)) {
            $this->study_mode_rc = 'research';
        } elseif (in_array($programId, [81, 82], true)) {
            $this->study_mode_rc = 'coursework';
        }

        return true;
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
            'nationality' => 'Negara',
            'citizenship' => 'Kewarganegaraan',
            'program_id' => 'Program',
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
            'master_name' => 'Nama Sarjana',
            'master_university' => 'Universiti Sarjana',
            'master_cgpa' => 'CGPA Sarjana',
            'master_year' => 'Tahun Sarjana',
            'admission_semester' => 'Sesi Masuk',
            'admission_year' => 'Tahun Kemasukan',
            'admission_date' => 'Tarikh Kemasukan',
            'sponsor' => 'Pembiayaan Sendiri / Tajaan',
            'current_sem' => 'Semester Semasa Pelajar',
            'campus.campus_name' => 'Kampus',
            'campus_id' => 'Kampus',
            'status' => 'Status Pelajar',
            'field_id' => 'Bidang Pengajian',
            'program.pro_name' => 'Program',
            'field.field_name' => 'Bidang Pengajian',
            'related_university_id' => 'Institusi Berkaitan',
            'relatedUniversity.uni_name' => 'Institusi Berkaitan',
            'outstanding_fee' => 'Hutang Tertunggak',
            'status_daftar' => 'Status Daftar',
            'status_aktif' => 'Status Aktif'
         ];
    }
    
    public function statusList(){
        return [
            self::STATUS_NOT_ACTIVE => 'Not Active',
            self::STATUS_ACTIVE => 'Aktif',
            self::STATUS_DEFERRED => 'Tangguh',
            self::STATUS_WITHDRAWN => 'Tarik Diri',
            self::STATUS_TERMINATED => 'Digantung',
            self::STATUS_GRADUATED => 'Graduasi'
        ];
    }

    public static function getStatusColor(){
	    return [self::STATUS_NOT_ACTIVE => 'danger', self::STATUS_ACTIVE => 'primary', self::STATUS_DEFERRED => 'warning', self::STATUS_WITHDRAWN => 'info', self::STATUS_TERMINATED => 'warning', self::STATUS_GRADUATED => 'success'];
	}

    public function getStatusText(){
        if($this->status >= 0){
            if (array_key_exists($this->status, $this->statusList())) {
                return $this->statusList()[$this->status];
            }else{
                return '';
            }
        }else{
            return '';
        }
    }

    public function getStatusLabel(){
        $color = "";
        if(array_key_exists($this->status, $this->statusColor)){
            $color = $this->statusColor[$this->status];
        }
        return '<span class="label label-'.$color.'">'. $this->statusText .'</span>';
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
    
    public function getField(){
        return $this->hasOne(Field::className(), ['id' => 'field_id']);
    }
    
    /**
     * 84 = sarjana
     * 85 = doktor falsafah
     */
    public function getProgram(){
        return $this->hasOne(Program::className(), ['id' => 'program_id']);
    }
    
    public function getRelatedUniversity(){
        return $this->hasOne(University::className(), ['id' => 'related_university_id']);
    }

    public function listProgram(){
        return ArrayHelper::map(Program::find()->where(['faculty_id' => 1, 'pro_level' => [3,4], 'status' => 1])->orderBy('pro_order ASC')->all(), 'id', 'programNameCode');
    }
    
    public function getProgramCode(){
        if($this->program){
           $f = '';
           if(in_array($this->program_id, [84,85])){
               if($this->field){
                   $f = '<br />('. $this->field->field_name .')';
               }
               
           }
           return $this->program->program_code . $f;
        }
    }

    public function getGenderText(){

        if($this->gender && $this->gender >= 0){
            return Common::gender()[$this->gender];
        }else{
            return '';
        }
    }
    
    public function getStudentSemesters()
    {
        return $this->hasMany(StudentSemester::className(), ['student_id' => 'id'])->orderBy('semester_id ASC');
    }
    
    public function getSupervisors()
    {
        return $this->hasMany(StudentSupervisor::className(), ['student_id' => 'id'])->orderBy('sv_role ASC');
    }
    
    public function getStages()
    {
        return $this->hasMany(StudentStage::className(), ['student_id' => 'id'])->orderBy('stage_id');
    }

    public function getMaritalText(){
        if($this->marital_status > 0){
            return self::marital()[$this->marital_status];
        }else{
            return '';
        }
    }

    public static function marital(){
	    return [
			1 => 'Berkahwin', 
			2 => 'Bujang', 
			3 => 'Janda', 
			4 => 'Duda', 
			5 => 'Bercerai', 
			9 => 'Tidak Dinyatakan'
		];
	}
    
    //MOD PENGAJIAN sepenuh / separuh masa
    public function getStudyModeText(){
        if($this->study_mode > 0){
            return Common::studyMode()[$this->study_mode];
        }else{
            return '';
        }
    }

    // TARAF PENGAJIAN - KERJA KURSUS ATAU PENYELIDIKAN
    public function getStudyModeRcText(){
        $arr = ['research' => 'Penyelidikan', 'coursework' => 'Kerja Kursus'];
        if($this->study_mode_rc){
            return $arr[$this->study_mode_rc];
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
            $raceList = Common::race();
            return array_key_exists($this->race, $raceList) ? $raceList[$this->race] : '';
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
