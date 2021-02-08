<?php

namespace backend\modules\staff\models;

use Yii;

/**
 * This is the model class for table "staff_main_position".
 *
 * @property int $id
 * @property string $position_name
 * @property int $staff_id
 * @property string $start_date
 * @property string $end_date
 */
class StaffMainPosition extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'staff_main_position';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['position_name', 'staff_id'], 'required'],
            [['staff_id'], 'integer'],
            [['position_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'position_name' => 'Position Name',
            'staff_id' => 'Staff Name',
        ];
    }
}
