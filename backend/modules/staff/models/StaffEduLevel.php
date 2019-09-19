<?php

namespace backend\modules\staff\models;

use Yii;

/**
 * This is the model class for table "staff_edu_level".
 *
 * @property int $id
 * @property string $level_name
 */
class StaffEduLevel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'staff_edu_level';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level_name'], 'required'],
            [['level_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level_name' => 'Level Name',
        ];
    }
}
