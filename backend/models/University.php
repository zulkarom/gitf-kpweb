<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

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
            'uni_name' => 'Institution Name',
            'uni_name_en' => 'Institution Name (En)',
            'uni_abbr' => 'Abbr',
            'type' => 'Type',
            'thrust' => 'Thrust',
            'main_location' => 'Main Location',
        ];
    }
    
    public static function listUniversityArray(){
        $list = self::find()->all();
        return ArrayHelper::map($list, 'id', 'uni_name');
    }
}
