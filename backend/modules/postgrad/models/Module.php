<?php

namespace backend\modules\postgrad\models;

use Yii;

/**
 * This is the model class for table "pg_module".
 *
 * @property int $id
 * @property string $module_name
 * @property int $created_at
 * @property int $updated_at
 */
class Module extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pg_module';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['module_name', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['module_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module_name' => 'Module Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
