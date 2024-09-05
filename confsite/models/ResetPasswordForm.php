<?php
namespace confsite\models;

use yii\base\Model;
use yii\base\InvalidParamException;
use common\models\User;
use InvalidArgumentException;
use PHPUnit\Util\InvalidArgumentHelper;
use Yii;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;

    /**
     * @var \common\models\User
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Password reset token cannot be blank.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidArgumentException('Wrong password reset token.');
        }
        $this->verifyEmailIfNot();
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    private function verifyEmailIfNot()
    {
        $user = $this->_user;
        if($user->status == 9){
            $user->status = User::STATUS_ACTIVE;
            $user->confirmed_at = time();
            if($user->save(false)){
                Yii::$app->session->setFlash('success', 'Your email has been verified. If you come to this page for email verification, you can skip password reset.');
                return true;
            }
        }

        return true;
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}
