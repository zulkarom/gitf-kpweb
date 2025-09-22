<?php
namespace student\models\forms;

use yii\base\Model;

class SetPasswordForm extends Model
{
    public $password;
    public $password_confirm;

    public function rules()
    {
        return [
            [['password', 'password_confirm'], 'required'],
            [['password'], 'string', 'min' => 6],
            ['password_confirm', 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords do not match.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => 'New Password',
            'password_confirm' => 'Confirm Password',
        ];
    }
}
