<?php

namespace tu2i\models;

use Yii;
use yii\base\Model;
use common\models\User;
use backend\models\Answer;
/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $fullname;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            [['username', 'fullname'], 'required', 'on' => 'register'],
          //  ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['fullname', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            // ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
          //  ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            // ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup($batch)
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $find = User::findOne(['username' => $this->username]);
        if($find){
            $user = $find;
            
        }else{
            $user->username = $this->username;
            $user->can_name = $this->fullname;
            $user->status = 10;
            $user->generateAuthKey();
        }
        $user->updated_at = time();

        if($user->save()){
            $ans = Answer::findOne(['bat_id' => $batch, 'can_id' => $user->id]);
            if($ans){
                $modelAnswer = $ans;
            }else{
                $modelAnswer = new Answer();
                $modelAnswer->can_id = $user->id;
                $modelAnswer->bat_id = $batch;
                for($i=1;$i<=120;$i++){
                    $q = 'q'.$i;
                    $modelAnswer->$q = '-1';
                }
                $modelAnswer->save();
            }
            
        }
        return true;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
