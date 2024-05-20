<?php

namespace backend\modules\protege\models;

use Yii;

/**
 * This is the model class for table "prtg_company".
 *
 * @property int $id
 * @property string $company_name
 * @property string $address
 * @property string $description
 * @property int $created_at
 * @property int $updated_at
 *
 * @property PrtgCompanyOffer[] $prtgCompanyOffers
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prtg_company';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_name'], 'required'],
            [['description', 'email', 'phone', 'company_pic'], 'string'],
            [['email'], 'email'],
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['company_name', 'address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => 'Company Name',
            'address' => 'Address',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'company_pic' => 'Person-in-charge'
        ];
    }

    public static function getStatusArray(){
        return [
            0 => 'DRAFT', 
            10 => 'AKTIF',
            90=> 'ARCHIVED'
        ];
    }

    public static function getStatusColor(){
	    return [0 => 'warning', 10 => 'primary', 90 => 'danger'];
	}

    public function getStatusText(){
        $text = '';
        if(array_key_exists($this->status, $this->statusArray)){
            $text = $this->statusArray[$this->status];
        }
        return $text;
    }

    public function getStatusLabel(){
        $color = "";
        if(array_key_exists($this->status, $this->statusColor)){
            $color = $this->statusColor[$this->status];
        }
        return '<span class="label label-'.$color.'">'. $this->statusText .'</span>';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyOffers()
    {
        return $this->hasMany(CompanyOffer::className(), ['company_id' => 'id']);
    }
}
