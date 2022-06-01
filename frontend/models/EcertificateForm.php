<?php
namespace frontend\models;

use backend\modules\ecert\models\Event;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Signup form
 */
class EcertificateForm extends Model
{

    public $event;

    public $identifier;

    /**
     *
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [
                [
                    'event',
                    'identifier'
                ],
                'required'
            ],
            [
                [
                    'identifier'
                ],
                'trim'
            ],
            [
                [
                    'identifier'
                ],
                'string',
                'max' => 15
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'identifier' => 'Student/Staff Number/ I.c',
            'event' => 'Select an event'
        ];
    }

    public function listEvents()
    {
        $list = Event::find()->all();
        return ArrayHelper::map($list, 'id', 'event_name');
    }
}
