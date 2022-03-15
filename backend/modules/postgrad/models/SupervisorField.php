<?php

namespace backend\modules\postgrad\models;

use Yii;

/**
 * This is the model class for table "pg_sv_field".
 *
 * @property int $id
 * @property int $sv_id
 * @property int $field_id
 */
class SupervisorField extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pg_sv_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sv_id', 'field_id'], 'required'],
            [['sv_id', 'field_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sv_id' => 'Sv ID',
            'field_id' => 'Field ID',
        ];
    }
}
