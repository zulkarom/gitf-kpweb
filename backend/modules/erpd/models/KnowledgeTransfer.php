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
 * @property string $modified_at
 */
class KnowledgeTransfer extends \yii\db\ActiveRecord
{
	
	public $ktp_instance;
	public $file_controller;
	public $year_start;
	public $year_end;
	
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
			[['ktp_title', 'staff_id', 'date_start', 'date_end', 'ktp_community', 'ktp_source', 'ktp_amount', 'created_at'], 'required', 'on' => 'ktp_entry'],
			
            [['ktp_title', 'staff_id', 'date_start', 'date_end', 'ktp_community', 'ktp_source', 'ktp_amount', 'modified_at'], 'required', 'on' => 'ktp_update'],
			
			[['ktp_file'], 'required', 'on' => 'submit'],
			
            [['staff_id', 'reminder'], 'integer'],
            [['date_start', 'date_end', 'created_at', 'modified_at'], 'safe'],
            [['ktp_amount'], 'number'],
            [['ktp_description'], 'string'],
            [['ktp_title'], 'string', 'max' => 600],
            [['ktp_research', 'ktp_community', 'ktp_source', 'ktp_file'], 'string', 'max' => 200],
			
			[['ktp_file'], 'required', 'on' => 'ktp_upload'],
            [['ktp_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 5000000],
            [['modified_at'], 'required', 'on' => 'ktp_delete'],
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
            'modified_at' => 'Updated At',
        ];
    }
	
	public function getMembers()
    {
        return $this->hasMany(KnowledgeTransferMember::className(), ['ktp_id' => 'id'])->orderBy('ktp_order ASC');
    }
	
	public function stringMembers(){
		$string ="";
		$members = $this->members;
		if($members){
			foreach($members as $member){
				if($member->staff_id == 0){
					$string .= $member->ext_name . '<br />';
				}else{
					$string .= '<span class="glyphicon glyphicon-ok"></span> ' . $member->staff->user->fullname . '<br />';
				}
				
			}
		}
		return $string;
	}
	
	public function statusList(){
		$list = Status::find()->where(['user_show' => 1])->all();
		return ArrayHelper::map($list, 'status_code', 'status_name');
	}
	public function statusListAdmin(){
		$list = Status::find()->where(['admin_show' => 1])->all();
		return ArrayHelper::map($list, 'status_code', 'status_name');
	}
	
	public function getStatusInfo(){
        return $this->hasOne(Status::className(), ['status_code' => 'status']);
    }
	
	public function showStatus(){
		$status = $this->statusInfo;
		return '<span class="label label-'.$status->status_color .'">'.$status->status_name .'</span>';
	}
	
	public function flashError(){
        if($this->getErrors()){
            foreach($this->getErrors() as $error){
                if($error){
                    foreach($error as $e){
                        Yii::$app->session->addFlash('error', $e);
                    }
                }
            }
        }

    }

}
