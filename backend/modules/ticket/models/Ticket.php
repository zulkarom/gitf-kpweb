<?php

namespace backend\modules\ticket\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use common\models\User;

class Ticket extends ActiveRecord
{
    public static function tableName()
    {
        return 'ticket';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => function () {
                    return time();
                },
            ],
        ];
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['category_id', 'priority', 'status', 'created_by', 'assigned_to', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Message',
            'category_id' => 'Category',
            'priority' => 'Priority',
            'status' => 'Status',
            'created_by' => 'Created By',
            'assigned_to' => 'Assigned To',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(TicketCategory::class, ['id' => 'category_id']);
    }

    public function getCreator()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    public function getAssignee()
    {
        return $this->hasOne(User::class, ['id' => 'assigned_to']);
    }

    public function getMessages()
    {
        return $this->hasMany(TicketMessage::class, ['ticket_id' => 'id'])->orderBy(['created_at' => SORT_ASC]);
    }

    public static function getStatusList()
    {
        return [
            0 => 'New',
            1 => 'Open',
            2 => 'In Progress',
            3 => 'Awaiting User',
            4 => 'Resolved',
            5 => 'Closed',
        ];
    }

    public static function getUserStatusList()
    {
        return [
            1 => 'Open',
            4 => 'Resolved',
        ];
    }

    public static function getPriorityList()
    {
        return [
            1 => 'Low',
            2 => 'Normal',
            3 => 'High',
            4 => 'Urgent',
        ];
    }

    public function getStatusLabel()
    {
        $items = static::getStatusList();
        $label = isset($items[$this->status]) ? $items[$this->status] : (string)$this->status;

        switch ((int)$this->status) {
            case 0:
                $class = 'label-default';
                break;
            case 1:
                $class = 'label-primary';
                break;
            case 2:
                $class = 'label-warning';
                break;
            case 3:
                $class = 'label-info';
                break;
            case 4:
                $class = 'label-success';
                break;
            case 5:
                $class = 'label-default';
                break;
            default:
                $class = 'label-default';
        }

        return '<span class="label ' . $class . '">' . $label . '</span>';
    }

    public function getPriorityLabel()
    {
        $items = static::getPriorityList();
        $label = isset($items[$this->priority]) ? $items[$this->priority] : (string)$this->priority;

        switch ((int)$this->priority) {
            case 1:
                $class = 'label-success';
                break;
            case 2:
                $class = 'label-info';
                break;
            case 3:
                $class = 'label-warning';
                break;
            case 4:
                $class = 'label-danger';
                break;
            default:
                $class = 'label-default';
        }

        return '<span class="label ' . $class . '">' . $label . '</span>';
    }
}

