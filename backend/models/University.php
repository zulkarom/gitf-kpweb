<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "university".
 *
 * @property int $id
 * @property string $uni_name
 * @property string $uni_name_en
 * @property string $uni_abbr
 * @property string $type
 * @property string $thrust
 * @property string $main_location
 */
class University extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'university';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uni_name', 'uni_name_en'], 'string', 'max' => 200],
            [['uni_abbr'], 'string', 'max' => 50],
            [['type'], 'string', 'max' => 10],
            [['thrust', 'main_location'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uni_name' => 'Uni Name',
            'uni_name_en' => 'Uni Name En',
            'uni_abbr' => 'Uni Abbr',
            'type' => 'Type',
            'thrust' => 'Thrust',
            'main_location' => 'Main Location',
        ];
    }
}
