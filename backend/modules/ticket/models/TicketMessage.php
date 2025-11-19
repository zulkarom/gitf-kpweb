<?php

namespace backend\modules\ticket\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\models\User;

class TicketMessage extends ActiveRecord
{
    public static function tableName()
    {
        return 'ticket_message';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
                'value' => function () {
                    return time();
                },
            ],
        ];
    }

    public function rules()
    {
        return [
            [['ticket_id', 'user_id', 'message'], 'required'],
            [['ticket_id', 'user_id', 'created_at'], 'integer'],
            [['message'], 'string'],
            [['is_internal'], 'boolean'],
            ['is_internal', 'default', 'value' => 0],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ticket_id' => 'Ticket',
            'user_id' => 'User',
            'message' => 'Message',
            'is_internal' => 'Internal Note',
            'created_at' => 'Created At',
        ];
    }

    public function getTicket()
    {
        return $this->hasOne(Ticket::class, ['id' => 'ticket_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}

