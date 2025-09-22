<?php
namespace student\models\forms;

use yii\base\Model;

class ForgotPasswordRequestForm extends Model
{
    public $matric_no;
    public $nric;

    public function rules()
    {
        return [
            [['matric_no', 'nric'], 'required'],
            [['matric_no', 'nric'], 'trim'],
            [['matric_no'], 'string', 'max' => 20],
            [['nric'], 'string', 'max' => 20],
        ];
    }

    public function attributeLabels()
    {
        return [
            'matric_no' => 'Matric Number',
            'nric' => 'I.C Number',
        ];
    }
}
