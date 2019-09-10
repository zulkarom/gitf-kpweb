<?php

namespace backend\modules\erpd\models;

use Yii;
use backend\modules\staff\models\Staff;

/**
 * This is the model class for table "rp_knowledge_transfer_member".
 *
 * @property int $id
 * @property int $ktp_id
 * @property int $staff_id
 * @property string $ext_name
 */
class KnowledgeTransferMember extends \yii\db\ActiveRecord
{
	public $is_staff;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rp_knowledge_transfer_member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_staff'], 'required'],
            [['ktp_id', 'staff_id'], 'integer'],
            [['ext_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ktp_id' => 'Ktp ID',
            'staff_id' => 'Staff ID',
            'ext_name' => 'Ext Name',
        ];
    }
	
	public function getStaff(){
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
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
