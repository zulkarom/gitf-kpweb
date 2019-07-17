<?php

namespace backend\modules\erpd\models;

use Yii;

/**
 * This is the model class for table "research".
 *
 * @property int $id
 * @property string $res_title
 * @property int $res_leader
 * @property int $res_status 1=finish,0 = ongoing
 * @property string $date_start
 * @property string $date_end
 * @property int $res_grant
 * @property string $res_grant_others
 * @property string $res_source
 * @property string $res_amount
 * @property string $res_file
 * @property string $modified_at
 * @property string $created_at
 * @property int $reminder
 */
class Research extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rp_research';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['res_title', 'res_staff', 'res_progress', 'date_start', 'date_end', 'res_grant', 'res_source', 'res_amount', 'created_at'], 'required', 'on' => 'res_entry'],
			
            [['res_staff', 'res_progress', 'res_grant', 'reminder', 'status'], 'integer'],
			
            [['date_start', 'date_end', 'modified_at', 'created_at'], 'safe'],
            [['res_amount'], 'number'],
			
            [['res_title'], 'string', 'max' => 600],
			
            [['res_grant_others', 'res_source', 'res_file'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Res ID',
            'res_title' => 'Research Title',
            'res_staff' => 'Res Staff',
            'res_progress' => 'Status',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'res_grant' => 'Research Grant',
            'res_grant_others' => 'Others',
            'res_source' => 'Resource/ Sponsorship',
            'res_amount' => 'Amount',
            'res_file' => 'Research File',
            'modified_at' => 'Modified At',
            'created_at' => 'Created At',
            'reminder' => 'Reminder',
        ];
    }
	
	public function getResearchers()
    {
        return $this->hasMany(Researcher::className(), ['res_id' => 'id']);
    }

}
