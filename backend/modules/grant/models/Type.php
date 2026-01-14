<?php

namespace backend\modules\grant\models;

use yii\db\ActiveRecord;
use backend\modules\grant\models\Grant;

class Type extends ActiveRecord
{
    public static function tableName()
    {
        return 'grn_type';
    }

    public function rules()
    {
        return [
            [['type_name'], 'required'],
            [['type_name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_name' => 'Type Name',
        ];
    }

    public function getGrants()
    {
        return $this->hasMany(Grant::class, ['type_id' => 'id']);
    }
}
