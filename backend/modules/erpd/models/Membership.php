<?php

namespace backend\modules\erpd\models;

use Yii;
use yii\helpers\ArrayHelper;
use backend\modules\staff\models\Staff;

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
	public $msp_instance;
	public $file_controller;
	public $year_start;
	public $year_end;
	public $checknoend;
	
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
            [['msp_staff', 'msp_body', 'msp_type', 'msp_level', 'date_start'], 'required', 'on' => 'save'],
			
			[['msp_file'], 'required', 'on' => 'submit'],
			
            [['msp_staff', 'msp_level'], 'integer'],
            [['date_start', 'date_end'], 'safe'],
            [['msp_body', 'msp_type'], 'string', 'max' => 500],
			
			[['review_note', 'msp_file'], 'string'],
			
			[['msp_file'], 'required', 'on' => 'msp_upload'],
            [['msp_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 5000000],
            [['modified_at'], 'required', 'on' => 'msp_delete'],
        ];
    }
	
	public function getStatusInfo(){
        return $this->hasOne(Status::className(), ['status_code' => 'status']);
    }
	
	public function showStatus(){
		$status = $this->statusInfo;
		return '<span class="label label-'.$status->status_color .'">'.$status->status_name .'</span>';
	}
	
	public function statusListAdmin(){
		$list = Status::find()->where(['admin_show' => 1])->all();
		return ArrayHelper::map($list, 'status_code', 'status_name');
	}
	
	public function statusList(){
		$list = Status::find()->where(['user_show' => 1])->all();
		return ArrayHelper::map($list, 'status_code', 'status_name');
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'msp_staff' => 'Staff',
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
	
	public function getStaff(){
        return $this->hasOne(Staff::className(), ['id' => 'msp_staff']);
    }
	
	public function listYears(){
		$array = [];
		$year_end = date('Y');
		$year_start = $year_end - 7;
		
		for($y=$year_end;$y>=$year_start;$y--){
			$array[$y] = $y;
		}
		
		return $array;
	}

}
