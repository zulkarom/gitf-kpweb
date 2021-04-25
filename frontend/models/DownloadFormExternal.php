<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class DownloadFormExternal extends Model
{
	public $category;
    public $matric;
	public $nric;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
		
			[['nric', 'category'], 'required'],
            [['nric'], 'trim'],
			[['nric'], 'string'],
        ];
    }
	
	public function attributeLabels()
    {
        return [
            'nric' => 'NRIC',
			'category' => 'Category',
        ];
    }

}
