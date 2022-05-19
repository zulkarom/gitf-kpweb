<?php
namespace backend\modules\ecert\models;

/**
 * This is the model class for table "cert_doc".
 *
 * @property int $id
 * @property int $identifier
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
     *
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cert_doc';
    }

    /**
     *
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'identifier',
                    'participant_name'
                ],
                'required'
            ],
            [
                [

                    'downloaded'
                ],
                'integer'
            ],
            [
                [
                    'identifier',
                    'participant_name',
                    'field1',
                    'field2',
                    'field3',
                    'field4',
                    'field5'
                ],
                'string',
                'max' => 225
            ]
        ];
    }

    /**
     *
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'identifier' => 'Identifier',
            'participant_name' => 'Participant Name',
            'field1' => 'Field 1',
            'field2' => 'Field 2',
            'field3' => 'Field 3',
            'field4' => 'Field 4',
            'field5' => 'Field 5',
            'downloaded' => 'Downloaded'
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEventType()
    {
        return $this->hasOne(EventType::className(), [
            'id' => 'type_id'
        ]);
    }
}
