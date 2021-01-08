<?php

namespace backend\modules\courseFiles\models;

use Yii;

/**
 * This is the model class for table "cf_material_item".
 *
 * @property int $id
 * @property int $material_id
 * @property string $item_name
 * @property string $item_file
 * @property int $item_category 1=pp slide, 2=pdf slide, 3=question bank,4=assessment,5=urls, 6=others
 */
class MaterialItem extends \yii\db\ActiveRecord
{
	public $file_controller;
    public $item_instance;
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cf_material_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['material_id', 'item_category'], 'required'],
            [['material_id', 'item_category'], 'integer'],
            [['item_file'], 'string'],
            [['item_name'], 'string', 'max' => 200],
			
			[['item_file'], 'required', 'on' => 'item_upload'],
            [['item_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 2000000],
			
			
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'material_id' => 'Material ID',
            'item_name' => 'Item Name',
            'item_file' => 'Item File',
            'item_category' => 'Item Category',
        ];
    }
	
	public function getMaterial(){
         return $this->hasOne(Material::className(), ['id' => 'material_id']);
    }
	
	
}
