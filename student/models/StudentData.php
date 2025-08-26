<?php

namespace student\models;

use Yii;

/**
 * This is the model class for table "pg_student_data".
 *
 * @property int $id
 * @property string $NO_MATRIK
 * @property string $NAMA_PELAJAR
 * @property string $NO_IC
 * @property string $TARIKH_LAHIR
 * @property string $JANTINA
 * @property string $TARAF_PERKAHWINAN
 * @property string $NEGARA_ASAL
 * @property string $KEWARGANEGARAAN
 * @property string $KOD_PROGRAM
 * @property string $TARAF_PENGAJIAN
 * @property string $ALAMAT
 * @property string $DAERAH
 * @property string $NO_TELEFON
 * @property string $EMEL_PERSONAL
 * @property string $EMEL_PELAJAR
 * @property string $AGAMA
 * @property string $BANGSA
 * @property string $NAMA SARJANA MUDA
 * @property string $UNIVERSITI SARJANA MUDA
 * @property string $CGPA SARJANA MUDA
 * @property string $TAHUN SARJANA MUDA
 * @property string $SESI MASUK
 * @property string $TAHUN KEMASUKAN
 * @property string $TARIKH KEMASUKAN
 * @property string $PEMBIAYAAN SENDIRI / TAJAAN
 * @property string $SEMESTER SEMASA PELAJAR
 * @property string $KAMPUS KOTA
 * @property string $STATUS PELAJAR
 */
class StudentData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pg_student_data3';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NO_MATRIK', 'JANTINA', 'TARAF_PERKAHWINAN'], 'string', 'max' => 9],
            [['NAMA_PELAJAR'], 'string', 'max' => 53],
            [['NO_IC'], 'string', 'max' => 14],
            [['TARIKH_LAHIR', 'KEWARGANEGARAAN', 'TARAF_PENGAJIAN', 'NO_TELEFON'], 'string', 'max' => 12],
            [['NEGARA_ASAL'], 'string', 'max' => 8],
            [['KOD_PROGRAM'], 'string', 'max' => 3],
            [['ALAMAT'], 'string', 'max' => 89],
            [['DAERAH', 'TARIKH KEMASUKAN
SEMESTER 1'], 'string', 'max' => 16],
            [['EMEL_PERSONAL'], 'string', 'max' => 33],
            [['EMEL_PELAJAR'], 'string', 'max' => 34],
            [['AGAMA', 'STATUS PELAJAR'], 'string', 'max' => 5],
            [['BANGSA'], 'string', 'max' => 6],
            [['NAMA SARJANA MUDA'], 'string', 'max' => 104],
            [['UNIVERSITI SARJANA MUDA'], 'string', 'max' => 25],
            [['CGPA SARJANA MUDA', 'TAHUN SARJANA MUDA', 'TAHUN KEMASUKAN'], 'string', 'max' => 4],
            [['SESI MASUK'], 'string', 'max' => 42],
            [['PEMBIAYAAN SENDIRI / TAJAAN'], 'string', 'max' => 18],
            [['SEMESTER SEMASA PELAJAR'], 'string', 'max' => 1],
            [['KAMPUS KOTA'], 'string', 'max' => 11],
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
            'NO_IC' => 'No Ic',
            'TARIKH_LAHIR' => 'Tarikh Lahir',
            'JANTINA' => 'Jantina',
            'TARAF_PERKAHWINAN' => 'Taraf Perkahwinan',
            'NEGARA_ASAL' => 'Negara Asal',
            'KEWARGANEGARAAN' => 'Kewarganegaraan',
            'KOD_PROGRAM' => 'Kod Program',
            'TARAF_PENGAJIAN' => 'Taraf Pengajian',
            'ALAMAT' => 'Alamat',
            'DAERAH' => 'Daerah',
            'NO_TELEFON' => 'No Telefon',
            'EMEL_PERSONAL' => 'Emel Personal',
            'EMEL_PELAJAR' => 'Emel Pelajar',
            'AGAMA' => 'Agama',
            'BANGSA' => 'Bangsa',
            'NAMA SARJANA MUDA' => 'Nama Sarjana Muda',
            'UNIVERSITI SARJANA MUDA' => 'Universiti Sarjana Muda',
            'CGPA SARJANA MUDA' => 'Cgpa Sarjana Muda',
            'TAHUN SARJANA MUDA' => 'Tahun Sarjana Muda',
            'SESI MASUK' => 'Sesi Masuk',
            'TAHUN KEMASUKAN' => 'Tahun Kemasukan',
            'TARIKH KEMASUKAN
SEMESTER 1' => 'Tarikh Kemasukan Semester 1',
            'PEMBIAYAAN SENDIRI / TAJAAN' => 'Pembiayaan Sendiri / Tajaan',
            'SEMESTER SEMASA PELAJAR' => 'Semester Semasa Pelajar',
            'KAMPUS KOTA' => 'Kampus Kota',
            'STATUS PELAJAR' => 'Status Pelajar',
        ];
    }
}
