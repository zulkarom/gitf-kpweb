<?php
namespace backend\modules\ecert\models;

/**
 * This is the model class for table "cert_event_type".
 *
 * @property int $id
 * @property int $event_id
 * @property string $type_name
 * @property double $field1_mt
 * @property double $field1_size
 * @property double $field2_mt
 * @property double $field2_size
 * @property double $field3_mt
 * @property double $field3_size
 * @property double $field4_mt
 * @property double $field4_size
 * @property double $field5_mt
 * @property double $field5_size
 * @property double $margin_right
 * @property double $margin_left
 * @property int $set_type 1=preset,2=custom_html
 * @property string $custom_html
 *
 * @property CertEvent $event
 */
class EventType extends \yii\db\ActiveRecord
{

    /**
     *
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cert_event_type';
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
                    'event_id',
                    'type_name'
                ],
                'required'
            ],
            [
                [
                    'event_id',
                    'set_type'
                ],
                'integer'
            ],
            [
                [
                    'field1_mt',
                    'field1_size',
                    'field2_mt',
                    'field2_size',
                    'field3_mt',
                    'field3_size',
                    'field4_mt',
                    'field4_size',
                    'field5_mt',
                    'field5_size',
                    'margin_right',
                    'margin_left'
                ],
                'number'
            ],
            [
                [
                    'custom_html'
                ],
                'string'
            ],
            [
                [
                    'type_name'
                ],
                'string',
                'max' => 100
            ],
            [
                [
                    'event_id'
                ],
                'exist',
                'skipOnError' => true,
                'targetClass' => Event::className(),
                'targetAttribute' => [
                    'event_id' => 'id'
                ]
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
            'event_id' => 'Event ID',
            'type_name' => 'Type Name',
            'field1_mt' => 'Field1 Mt',
            'field1_size' => 'Field1 Size',
            'field2_mt' => 'Field2 Mt',
            'field2_size' => 'Field2 Size',
            'field3_mt' => 'Field3 Mt',
            'field3_size' => 'Field3 Size',
            'field4_mt' => 'Field4 Mt',
            'field4_size' => 'Field4 Size',
            'field5_mt' => 'Field5 Mt',
            'field5_size' => 'Field5 Size',
            'margin_right' => 'Margin Right',
            'margin_left' => 'Margin Left',
            'set_type' => 'Set Type',
            'custom_html' => 'Custom Html'
        ];
    }

    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), [
            'id' => 'event_id'
        ]);
    }
}
