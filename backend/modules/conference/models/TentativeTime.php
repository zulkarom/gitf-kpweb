<?php

namespace backend\modules\conference\models;

use Yii;

/**
 * This is the model class for table "conf_ttf_time".
 *
 * @property int $id
 * @property int $day_id
 * @property string $ttf_time
 * @property string $ttf_item
 * @property string $ttf_location
 * @property int $ttf_order
 *
 * @property ProTtfDay $day
 */
class TentativeTime extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'conf_ttf_time';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ttf_time', 'ttf_item'], 'required'],
			
            [['day_id', 'ttf_order'], 'integer'],
			
            [['ttf_time'], 'safe'],
            [['ttf_item'], 'string', 'max' => 200],
            [['day_id'], 'exist', 'skipOnError' => true, 'targetClass' => TentativeDay::className(), 'targetAttribute' => ['day_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'day_id' => 'Day ID',
            'ttf_time' => 'Time',
            'ttf_item' => 'Activities/Program',
            'ttf_order' => 'Ttf Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDay()
    {
        return $this->hasOne(ProTtfDay::className(), ['id' => 'day_id']);
    }
}
