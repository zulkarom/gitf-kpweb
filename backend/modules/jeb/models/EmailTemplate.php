<?php

namespace backend\modules\jeb\models;

use Yii;
use common\models\AuthItem;

/**
 * This is the model class for table "jeb_email_template".
 *
 * @property int $id
 * @property string $on_enter_workflow
 * @property string $notification
 * @property string $reminder
 * @property string $updated_at
 */
class EmailTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jeb_email_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['on_enter_workflow', 'notification', 'notification_subject', 'do_reminder', 'reminder', 'reminder_subject', 'updated_at', 'description', 'target_role'], 'required'],
			
            [['notification', 'reminder', 'description'], 'string'],
            [['updated_at'], 'safe'],
            [['on_enter_workflow'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'on_enter_workflow' => 'On Enter Workflow',
            'notification' => 'Notification',
            'reminder' => 'Reminder',
            'updated_at' => 'Updated At',
        ];
    }
	
	public function showRole(){
		$roles = json_decode($this->target_role);
		$array = array();
		if($roles){
			foreach($roles as $role){
				$item = AuthItem::findOne(['name' => $role]);
				$array[] = $item->description;
			}
		}
		return $array;
	}
	
	public function showRoleString(){
		$roles = $this->showRole();
		$string = '';
		if($roles){
			foreach($roles as $role){
				$string .= $role;
				$string .= '<br />';
			}
		}
		return $string;
	}
}
