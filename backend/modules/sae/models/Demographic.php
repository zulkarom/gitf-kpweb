<?php

namespace backend\modules\sae\models;

use Yii;

/**
 * This is the model class for table "psy_demographic".
 *
 * @property int $id
 * @property int $bat_id
 * @property int $column_id
 * @property string $demo_value
 */
class Demographic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'psy_demographic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bat_id', 'column_id', 'demo_value'], 'required'],
            [['bat_id', 'column_id'], 'integer'],
            [['demo_value'], 'string', 'max' => 225],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bat_id' => 'Bat ID',
            'column_id' => 'Column ID',
            'demo_value' => 'Demo Value',
        ];
    }
}
