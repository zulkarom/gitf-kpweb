<?php

namespace backend\modules\erpd\models;

use Yii;
use backend\modules\staff\models\Staff;

/**
 * This is the model class for table "pub_tag".
 *
 * @property int $tag_id
 * @property int $pub_id
 * @property int $staff_id
 */
class PubTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rp_pub_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pub_id'], 'required'],
            [['pub_id', 'staff_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tag_id' => 'Tag ID',
            'pub_id' => 'Pub ID',
            'staff_id' => 'Staff ID',
        ];
    }
	
	public function getStaff(){
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }

}
