<?php

namespace backend\modules\postgrad\models;

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
 * @property string $NAMA_SARJANA_MUDA
 * @property string $UNIVERSITI_SARJANA_MUDA
 * @property string $CGPA_SARJANA_MUDA
 * @property string $TAHUN_SARJANA_MUDA
 * @property string $SESI_MASUK
 * @property string $TAHUN_KEMASUKAN
 * @property string $TARIKH_KEMASUKAN
 * @property string $PEMBIAYAAN
 * @property string $admission_date
 * @property string $SEMESTER
 * @property string $KAMPUS
 * @property string $STATUS
 */
class StudentData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pg_student_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['admission_date'], 'safe'],
            [['NO_MATRIK', 'JANTINA', 'TARAF_PERKAHWINAN'], 'string', 'max' => 9],
            [['NAMA_PELAJAR'], 'string', 'max' => 53],
            [['NO_IC'], 'string', 'max' => 14],
            [['TARIKH_LAHIR', 'KEWARGANEGARAAN', 'TARAF_PENGAJIAN', 'NO_TELEFON'], 'string', 'max' => 12],
            [['NEGARA_ASAL'], 'string', 'max' => 8],
            [['KOD_PROGRAM'], 'string', 'max' => 3],
            [['ALAMAT'], 'string', 'max' => 89],
            [['DAERAH', 'TARIKH_KEMASUKAN'], 'string', 'max' => 16],
            [['EMEL_PERSONAL'], 'string', 'max' => 33],
            [['EMEL_PELAJAR'], 'string', 'max' => 34],
            [['AGAMA', 'STATUS'], 'string', 'max' => 5],
            [['BANGSA'], 'string', 'max' => 6],
            [['NAMA_SARJANA_MUDA'], 'string', 'max' => 104],
            [['UNIVERSITI_SARJANA_MUDA'], 'string', 'max' => 25],
            [['CGPA_SARJANA_MUDA', 'TAHUN_SARJANA_MUDA', 'TAHUN_KEMASUKAN'], 'string', 'max' => 4],
            [['SESI_MASUK'], 'string', 'max' => 42],
            [['PEMBIAYAAN'], 'string', 'max' => 18],
            [['SEMESTER'], 'string', 'max' => 1],
            [['KAMPUS'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'NO_MATRIK' => 'No  Matrik',
            'NAMA_PELAJAR' => 'Nama  Pelajar',
            'NO_IC' => 'No  Ic',
            'TARIKH_LAHIR' => 'Tarikh  Lahir',
            'JANTINA' => 'Jantina',
            'TARAF_PERKAHWINAN' => 'Taraf  Perkahwinan',
            'NEGARA_ASAL' => 'Negara  Asal',
            'KEWARGANEGARAAN' => 'Kewarganegaraan',
            'KOD_PROGRAM' => 'Kod  Program',
            'TARAF_PENGAJIAN' => 'Taraf  Pengajian',
            'ALAMAT' => 'Alamat',
            'DAERAH' => 'Daerah',
            'NO_TELEFON' => 'No  Telefon',
            'EMEL_PERSONAL' => 'Emel  Personal',
            'EMEL_PELAJAR' => 'Emel  Pelajar',
            'AGAMA' => 'Agama',
            'BANGSA' => 'Bangsa',
            'NAMA_SARJANA_MUDA' => 'Nama  Sarjana  Muda',
            'UNIVERSITI_SARJANA_MUDA' => 'Universiti  Sarjana  Muda',
            'CGPA_SARJANA_MUDA' => 'Cgpa  Sarjana  Muda',
            'TAHUN_SARJANA_MUDA' => 'Tahun  Sarjana  Muda',
            'SESI_MASUK' => 'Sesi  Masuk',
            'TAHUN_KEMASUKAN' => 'Tahun  Kemasukan',
            'TARIKH_KEMASUKAN' => 'Tarikh  Kemasukan',
            'PEMBIAYAAN' => 'Pembiayaan',
            'admission_date' => 'Admission Date',
            'SEMESTER' => 'Semester',
            'KAMPUS' => 'Kampus',
            'STATUS' => 'Status',
        ];
    }
}
