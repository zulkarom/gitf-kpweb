<?php

namespace backend\modules\downloads\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "st_download_cat".
 *
 * @property int $id
 * @property string $category_name
 * @property int $is_default
 * @property string $description
 * @property int $created_by
 * @property string $created_at
 */
class DownloadCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dwd_download_cat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_name', 'is_default', 'is_active', 'created_by', 'created_at'], 'required'],
            [['is_default', 'created_by'], 'integer'],
            [['description'], 'string'],
            [['created_at'], 'safe'],
            [['category_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Category ID',
            'category_name' => 'Category Name',
            'is_default' => 'Default',
			'is_active' => 'Active',
			'showDefault' => 'Default',
			'showActive' => 'Active',
            'description' => 'Description',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
        ];
    }
	
	public function getShowDefault(){
		if($this->is_default == 1){
			return 'Yes';
		}else{
			return 'No';
		}
	}
	
	public function getShowActive(){
		if($this->is_active == 1){
			return 'Yes';
		}else{
			return 'No';
		}
	}
	
	public static function activeCategories(){
		return ArrayHelper::map(self::find()->where(['is_active' => 1])->all(), 'id', 'category_name');
	}
	
	public static function getDefaultCategory(){
		return self::findOne(['is_default' => 1]);
	}
}
