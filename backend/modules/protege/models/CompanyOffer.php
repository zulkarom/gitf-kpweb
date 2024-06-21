<?php

namespace backend\modules\protege\models;

use Yii;

/**
 * This is the model class for table "prtg_company_offer".
 *
 * @property int $id
 * @property int $session_id
 * @property int $company_id
 *
 * @property PrtgSession $session
 * @property PrtgCompany $company
 * @property StudentRegistration[] $prtgStudentRegs
 */
class CompanyOffer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prtg_company_offer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['session_id', 'company_id'], 'required'],

            [['session_id', 'company_id', 'is_published', 'available_slot'], 'integer'],

            [['session_id'], 'exist', 'skipOnError' => true, 'targetClass' => Session::className(), 'targetAttribute' => ['session_id' => 'id']],

            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'session_id' => 'Session',
            'company_id' => 'Company',
            'is_published' => 'Status',
        ];
    }

    public static function getPublishArray(){
        return [
            0 => 'UNPUBLISHED', 
            1 => 'PUBLISHED',
        ];
    }

    public static function getPublishColor(){
	    return [0 => 'danger', 1 => 'success'];
	}

    public function getPublishText(){
        $text = '';
        if(array_key_exists($this->is_published, $this->publishArray)){
            $text = $this->publishArray[$this->is_published];
        }
        return $text;
    }

    public function getPublishLabel(){
        $color = "";
        if(array_key_exists($this->is_published, $this->publishColor)){
            $color = $this->publishColor[$this->is_published];
        }
        return '<span class="label label-'.$color.'">'. $this->publishText .'</span>';
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSession()
    {
        return $this->hasOne(Session::className(), ['id' => 'session_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentRegistrations()
    {
        return $this->hasMany(StudentRegistration::className(), ['company_offer_id' => 'id']);
    }

    public function sumRegistered(){
        $kira = StudentRegistration::find()
        ->where(['company_offer_id' => $this->id])
        ->count();
        return $kira ? $kira : 0;
    }

    public function getBalance(){
        $baki = $this->available_slot - $this->sumRegistered();
        return $baki = $baki > 0 ? $baki : 0;
    }

    public function availableText(){
        $baki = $this->getBalance();
        return $baki . ' / ' . $this->available_slot;
    }

    public function buttonColor(){
        if($this->getBalance() > 0){
            return 'success';
        }else{
            return 'danger';
        }
    }
}
