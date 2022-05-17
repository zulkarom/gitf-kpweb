<?php

namespace backend\modules\ecert\models;

use Yii;

/**
 * This is the model class for table "cert_event".
 *
 * @property int $id
 * @property string $event_name
 *
 * @property CertParticipant[] $certParticipants
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cert_event';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_name'], 'required'],
            [['event_name'], 'string', 'max' => 225],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_name' => 'Event Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipants()
    {
        return $this->hasMany(Participant::className(), ['event_id' => 'id']);
    }
}
