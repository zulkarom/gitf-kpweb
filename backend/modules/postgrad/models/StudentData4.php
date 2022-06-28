<?php

namespace backend\modules\postgrad\models;

use Yii;

/**
 * This is the model class for table "pg_student_data4".
 *
 * @property int $id
 * @property string $matric
 * @property int $admission_year
 * @property string $admission_date
 * @property string $sponsor
 * @property int $semester
 */
class StudentData4 extends \yii\db\ActiveRecord
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
            [['admission_year', 'semester'], 'integer'],
            [['matric', 'admission_date'], 'string', 'max' => 9],
            [['sponsor'], 'string', 'max' => 90],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'matric' => 'Matric',
            'admission_year' => 'Admission Year',
            'admission_date' => 'Admission Date',
            'sponsor' => 'Sponsor',
            'semester' => 'Semester',
        ];
    }
}
