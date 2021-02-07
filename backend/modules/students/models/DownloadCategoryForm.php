<?php
namespace backend\modules\students\models;

use Yii;
use yii\base\Model;

/**
 * Offer Letter form
 * to create reference to offer letter
 */
class DownloadCategoryForm extends Model
{
	
    public $category_id;
	public $str_search;
	public $action;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['category_id'], 'integer'],
			[['str_search'], 'string'],
        ];
    }
	
	/**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Select Category',
        ];
    }
	
	public function getDownloadCategory(){
		return DownloadCategory::findOne($this->category_id);
	}

}
