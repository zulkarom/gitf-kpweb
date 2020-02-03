<?php

namespace backend\modules\erpd\models;

use Yii;
use backend\modules\staff\models\Staff;

/**
 * This is the model class for table "rp_consultation_tag".
 *
 * @property int $id
 * @property int $staff_id
 * @property int $consult_id
 */
class ConsultationTag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rp_consultation_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['consult_id'], 'required'],
            [['staff_id', 'consult_id'], 'integer'],
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
            'consult_id' => 'Consult ID',
        ];
    }
	
	public function getStaff(){
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }
}
