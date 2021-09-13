<?php

namespace backend\modules\postgrad\models;

use Yii;

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
 * @property int $student_email
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
            [['matric_no', 'name', 'nric', 'date_birth', 'gender', 'marital_status', 'nationality', 'citizenship', 'prog_code', 'edu_level', 'address', 'city', 'phone_no', 'personal_email', 'student_email', 'religion', 'race', 'bachelor_name', 'university_name', 'bachelor_cgpa', 'bachelor_year', 'session', 'admission_year', 'admission_date_sem1', 'sponsor', 'student_current_sem', 'city_campus', 'student_status'], 'required'],
            [['date_birth', 'admission_date_sem1'], 'safe'],
            [['gender', 'marital_status', 'nationality', 'citizenship', 'edu_level', 'student_email', 'religion', 'race', 'session', 'sponsor', 'student_current_sem', 'city_campus', 'student_status'], 'integer'],
            [['matric_no', 'nric'], 'string', 'max' => 20],
            [['name', 'address', 'city', 'personal_email', 'bachelor_name', 'university_name'], 'string', 'max' => 225],
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
            'name' => 'Name',
            'nric' => 'Nric',
            'date_birth' => 'Date Birth',
            'gender' => 'Gender',
            'marital_status' => 'Marital Status',
            'nationality' => 'Nationality',
            'citizenship' => 'Citizenship',
            'program' => 'Prog Code',
            'edu_level' => 'Edu Level',
            'address' => 'Address',
            'city' => 'City',
            'phone_no' => 'Phone No',
            'personal_email' => 'Personal Email',
            'student_email' => 'Student Email',
            'religion' => 'Religion',
            'race' => 'Race',
            'bachelor_name' => 'Bachelor Name',
            'university_name' => 'University Name',
            'bachelor_cgpa' => 'Bachelor Cgpa',
            'bachelor_year' => 'Bachelor Year',
            'session' => 'Session',
            'admission_year' => 'Admission Year',
            'admission_date_sem1' => 'Admission Date Sem1',
            'sponsor' => 'Sponsor',
            'student_current_sem' => 'Student Current Sem',
            'city_campus' => 'City Campus',
            'student_status' => 'Student Status',
        ];
    }
}
