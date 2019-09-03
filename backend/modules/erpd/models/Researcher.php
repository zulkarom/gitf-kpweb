<?php

namespace backend\modules\erpd\models;

use Yii;
use backend\modules\staff\models\Staff;

/**
 * This is the model class for table "researchers".
 *
 * @property int $id
 * @property int $res_id
 * @property int $staff_id
 * @property string $ext_name
 */
class Researcher extends \yii\db\ActiveRecord
{
	
	public $is_staff;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rp_researcher';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_staff'], 'required'],
			
            [['res_id', 'staff_id'], 'integer'],
			
            [['ext_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Resr ID',
            'res_id' => 'Res ID',
            'staff_id' => 'Staff',
            'ext_name' => 'External Researcher',
        ];
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
	
	public function getStaff(){
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }


}
