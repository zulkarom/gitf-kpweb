<?php

namespace backend\modules\staff\models;

use Yii;

/**
 * This is the model class for table "staff_position_status".
 *
 * @property int $id
 * @property string $status_name
 * @property string $status_order
 */
class StaffPositionStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff_position_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_name', 'status_order'], 'required'],
            [['status_order'], 'number'],
            [['status_name'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Status ID',
            'status_name' => 'Status Name',
            'status_order' => 'Status Order',
        ];
    }
}
