<?php

namespace backend\modules\conference\models;

use Yii;

/**
 * This is the model class for table "confv_adv".
 *
 * @property int $id
 * @property string $adv_icon
 * @property string $adv_title
 * @property string $adv_desc
 */
class ConfvalleyAdvantage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'confv_adv';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['adv_icon', 'adv_title', 'adv_desc'], 'required'],
            [['adv_icon'], 'string', 'max' => 20],
            [['adv_title'], 'string', 'max' => 100],
            [['adv_desc'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'adv_icon' => 'Adv Icon',
            'adv_title' => 'Adv Title',
            'adv_desc' => 'Adv Desc',
        ];
    }
}
