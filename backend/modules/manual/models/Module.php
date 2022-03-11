<?php

namespace backend\modules\manual\models;

use Yii;

/**
 * This is the model class for table "mnl_module".
 *
 * @property int $id
 * @property string $module_name
 * @property string $module_route
 */
class Module extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mnl_module';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['module_name', 'module_route'], 'string', 'max' => 255],
            
            ['is_published', 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module_name' => 'Module Name',
            'module_route' => 'Module Route',
        ];
    }
    
    public function getSections(){
         return $this->hasMany(Section::className(), ['module_id' => 'id']);
    }
    
    public function getPublishedSections(){
        return $this->hasMany(Section::className(), ['module_id' => 'id'])->where(['is_published' => 1]);
    }
}
