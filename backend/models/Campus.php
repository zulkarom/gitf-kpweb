<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "campus".
 *
 * @property int $id
 * @property string $campus_name
 * @property string $campus_short
 */
class Campus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'campus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['campus_name', 'campus_short'], 'required'],
            [['campus_name'], 'string', 'max' => 100],
            [['campus_short'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'campus_name' => 'Campus Name',
            'campus_short' => 'Campus Short',
        ];
    }
}
