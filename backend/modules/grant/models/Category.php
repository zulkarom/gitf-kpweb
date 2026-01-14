<?php

namespace backend\modules\grant\models;

use yii\db\ActiveRecord;
use backend\modules\grant\models\Grant;

class Category extends ActiveRecord
{
    public static function tableName()
    {
        return 'grn_category';
    }

    public function rules()
    {
        return [
            [['category_name'], 'required'],
            [['category_name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_name' => 'Category Name',
        ];
    }

    public function getGrants()
    {
        return $this->hasMany(Grant::class, ['category_id' => 'id']);
    }
}
