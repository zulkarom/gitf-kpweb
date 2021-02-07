<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class DownloadForm extends Model
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
		
			[['matric', 'nric', 'category'], 'required'],
            [['matric', 'nric'], 'trim'],
            [['matric',], 'string', 'max' => 15],
			[['nric'], 'string'],
        ];
    }
	
	public function attributeLabels()
    {
        return [
			'matric' => 'Matric Number',
            'nric' => 'NRIC',
			'category' => 'Category',
        ];
    }

}
