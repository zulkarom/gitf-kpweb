<?php

namespace backend\modules\postgrad\models;

use Yii;

class PgStudentThesis extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'pg_student_thesis';
    }

    public function rules()
    {
        return [
            [['student_id'], 'required'],
            [['student_id', 'is_active', 'created_at', 'updated_at'], 'integer'],
            [['date_applied'], 'safe'],
            [['thesis_title'], 'string', 'max' => 500],
            [['is_active'], 'default', 'value' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_id' => 'Student ID',
            'thesis_title' => 'Thesis Title',
            'date_applied' => 'Date Applied',
            'is_active' => 'Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $time = time();
            if ($insert && empty($this->created_at)) {
                $this->created_at = $time;
            }
            $this->updated_at = $time;
            return true;
        }

        return false;
    }

    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
    }
}
