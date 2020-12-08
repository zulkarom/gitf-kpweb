<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;
use common\models\Fasi;

/**
 * Signup form
 */
class InternshipForm extends Model
{
    public $matric;
	public $nric;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
		
			[['matric', 'nric'], 'required'],
			
            [['matric', 'nric'], 'trim'],
            [['matric',], 'string', 'max' => 15],
			[['nric'], 'number'],
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
