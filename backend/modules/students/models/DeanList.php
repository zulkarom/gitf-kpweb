<?php

namespace backend\modules\students\models;

use Yii;

/**
 * This is the model class for table "st_dean_list".
 *
 * @property int $id
 * @property int $semester_id
 * @property string $matric_no
 */
class DeanList extends \yii\db\ActiveRecord
{
	public $folder = 'deanlist';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'st_dean_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['semester_id', 'matric_no'], 'required'],
            [['semester_id'], 'integer'],
            [['matric_no'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'semester_id' => 'Semester',
            'matric_no' => 'Matric No',
        ];
    }
	
	public function getStudent()
    {
        return $this->hasOne(Student::className(), ['matric_no' => 'matric_no']);
    }

}
