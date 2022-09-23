<?php
namespace backend\modules\user\models;

use Yii;
use common\models\User;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        $user = $this->findUser();

        if (!$user) {
            return false;
        }
        
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }


        $email = urlencode($this->email);
        $from = urlencode($user->email);
        $code = $user->password_reset_token;
        $secret = "3r23047dw3";
        $key = md5($code.$secret);
        $url = "https://api-mailer.skyhint.com/fkp/recover/" . $email . "/" . $from .  "/" . $code . "/" . $key;
        try {
			if(file_get_contents($url) == 'true'){
                return true;
            }else{
                return false;
            }
		}
		catch (\Exception $e) {
			return false;
		}

        /* return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->params['senderName']]) 
            ->setTo($this->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send(); */
    }

    /**
     *
     * @return \common\models\User|null
     */
    protected function findUser()
    {
        return User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);
    }
}
