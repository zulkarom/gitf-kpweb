<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class DeanListForm extends Model
{
	public $semester;
    public $matric;
	public $nric;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
		
			[['matric', 'nric', 'semester'], 'required'],
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
        ];
    }

}
