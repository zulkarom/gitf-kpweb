<?php

namespace backend\modules\erpd\models;

use Yii;

/**
 * This is the model class for table "rp_membership".
 *
 * @property int $id
 * @property int $msp_staff
 * @property string $msp_body
 * @property string $msp_type
 * @property int $msp_level 1=local,2=international
 * @property string $date_start
 * @property string $date_end
 * @property string $msp_file
 */
class Membership extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rp_membership';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['msp_staff', 'msp_body', 'msp_type', 'msp_level', 'date_start', 'date_end',], 'required', 'on' => 'save'],
			
            [['msp_staff', 'msp_level'], 'integer'],
            [['date_start', 'date_end'], 'safe'],
            [['msp_body', 'msp_type'], 'string', 'max' => 500],
            [['msp_file'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'msp_staff' => 'Msp Staff',
            'msp_body' => 'Membership Body',
            'msp_type' => 'Membership Type',
            'msp_level' => 'Level',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'msp_file' => 'Membership PDF File',
        ];
    }
	
	public function listLevel(){
		return [1=>'Local', 2 => 'International'];
	}
	
	public function getLevelName(){
		$arr = $this->listLevel();
		return $arr[$this->msp_level];
	}
	
	public function membershipBodySample(){
		$eg = ["Malaysian Institute of Management (MIM)",
			"Malaysian Institute of Personnel Management (MIPM)",
			"Malaysian Institute of Accountant",
			"Malaysian Bar Council",
			"Association of Chartered Certified Accountants (ACCA)",
			"Chartered Institute of Procurement and Supply (CIPS)",
			"Institution of Hospitality (IH)"
			];
		$arr = [];
		foreach($eg as $e){
			$arr[$e] = $e;
		}
		$arr[999] = 'Others (please specify)';
		
		return $arr;
	}
	
	public function membershipTypeSample(){
		$eg = ["Ordinary Member",
			"Honorary Member",
			"Corporate Member",
			"Associate Member",
			"Life Member"
			];
		$arr = [];
		foreach($eg as $e){
			$arr[$e] = $e;
		}
		$arr[999] = 'Others (please specify)';
		
		return $arr;
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
