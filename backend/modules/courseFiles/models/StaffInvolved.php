<?php

namespace backend\modules\courseFiles\models;

use Yii;

/**
 * This is the model class for table "staff_inv".
 *
 * @property int $id
 * @property int $staff_id
 * @property int $semester_id
 * @property string $timetable_file
 */
class StaffInvolved extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'staff_inv';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id', 'semester_id'], 'required'],
            [['staff_id', 'semester_id'], 'integer'],
            [['timetable_file'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Staff ID',
            'semester_id' => 'Semester ID',
            'timetable_file' => 'Timetable File',
        ];
    }
}
