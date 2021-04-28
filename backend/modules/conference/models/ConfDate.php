<?php

namespace backend\modules\conference\models;

use Yii;

/**
 * This is the model class for table "conf_date".
 *
 * @property int $id
 * @property int $conf_id
 * @property int $date_id
 * @property string $date_start
 * @property string $date_end
 * @property int $published
 *
 * @property Conference $conf
 */
class ConfDate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conf_date';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_id', 'date_start'], 'required'],
			
            [['conf_id', 'published', 'date_order', 'date_id'], 'integer'],
			
            [['date_start', 'date_end'], 'safe'],
			
			
            [['conf_id'], 'exist', 'skipOnError' => true, 'targetClass' => Conference::className(), 'targetAttribute' => ['conf_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'conf_id' => 'Conf ID',
            'date_id' => 'Date Name',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'published' => 'Published',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConference()
    {
        return $this->hasOne(Conference::className(), ['id' => 'conf_id']);
    }
	
	public function getDateName()
    {
        return $this->hasOne(ConfDateName::className(), ['id' => 'date_id']);
    }
	
}
