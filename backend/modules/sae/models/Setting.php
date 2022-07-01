<?php

namespace backend\modules\sae\models;

use Yii;

/**
 * This is the model class for table "psy_setting".
 *
 * @property int $id
 * @property string $setting_item
 * @property int $setting_num
 * @property string $setting_text
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'psy_setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['setting_item', 'setting_num', 'setting_text'], 'required'],
            [['setting_num'], 'integer'],
            [['setting_item', 'setting_text'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'setting_item' => 'Setting Item',
            'setting_num' => 'Setting Num',
            'setting_text' => 'Setting Text',
        ];
    }
}
