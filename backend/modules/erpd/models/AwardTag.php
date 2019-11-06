<?php

namespace backend\modules\erpd\models;

use Yii;
use backend\modules\staff\models\Staff;

/**
 * This is the model class for table "rp_award_tag".
 *
 * @property int $id
 * @property int $award_id
 * @property int $staff_id
 */
class AwardTag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rp_award_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['award_id'], 'required'],
            [['award_id', 'staff_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'award_id' => 'Award ID',
            'staff_id' => 'Staff ID',
        ];
    }
	
	public function getStaff(){
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }
}
