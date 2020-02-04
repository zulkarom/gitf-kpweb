<?php

namespace backend\modules\teachingLoad\models;

use Yii;

/**
 * This is the model class for table "tld_past_expe".
 *
 * @property int $id
 * @property int $staff_id
 * @property string $employer
 * @property string $position
 * @property string $start_end
 */
class PastExperience extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tld_past_expe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employer', 'position', 'start_end'], 'required'],
            [['staff_id'], 'integer'],
            [['employer'], 'string', 'max' => 200],
            [['position', 'start_end'], 'string', 'max' => 100],
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
            'employer' => 'Employer',
            'position' => 'Position',
            'start_end' => 'Start End',
        ];
    }
}
