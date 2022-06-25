<?php

namespace backend\modules\conference\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "conf_reg".
 *
 * @property int $id
 * @property int $conf_id
 * @property int $user_id
 * @property string $reg_at
 *
 * @property Conference $conf
 */
class ConfRegistration extends \yii\db\ActiveRecord
{
    public $file_controller;
    public $fee_instance;
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conf_reg';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['conf_id', 'user_id', 'reg_at', 'confly_number'], 'required'],

            [['fee_amount', 'fee_currency', 'fee_file'], 'required', 'on' => 'payment'],

            [['conf_id', 'user_id', 'confly_number','fee_paid_at','fee_verified_at','fee_currency','is_author','is_reviewer'], 'integer'],

            [['reg_at'], 'safe'],
            [['fee_note'], 'string'],
            [['fee_amount'], 'number'],
            [['conf_id'], 'exist', 'skipOnError' => true, 'targetClass' => Conference::className(), 'targetAttribute' => ['conf_id' => 'id']],

            [['fee_file'], 'required', 'on' => 'fee_upload'],
            [['fee_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf, png, jpg, jpeg, doc, docx', 'maxSize' => 5000000],
            [['updated_at'], 'required', 'on' => 'fee_delete'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'conf_id' => 'Conf ID',
            'user_id' => 'User ID',
            'reg_at' => 'Registration Time',
            'fee_file' => 'Evidence of Payment',
            'fee_amount' => 'Amount',
            'fee_currency' => 'Currency',
            'fee_note' => 'Note of Payment',
            'user.fullname' => 'Full Name',
            'user.email' => 'Email',

        ];
    }

    public function listFeeStatus(){
        return [0 => 'None', 1 => 'Submitted', 10 => 'Verified'];
    }

    public function getStatusFeeLabel(){
        if(array_key_exists($this->fee_status, $this->listFeeStatus())){
            return $this->listFeeStatus()[$this->fee_status];
        }
    }

    public function getFeeAmountFormat(){
        $curr = $this->fee_currency;
        $str='';
        $conf= $this->conference;
        if($curr == 0){
            $str = $conf->currency_local;
        }else{
            $conf->currency_int;
        }
        return $str . ' ' . number_format($this->fee_amount,2);
    }

    public function listCurrency(){
        $curr = [];
        $conf= $this->conference;
        $curr_local = $conf->currency_local;
        $curr_int = $conf->currency_int;
        if($curr_local){
        $curr[0] = $curr_local;
        }
        if($curr_int){
        $curr[1] = $curr_int;
        }

        return $curr;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConference()
    {
        return $this->hasOne(Conference::className(), ['id' => 'conf_id']);
    }
	
	public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getAssociate()
    {
        return $this->hasOne(Associate::className(), ['id' => 'user_id']);
    }
	
    public function getPapers()
    {
        return ConfPaper::find()
        ->where(['user_id' => $this->user_id, 'conf_id' => $this->conf_id])
        ->all() ;
    }
	
	public function nextConflyNumber(){
		$max = self::find()->where(['conf_id' => $this->conf_id])->max('confly_number');
		if($max){
			return $max + 1;
		}else{
			return 1;
		}
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

}
