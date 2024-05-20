<?php

namespace backend\modules\protege\models;

use Yii;

/**
 * This is the model class for table "prtg_session".
 *
 * @property int $id
 * @property string $session_name
 * @property int $created_at
 * @property int $updated_at
 *
 * @property PrtgCompanyOffer[] $prtgCompanyOffers
 */
class Session extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prtg_session';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['session_name', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at', 'is_active', 'total_student'], 'integer'],
            [['session_name'], 'string', 'max' => 255],
            [['instruction'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'session_name' => 'Session Name',
            'is_active' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function getActiveArray(){
        return [
            0 => 'INACTIVE', 
            1 => 'ACTIVE',
        ];
    }

    public static function getActiveColor(){
	    return [0 => 'danger', 1 => 'success'];
	}

    public function getActiveText(){
        $text = '';
        if(array_key_exists($this->is_active, $this->activeArray)){
            $text = $this->activeArray[$this->is_active];
        }
        return $text;
    }

    public function getActiveLabel(){
        $color = "";
        if(array_key_exists($this->is_active, $this->activeColor)){
            $color = $this->activeColor[$this->is_active];
        }
        return '<span class="label label-'.$color.'">'. $this->activeText .'</span>';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyOffers()
    {
        return $this->hasMany(CompanyOffer::className(), ['session_id' => 'id']);
    }

    public function sumSlotOffer(){
        $sum = CompanyOffer::find()
        ->where(['session_id' => $this->id])
        ->sum('available_slot');
        return $sum ? $sum : 0;
    }

    public function countRegister(){
        $kira = StudentRegistration::find()->alias('a')
        ->innerJoin('prtg_company_offer f', 'f.id = a.company_offer_id')
        ->where(['f.session_id' => $this->id])
        ->count();
        return $kira;
    }
}
