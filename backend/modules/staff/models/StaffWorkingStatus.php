<?php

namespace backend\modules\staff\models;

use Yii;

/**
 * This is the model class for table "staff_working_status".
 *
 * @property int $work_id
 * @property string $work_name
 * @property string $work_order
 */
class StaffWorkingStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff_working_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['work_name', 'work_order'], 'required'],
            [['work_order'], 'number'],
            [['work_name'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'work_id' => 'Work ID',
            'work_name' => 'Work Name',
            'work_order' => 'Work Order',
        ];
    }
}
