<?php

namespace backend\modules\staff\models;

use Yii;

/**
 * This is the model class for table "staff_letter_desig".
 *
 * @property int $id
 * @property string $designation_name
 */
class LetterDesignation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'staff_letter_desig';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['designation_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'designation_name' => 'Designation Name',
        ];
    }
}
