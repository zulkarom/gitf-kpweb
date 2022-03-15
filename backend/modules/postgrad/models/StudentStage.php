<?php

namespace backend\modules\postgrad\models;

use Yii;

/**
 * This is the model class for table "pd_student_stage".
 *
 * @property int $id
 * @property int $student_id
 * @property int $stage_id
 * @property string $stage_date
 * @property int $status
 */
class StudentStage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pd_student_stage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'stage_id'], 'required'],
            [['student_id', 'stage_id', 'status'], 'integer'],
            [['stage_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_id' => 'Student ID',
            'stage_id' => 'Stage ID',
            'stage_date' => 'Stage Date',
            'status' => 'Status',
        ];
    }
    
    public function statusList(){
        return [
            10 => 'Applied',
            70 => 'Failed',
            80 => 'Passed with Major Correction',
            90 => 'Passed with Minor Correction',
            100 => 'Passed without Correction'
        ];
    }
}
