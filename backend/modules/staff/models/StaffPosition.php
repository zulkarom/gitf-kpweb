<?php

namespace backend\modules\staff\models;

use Yii;

/**
 * This is the model class for table "staff_position".
 *
 * @property int $position_id
 * @property string $position_name
 * @property string $position_gred
 * @property string $position_order
 */
class StaffPosition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff_position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['position_order'], 'required'],
            [['position_order'], 'number'],
            [['position_name'], 'string', 'max' => 46],
            [['position_gred'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Position ID',
            'position_name' => 'Position Name',
            'position_gred' => 'Position Gred',
            'position_order' => 'Position Order',
        ];
    }
	
	public static function positionList(){
		$array = [];
		$list = self::find()->where(['>', 'id', 0])->all();
		foreach($list as $row){
			$array[$row->id] = $row->position_name . ' ' . $row->position_gred;
		}
		return $array;
	}
}
