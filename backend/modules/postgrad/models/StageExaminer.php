<?php

namespace backend\modules\postgrad\models;

use Yii;

/**
 * This is the model class for table "pg_stage_examiner".
 *
 * @property int $id
 * @property int $examiner_id
 * @property int $stage_id
 * @property string $appoint_date
 */
class StageExaminer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pg_stage_examiner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['examiner_id', 'stage_id'], 'required'],
            [['examiner_id', 'stage_id'], 'integer'],
            [['appoint_date'], 'safe'],
        ];
    }
    
    public function getExaminer(){
        return $this->hasOne(Supervisor::className(), ['id' => 'examiner_id']);
    }
    
    public function getStage(){
         return $this->hasOne(StudentStage::className(), ['id' => 'stage_id']);
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'examiner_id' => 'Examiner',
            'stage_id' => 'Stage',
            'appoint_date' => 'Appoint Date',
        ];
    }
}
