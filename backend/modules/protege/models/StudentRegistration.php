<?php

namespace backend\modules\protege\models;

use Yii;

/**
 * This is the model class for table "prtg_student_reg".
 *
 * @property int $id
 * @property int $status
 * @property int $company_offer_id
 * @property string $student_matric
 * @property string $student_name
 * @property string $program_abbr
 * @property string $register_at
 * @property string $email
 * @property string $phone
 *
 * @property PrtgCompanyOffer $companyOffer
 */
class StudentRegistration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prtg_student_reg';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'company_offer_id', 'student_matric', 'student_name'], 'required'],
            [['status', 'company_offer_id'], 'integer'],
            [['register_at'], 'safe'],
            [['student_matric'], 'string', 'max' => 100],
            [['student_name', 'email', 'phone'], 'string', 'max' => 255],
            [['program_abbr'], 'string', 'max' => 10],
            [['company_offer_id'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyOffer::className(), 'targetAttribute' => ['company_offer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'company_offer_id' => 'Company',
            'student_matric' => 'Matric Number',
            'student_name' => 'Student Name',
            'program_abbr' => 'Program',
            'register_at' => 'Register At',
            'email' => 'Email',
            'phone' => 'Phone',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyOffer()
    {
        return $this->hasOne(CompanyOffer::className(), ['id' => 'company_offer_id']);
    }

    public static function listPrograms(){
        return [
            'SAK' => 'SAK',
            'SAL' => 'SAL',
            'SAR' => 'SAR',
        ];
    }
}
