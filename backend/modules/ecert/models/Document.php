<?php

namespace backend\modules\ecert\models;

use Yii;

/**
 * This is the model class for table "cert_doc".
 *
 * @property int $id
 * @property int $participant_id
 * @property string $participant_name
 * @property string $field1
 * @property string $field2
 * @property string $field3
 * @property string $field4
 * @property string $field5
 * @property int $downloaded
 *
 * @property CertParticipant $participant
 */
class Document extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cert_doc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['participant_id', 'participant_name', 'field1', 'field2', 'field3', 'field4', 'field5', 'downloaded'], 'required'],
            [['participant_id', 'downloaded'], 'integer'],
            [['participant_name', 'field1', 'field2', 'field3', 'field4', 'field5'], 'string', 'max' => 225],
            [['participant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Participant::className(), 'targetAttribute' => ['participant_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'participant_id' => 'Participant ID',
            'participant_name' => 'Participant Name',
            'field1' => 'Field1',
            'field2' => 'Field2',
            'field3' => 'Field3',
            'field4' => 'Field4',
            'field5' => 'Field5',
            'downloaded' => 'Downloaded',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipant()
    {
        return $this->hasOne(Participant::className(), ['id' => 'participant_id']);
    }
}
