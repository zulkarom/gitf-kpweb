<?php

namespace backend\modules\erpd\models;

use Yii;

/**
 * This is the model class for table "rp_status".
 *
 * @property int $id
 * @property int $status_code
 * @property string $status_name
 * @property string $status_color
 * @property int $admin_show
 * @property int $user_show
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rp_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_code', 'status_name', 'status_color', 'admin_show', 'user_show'], 'required'],
            [['status_code', 'admin_show', 'user_show'], 'integer'],
            [['status_name', 'status_color'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_code' => 'Status Code',
            'status_name' => 'Status Name',
            'status_color' => 'Status Color',
            'admin_show' => 'Admin Show',
            'user_show' => 'User Show',
        ];
    }
}
