<?php
namespace backend\modules\publicForm\models;

use yii\base\Model;

/**
 * Signup form
 */
class TeachForm extends Model
{
    public $staffno;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
		
			['staffno', 'required'],
			
        ];
    }
	
	public function attributeLabels()
    {
        return [
			'staffno' => 'STAFF NO.',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
      
    }
}
