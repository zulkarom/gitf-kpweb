<?php
namespace student\models\forms;

use yii\base\Model;

class ForgotPasswordRequestForm extends Model
{
    public $matric_no;

    public function rules()
    {
        return [
            [['matric_no'], 'required'],
            [['matric_no'], 'trim'],
            [['matric_no'], 'filter', 'filter' => function ($value) {
                return strtoupper((string)$value);
            }],
            [['matric_no'], 'string', 'max' => 20],
            [['matric_no'], 'match', 'pattern' => '/^[A-Z]\d{2}[A-Z0-9].*$/', 'message' => 'Please enter a valid matric number.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'matric_no' => 'Matric Number',
        ];
    }
}
