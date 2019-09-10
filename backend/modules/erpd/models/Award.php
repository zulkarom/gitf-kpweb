<?php

namespace backend\modules\erpd\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "rp_award".
 *
 * @property int $id
 * @property int $awd_staff
 * @property string $awd_name
 * @property int $awd_level
 * @property string $awd_type
 * @property string $awd_by
 * @property string $awd_date
 * @property string $awd_file
 */
class Award extends \yii\db\ActiveRecord
{
	public $awd_instance;
	public $file_controller;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rp_award';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['awd_staff', 'awd_name', 'awd_level', 'awd_type', 'awd_by', 'awd_date'], 'required'],
			
			[['awd_file'], 'required', 'on' => 'submit'],
			
            [['awd_staff', 'awd_level'], 'integer'],
            [['awd_date'], 'safe'],
            [['awd_name', 'awd_by'], 'string', 'max' => 300],
            [['awd_type', 'awd_file'], 'string', 'max' => 100],
			
			[['awd_file'], 'required', 'on' => 'awd_upload'],
            [['awd_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 5000000],
            [['modified_at'], 'required', 'on' => 'awd_delete'],
			
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'awd_staff' => 'Awd Staff',
            'awd_name' => 'Award Name',
            'awd_level' => 'Award Level',
            'awd_type' => 'Award Type',
            'awd_by' => 'Awarded By',
            'awd_date' => 'Award Date',
            'awd_file' => 'Award PDF File',
        ];
    }
	
	public function awardNameSample(){
		$eg = [
		"Best Paper Award",
		"Merdeka Award",
		"Innovation Award",
		"Anugerah Perkhidmatan Cemerlang"
			];
		$arr = [];
		foreach($eg as $e){
			$arr[$e] = $e;
		}
		$arr[999] = 'Others (please specify)';
		
		return $arr;
	}
	
	public function awardedBySample(){
		$eg = [
		"Kementerian Pengajian Tinggi (KPT)",
		"Universiti Malaysia Kelantan (UMK)"
			];
		$arr = [];
		foreach($eg as $e){
			$arr[$e] = $e;
		}
		$arr[999] = 'Others (please specify)';
		
		return $arr;
	}
	public function awardTypeSample(){
		$eg = [
		"Gold",
		"Silver",
		"Bronze",
		"No Type"
			];
		$arr = [];
		foreach($eg as $e){
			$arr[$e] = $e;
		}
		$arr[999] = 'Others (please specify)';
		
		return $arr;
	}
	
	public function listLevel(){
		return [1=>'Local', 2 => 'International'];
	}
	
	public function getLevelName(){
		$arr = $this->listLevel();
		return $arr[$this->awd_level];
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
	
	public function statusList(){
		$list = Status::find()->where(['user_show' => 1])->all();
		return ArrayHelper::map($list, 'status_code', 'status_name');
	}
	
	public function getStatusInfo(){
        return $this->hasOne(Status::className(), ['status_code' => 'status']);
    }
	
	public function showStatus(){
		$status = $this->statusInfo;
		return '<span class="label label-'.$status->status_color .'">'.$status->status_name .'</span>';
	}
}
