<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "kursus".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $name2
 * @property int $credit
 */
class Kursus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kursus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['credit'], 'integer'],
            [['code'], 'string', 'max' => 8],
            [['name'], 'string', 'max' => 53],
            [['name2'], 'string', 'max' => 52],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'name2' => 'Name2',
            'credit' => 'Credit',
        ];
    }
}
