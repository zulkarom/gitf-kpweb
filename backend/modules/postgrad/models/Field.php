<?php

namespace backend\modules\postgrad\models;

use Yii;

/**
 * This is the model class for table "pg_field".
 *
 * @property int $id
 * @property string $field_name
 */
class Field extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pg_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field_name'], 'required'],
            [['field_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'field_name' => 'Field Name',
        ];
    }
}
