<?php

namespace backend\modules\teachingLoad\models;

use Yii;

/**
 * This is the model class for table "lec_lecturer".
 *
 * @property int $id
 * @property int $lecture_id
 * @property int $staff_id
 */
class LecLecturer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lec_lecturer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lecture_id'], 'required'],
            [['lecture_id', 'staff_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lecture_id' => 'Lecture ID',
            'staff_id' => 'Staff ID',
        ];
    }

    public function getStaff(){
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }
}
