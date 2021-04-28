<?php

namespace backend\modules\conference\models;

use Yii;

/**
 * This is the model class for table "conf_ttf_day".
 *
 * @property int $id
 * @property int $conf_id
 * @property string $conf_date
 * @property int $day_order
 *
 * @property Project $conf
 * @property ProTtfTime[] $proTtfTimes
 */
class TentativeDay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'conf_ttf_day';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['conf_date'], 'required'],
			
            [['conf_id', 'day_order'], 'integer'],
			
            [['conf_date'], 'safe'],
			
            [['conf_id'], 'exist', 'skipOnError' => true, 'targetClass' => Conference::className(), 'targetAttribute' => ['conf_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'conf_id' => 'Pro ID',
            'conf_date' => 'Day',
            'day_order' => 'Day Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConference()
    {
        return $this->hasOne(Conference::className(), ['id' => 'conf_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTentativeTimes()
    {
        return $this->hasMany(TentativeTime::className(), ['day_id' => 'id']);
    }
}
