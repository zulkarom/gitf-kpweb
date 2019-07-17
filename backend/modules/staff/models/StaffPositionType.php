<?php

namespace backend\modules\staff\models;

use Yii;

/**
 * This is the model class for table "staff_position_type".
 *
 * @property int $pos_id
 * @property string $pos_name_bm
 * @property string $pos_name_bi
 * @property int $pos_order
 */
class StaffPositionType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff_position_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pos_name_bm', 'pos_name_bi', 'pos_order'], 'required'],
            [['pos_order'], 'integer'],
            [['pos_name_bm', 'pos_name_bi'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pos_id' => 'Pos ID',
            'pos_name_bm' => 'Pos Name Bm',
            'pos_name_bi' => 'Pos Name Bi',
            'pos_order' => 'Pos Order',
        ];
    }
}
