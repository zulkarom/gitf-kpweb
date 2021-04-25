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
		
		if($this->material->mt_type == 1){
			$str_type = 'pdf';
		}else{
			$str_type = 'pdf,doc,docx,ppt,pptx,txt,xls,xlsx,xlsm';
		}
        return [
            [['material_id', 'item_category'], 'required'],
			
			[['item_name'], 'required', 'on' => 'saveall'],
			
			
            [['material_id', 'item_category'], 'integer'],
            [['item_file'], 'string'],
			
            [['item_name'], 'string', 'max' => 200],
			
			[['item_file'], 'required', 'on' => 'item_upload'],
			
            [['item_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => $str_type, 'maxSize' => 5000000],
			
			
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
            'item_name' => 'Document Name',
            'item_file' => 'Item File',
            'item_category' => 'Item Category',
        ];
    }
	
	public function getMaterial(){
         return $this->hasOne(Material::className(), ['id' => 'material_id']);
    }
	
	
}
