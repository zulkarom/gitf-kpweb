<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use backend\modules\staff\models\Staff;
use backend\modules\teachingLoad\models\Staff as StaffTeaching;
use backend\modules\conference\models\Associate;
use backend\modules\jeb\models\UserScope;


/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
	
	
	public $rawPassword;
	public $password_repeat;
	public $oldPassword;
	public $newPassword;
	public $upload_image;
	
	public $user_fields;
	public $user_roles;
	
	public $institution;
	public $country;
	

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
			
			[['username', 'password', 'rawPassword', 'password_repeat', 'fullname', 'email'], 'required', 'on' => 'create'],
			
			[['email'], 'required', 'on' => 'checkemail'],
			[['email', 'fullname', 'country', 'institution'], 'required', 'on' => 'create_external'],
			
			[['email', 'fullname'], 'required', 'on' => 'update_external'],
			
			[['email', 'fullname', 'password_hash', 'status', 'confirmed_at', 'created_at','updated_at'], 'required', 'on' => 'staff_create'],
			
			//[['username', 'password_hash', 'email', 'created_at', 'updated_at', 'status', 'block_at', 'confirmed_at', 'last_login_at'], 'required', 'on' => 'reload'],
			
			[['updated_at'], 'required', 'on' => 'reload'],
			
			
			[['user_fields', 'user_roles'], 'safe'],
			
			[['username', 'fullname', 'email'], 'required', 'on' => 'update'],
			
			[['upload_image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
			
			[['oldPassword', 'rawPassword', 'password_repeat'], 'required', 'on' => 'password'],
			
			['email', 'email'],
			
			//['username', 'match', 'pattern' => '/^(?=.{4})(?!.{21})[\w.-]*[a-z][\w-.]*$/i'],
			
			['password_repeat', 'compare', 'compareAttribute' => 'rawPassword', 'on' => 'create'],
			
			['password_repeat', 'compare', 'compareAttribute' => 'newPassword', 'on' => 'password' ],
			
			
			['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken'],
			
			['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email has already been taken'],
			
			[['username'], 'string', 'max' => 32],
			[['user_image'], 'string', 'max' => 200],
            [['rawPassword'], 'string', 'min' => 6],
			[['username'], 'string', 'min' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
	
	public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
	
	public function getPassword()
    {
		//return '';
        return $this->password_hash;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
	
	public function getStaff(){
		return $this->hasOne(Staff::className(), ['user_id' => 'id']);
	}
	
	public function getStaffTeaching(){
		return $this->hasOne(StaffTeaching::className(), ['user_id' => 'id']);
	}
	
	
	public function getAssociate(){
		return $this->hasOne(Associate::className(), ['user_id' => 'id']);
	}
	
	public function getUserScopes()
    {
        return $this->hasMany(UserScope::className(), ['user_id' => 'id']);
    }
	
	public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['user_id' => 'id']);
    }
	
	public function getJebAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['user_id' => 'id'])->where(['like', 'item_name', 'jeb-']);
    }

	public function flashError(){
		if($this->getErrors()){
			foreach($this->getErrors() as $error){
				if($error){
					foreach($error as $e){
						Yii::$app->session->addFlash('error', $e);
					}
				}
			}
		}
	}
	
	public static function listFullnameArray(){
		$users = self::find()
		->joinWith('staff')
		->where(['staff.staff_active' => 1])
		->orderBy('fullname ASC')
		->all();
		$array = [];
		foreach($users as $user){
			$array[$user->id] = ucwords(strtolower($user->fullname));
		}
		
		return $array;
	}
	
	public function isEmailExist(){
		if(self::findOne(['email' => $this->email])){
			return true;
		}else{
			return false;
		}
	}
	
	public function defaultTitle(){
		return Associate::defaultTitle();
	}


}
