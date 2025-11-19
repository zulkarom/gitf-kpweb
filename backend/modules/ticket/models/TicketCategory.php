<?php

namespace backend\modules\ticket\models;

use yii\db\ActiveRecord;

class TicketCategory extends ActiveRecord
{
    public static function tableName()
    {
        return 'ticket_category';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['sort_order'], 'integer'],
            [['is_active'], 'boolean'],
            [['name'], 'string', 'max' => 100],
            [['code'], 'string', 'max' => 50],
            [['is_active'], 'default', 'value' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'sort_order' => 'Sort Order',
            'is_active' => 'Active',
        ];
    }
}

