<?php

namespace backend\modules\erpd\models;

use Yii;

/**
 * This is the model class for table "rp_knowledge_transfer".
 *
 * @property int $id
 * @property string $ktp_title
 * @property int $staff_id
 * @property string $date_start
 * @property string $date_end
 * @property string $ktp_research
 * @property string $ktp_community
 * @property string $ktp_source
 * @property string $ktp_amount
 * @property string $ktp_description
 * @property string $ktp_file
 * @property int $reminder
 * @property string $created_at
 * @property string $updated_at
 */
class KnowledgeTransfer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rp_knowledge_transfer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ktp_title', 'staff_id', 'date_start', 'date_end', 'ktp_research', 'ktp_community', 'ktp_source', 'ktp_amount', 'created_at', 'updated_at'], 'required'],
			
			
            [['staff_id', 'reminder'], 'integer'],
            [['date_start', 'date_end', 'created_at', 'updated_at'], 'safe'],
            [['ktp_amount'], 'number'],
            [['ktp_description'], 'string'],
            [['ktp_title'], 'string', 'max' => 600],
            [['ktp_research', 'ktp_community', 'ktp_source', 'ktp_file'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ktp_title' => 'Project Name',
            'staff_id' => 'Staff ID',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'ktp_research' => 'Related Research',
            'ktp_community' => 'Knowledge Transfer Community',
            'ktp_source' => 'Organizer/ Sponsor/ Funder / Collaborator	',
            'ktp_amount' => 'Amount',
            'ktp_description' => 'Description',
            'ktp_file' => 'Knowledge Transfer PDF File',
            'reminder' => 'Reminder',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
