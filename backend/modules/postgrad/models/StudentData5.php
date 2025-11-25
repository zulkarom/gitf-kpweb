<?php

namespace backend\modules\postgrad\models;

use Yii;

/**
 * This is the model class for table "pg_student_data4".
 *
 * @property int $id
 * @property string $NO_MATRIK
 * @property string $NAMA_PELAJAR
 * @property string $NO_IC_PASSPORT
 * @property string $TARIKH_LAHIR
 * @property string $JANTINA
 * @property int $gender
 * @property string $TARAF_PERKAHWINAN
 * @property string $NEGARA_ASAL
 * @property int $NEGARA_ASAL_KOD
 * @property string $KEWARGANEGARAAN
 * @property int $citizenship
 * @property string $PROGRAM
 * @property string $PROGRAM_PENGAJIAN
 * @property string $MOD_PENGAJIAN
 * @property string $BIDANG_PENGAJIAN
 * @property string $KOD_PROGRAM
 * @property string $TARAF_PENGAJIAN
 * @property string $ALAMAT
 * @property string $DAERAH
 * @property string $NO_TELEFON
 * @property string $EMEL_PERSONAL
 * @property string $EMEL_PELAJAR
 * @property string $AGAMA_KETURUNAN
 * @property string $CGPA_KEMASUKAN
 * @property string $JENIS_TAWARAN
 * @property string $SESI_MASUK
 * @property int $SESI_MASUK_SEMESTER_ID
 * @property int $TAHUN_KEMASUKAN
 * @property string $TARIKH_KEMASUKAN_SEMESTER1
 * @property string $PEMBIAYAAN
 * @property int $SEMESTER_SEMASA_PELAJAR
 */
class StudentData5 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pg_student_data4';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gender', 'NEGARA_ASAL_KOD', 'citizenship', 'SESI_MASUK_SEMESTER_ID', 'TAHUN_KEMASUKAN', 'SEMESTER_SEMASA_PELAJAR'], 'integer'],
            [['NO_MATRIK', 'JANTINA', 'NEGARA_ASAL'], 'string', 'max' => 10],
            [['NAMA_PELAJAR'], 'string', 'max' => 52],
            [['NO_IC_PASSPORT', 'BIDANG_PENGAJIAN'], 'string', 'max' => 32],
            [['TARIKH_LAHIR'], 'string', 'max' => 11],
            [['TARAF_PERKAHWINAN', 'PROGRAM'], 'string', 'max' => 16],
            [['KEWARGANEGARAAN'], 'string', 'max' => 13],
            [['PROGRAM_PENGAJIAN'], 'string', 'max' => 21],
            [['MOD_PENGAJIAN'], 'string', 'max' => 12],
            [['KOD_PROGRAM'], 'string', 'max' => 5],
            [['TARAF_PENGAJIAN'], 'string', 'max' => 44],
            [['ALAMAT'], 'string', 'max' => 134],
            [['DAERAH'], 'string', 'max' => 107],
            [['NO_TELEFON'], 'string', 'max' => 33],
            [['EMEL_PERSONAL'], 'string', 'max' => 91],
            [['EMEL_PELAJAR'], 'string', 'max' => 49],
            [['AGAMA_KETURUNAN'], 'string', 'max' => 27],
            [['CGPA_KEMASUKAN'], 'string', 'max' => 243],
            [['JENIS_TAWARAN'], 'string', 'max' => 57],
            [['SESI_MASUK'], 'string', 'max' => 42],
            [['TARIKH_KEMASUKAN_SEMESTER1'], 'string', 'max' => 8],
            [['PEMBIAYAAN'], 'string', 'max' => 112],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'NO_MATRIK' => 'No Matrik',
            'NAMA_PELAJAR' => 'Nama Pelajar',
            'NO_IC_PASSPORT' => 'No Ic Passport',
            'TARIKH_LAHIR' => 'Tarikh Lahir',
            'JANTINA' => 'Jantina',
            'gender' => 'Gender',
            'TARAF_PERKAHWINAN' => 'Taraf Perkahwinan',
            'NEGARA_ASAL' => 'Negara Asal',
            'NEGARA_ASAL_KOD' => 'Negara Asal Kod',
            'KEWARGANEGARAAN' => 'Kewarganegaraan',
            'citizenship' => 'Citizenship',
            'PROGRAM' => 'Program',
            'PROGRAM_PENGAJIAN' => 'Program Pengajian',
            'MOD_PENGAJIAN' => 'Mod Pengajian',
            'BIDANG_PENGAJIAN' => 'Bidang Pengajian',
            'KOD_PROGRAM' => 'Kod Program',
            'TARAF_PENGAJIAN' => 'Taraf Pengajian',
            'ALAMAT' => 'Alamat',
            'DAERAH' => 'Daerah',
            'NO_TELEFON' => 'No Telefon',
            'EMEL_PERSONAL' => 'Emel Personal',
            'EMEL_PELAJAR' => 'Emel Pelajar',
            'AGAMA_KETURUNAN' => 'Agama Keturunan',
            'CGPA_KEMASUKAN' => 'Cgpa Kemasukan',
            'JENIS_TAWARAN' => 'Jenis Tawaran',
            'SESI_MASUK' => 'Sesi Masuk',
            'SESI_MASUK_SEMESTER_ID' => 'Sesi Masuk Semester ID',
            'TAHUN_KEMASUKAN' => 'Tahun Kemasukan',
            'TARIKH_KEMASUKAN_SEMESTER1' => 'Tarikh Kemasukan Semester1',
            'PEMBIAYAAN' => 'Pembiayaan',
            'SEMESTER_SEMASA_PELAJAR' => 'Semester Semasa Pelajar',
        ];
    }
}
