<?php

namespace backend\modules\postgrad\models;

use Yii;
use backend\models\Semester;
use yii\helpers\Html;

class StudentRegister extends \yii\db\ActiveRecord
{
    //---STATUS DAFTAR----\\
    const STATUS_DAFTAR_DAFTAR = 10;
    const STATUS_DAFTAR_TANGGUH = 11;
    const STATUS_DAFTAR_GRADUAT = 100;
    const STATUS_DAFTAR_DITAWARKAN = 1;
    const STATUS_DAFTAR_TIDAK_DAFTAR = 3;
    const STATUS_DAFTAR_TARIK_DIRI = 4;
    const STATUS_DAFTAR_DIBERHENTIKAN = 6;
    const STATUS_DAFTAR_MENINGGAL_DUNIA = 8;
    const STATUS_DAFTAR_NOS = 9;
    const STATUS_DAFTAR_NA = null;

    //---STATUS AKTIF----\\
    const STATUS_AKTIF_TIDAK_AKTIF = 0;
    const STATUS_AKTIF_AKTIF = 1;
    const STATUS_AKTIF_NA = null;

    public static function tableName()
    {
        return 'pg_student_reg';
    }

    public function rules()
    {
        return [
            [['student_id', 'semester_id'], 'required'],
            [['semester_id', 'student_id'], 'integer'],
            [['status_daftar', 'status_aktif'], 'integer'],
            ['fee_amount', 'number'],
            [['date_register', 'fee_paid_at'], 'safe'],

            [['student_id', 'semester_id'], 'required', 'on' => 'csv_status'],
            [['student_id', 'semester_id', 'status_daftar', 'status_aktif'], 'integer', 'on' => 'csv_status'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'semester_id' => 'Semester',
            'semesterName' => 'Semester',
            'studentName' => 'Student',
            'date_register' => 'Semester Register',
            'free_paid_at' => 'Payment Date'
        ];
    }

    public function getModules(){
         return $this->hasMany(SemesterModule::className(), ['student_sem_id' => 'id']);
    }

    public function getSemester(){
         return $this->hasOne(Semester::className(), ['id' => 'semester_id']);
    }

    public function getSemesterName(){
        return $this->semester->longFormat();
    }

    public function getStudent(){
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
    }

    public function getStudentName(){
        return $this->student->user->fullname;
    }

    public static function statusDaftarList(){
        return [
            '' => 'N/A',
            self::STATUS_DAFTAR_DITAWARKAN => 'Ditawarkan',
            self::STATUS_DAFTAR_DAFTAR => 'Daftar',
            self::STATUS_DAFTAR_TIDAK_DAFTAR => 'Tidak daftar',
            self::STATUS_DAFTAR_TANGGUH => 'Tangguh',
            self::STATUS_DAFTAR_TARIK_DIRI => 'Tarik Diri',
            self::STATUS_DAFTAR_GRADUAT => 'Graduat',
            self::STATUS_DAFTAR_DIBERHENTIKAN => 'Diberhentikan',
            self::STATUS_DAFTAR_MENINGGAL_DUNIA => 'Meninggal Dunia',
            self::STATUS_DAFTAR_NOS => 'NOS',
        ];
    }

    public static function statusAktifList(){
        return [
            '' => 'N/A',
            self::STATUS_AKTIF_AKTIF => 'Aktif',
            self::STATUS_AKTIF_TIDAK_AKTIF => 'Tidak Aktif',
        ];
    }

    public static function statusDaftarColorMap()
    {
        return [
            self::STATUS_DAFTAR_DITAWARKAN => 'info',
            self::STATUS_DAFTAR_DAFTAR => 'success',
            self::STATUS_DAFTAR_TIDAK_DAFTAR => 'danger',
            self::STATUS_DAFTAR_TANGGUH => 'warning',
            self::STATUS_DAFTAR_TARIK_DIRI => 'danger',
            self::STATUS_DAFTAR_GRADUAT => 'success',
            self::STATUS_DAFTAR_DIBERHENTIKAN => 'danger',
            self::STATUS_DAFTAR_MENINGGAL_DUNIA => 'danger',
            self::STATUS_DAFTAR_NOS => 'default',
        ];
    }

    public static function statusAktifColorMap()
    {
        return [
            self::STATUS_AKTIF_AKTIF => 'success',
            self::STATUS_AKTIF_TIDAK_AKTIF => 'danger',
        ];
    }

    public static function statusDaftarText($code){
        if ($code === null || $code === '') {
            return 'N/A';
        }
        $list = self::statusDaftarList();
        return array_key_exists((int)$code, $list) ? $list[(int)$code] : '';
    }

    public static function statusAktifText($code){
        if ($code === null || $code === '') {
            return 'N/A';
        }
        $list = self::statusAktifList();
        return array_key_exists((int)$code, $list) ? $list[(int)$code] : '';
    }

    public static function statusDaftarLabel($code)
    {
        if ($code === null || $code === '') {
            return Html::tag('span', 'N/A', ['class' => 'label label-default']);
        }

        $text = self::statusDaftarText($code);
        $map = self::statusDaftarColorMap();
        $int = (int)$code;
        $color = array_key_exists($int, $map) ? $map[$int] : 'default';

        return Html::tag('span', $text !== '' ? $text : (string)$code, ['class' => 'label label-' . $color]);
    }

    public static function statusAktifLabel($code)
    {
        if ($code === null || $code === '') {
            return Html::tag('span', 'N/A', ['class' => 'label label-default']);
        }

        $text = self::statusAktifText($code);
        $map = self::statusAktifColorMap();
        $int = (int)$code;
        $color = array_key_exists($int, $map) ? $map[$int] : 'default';

        return Html::tag('span', $text !== '' ? $text : (string)$code, ['class' => 'label label-' . $color]);
    }

    public function getStatusDaftarText(){
        return self::statusDaftarText($this->status_daftar);
    }

    public function getStatusAktifText(){
        return self::statusAktifText($this->status_aktif);
    }

    public function getStatusDaftarLabel(){
        return self::statusDaftarLabel($this->status_daftar);
    }

    public function getStatusAktifLabel(){
        return self::statusAktifLabel($this->status_aktif);
    }

    public static function mapStatusDaftarFromText($text)
    {
        $t = trim((string)$text);
        if ($t === '') {
            return null;
        }
        $t = mb_strtolower($t);
        $t = preg_replace('/\s+/', ' ', $t);
        $t = str_replace(['_', '-'], ' ', $t);
        $t = trim($t);
        if ($t === 'n/a' || $t === 'na') {
            return null;
        }

        $map = [
            'ditawarkan' => self::STATUS_DAFTAR_DITAWARKAN,
            'daftar' => self::STATUS_DAFTAR_DAFTAR,
            'tidak daftar' => self::STATUS_DAFTAR_TIDAK_DAFTAR,
            'tangguh' => self::STATUS_DAFTAR_TANGGUH,
            'tarik diri' => self::STATUS_DAFTAR_TARIK_DIRI,
            'graduat' => self::STATUS_DAFTAR_GRADUAT,
            'diberhentikan' => self::STATUS_DAFTAR_DIBERHENTIKAN,
            'meninggal dunia' => self::STATUS_DAFTAR_MENINGGAL_DUNIA,
            'nos' => self::STATUS_DAFTAR_NOS,
        ];

        if (array_key_exists($t, $map)) {
            return $map[$t];
        }

        if (is_numeric($t)) {
            return (int)$t;
        }

        return false;
    }

    public static function mapStatusAktifFromText($text)
    {
        $t = trim((string)$text);
        if ($t === '') {
            return null;
        }
        $t = mb_strtolower($t);
        $t = preg_replace('/\s+/', ' ', $t);
        $t = str_replace(['_', '-'], ' ', $t);
        $t = trim($t);
        if ($t === 'n/a' || $t === 'na') {
            return null;
        }

        $map = [
            'aktif' => self::STATUS_AKTIF_AKTIF,
            'tidak aktif' => self::STATUS_AKTIF_TIDAK_AKTIF,
            'tak aktif' => self::STATUS_AKTIF_TIDAK_AKTIF,
            'inactive' => self::STATUS_AKTIF_TIDAK_AKTIF,
            'active' => self::STATUS_AKTIF_AKTIF,
        ];

        if (array_key_exists($t, $map)) {
            return $map[$t];
        }

        if (is_numeric($t)) {
            return (int)$t;
        }

        return false;
    }
}
