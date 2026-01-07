<?php

namespace backend\modules\postgrad\models;

use Yii;

/**
 * This is the model class for table "pg_stage_examiner".
 *
 * @property int $id
 * @property int $examiner_id
 * @property int $stage_id
 * @property int $committee_role
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
            [['examiner_id', 'stage_id', 'committee_role'], 'integer'],
            [['committee_role'], 'required'],
            [['committee_role'], 'in', 'range' => array_keys(self::committeeRoleList())],
            [['appoint_date'], 'safe'],
        ];
    }

    public static function committeeRoleList()
    {
        return [
            1 => 'Pengerusi',
            2 => 'Penolong Pengerusi',
            3 => 'Pemeriksa 1',
            4 => 'Pemeriksa 2',
        ];
    }

    public function getCommitteeRoleLabel()
    {
        $list = self::committeeRoleList();
        return isset($list[$this->committee_role]) ? $list[$this->committee_role] : null;
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
            'committee_role' => 'Committee Role',
            'appoint_date' => 'Appoint Date',
        ];
    }
}
