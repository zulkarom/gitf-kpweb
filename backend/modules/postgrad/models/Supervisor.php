<?php

namespace backend\modules\postgrad\models;

use Yii;

/**
 * This is the model class for table "pg_supervisor".
 *
 * @property int $id
 * @property int $staff_id
 * @property int $external_id
 * @property int $created_at
 * @property int $updated_at
 */
class Supervisor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pg_supervisor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id', 'external_id', 'created_at', 'updated_at', 'is_internal'], 'integer'],
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
            'external_id' => 'External ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
