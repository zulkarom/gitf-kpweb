<?php

namespace backend\modules\erpd\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "research".
 *
 * @property int $id
 * @property string $res_title
 * @property int $res_leader
 * @property int $res_progress 1=finish,0 = ongoing
 * @property string $date_start
 * @property string $date_end
 * @property int $res_grant
 * @property string $res_grant_others
 * @property string $res_source
 * @property string $res_amount
 * @property string $res_file
 * @property string $modified_at
 * @property string $created_at
 * @property int $reminder
 */
class Research extends \yii\db\ActiveRecord
{
	public $res_instance;
	public $file_controller;
	public $year_start;
	public $year_end;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rp_research';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['res_title', 'res_staff', 'res_progress', 'date_start', 'date_end', 'res_grant', 'res_source', 'res_amount', 'created_at'], 'required', 'on' => 'res_entry'],
			
			[['res_file'], 'required', 'on' => 'submit'],
			
			[['res_title', 'res_staff', 'res_progress', 'date_start', 'date_end', 'res_grant', 'res_source', 'res_amount', 'modified_at'], 'required', 'on' => 'res_update'],
			
            [['res_staff', 'res_progress', 'res_grant', 'reminder', 'status'], 'integer'],
			
            [['date_start', 'date_end', 'modified_at', 'created_at'], 'safe'],
            [['res_amount'], 'number'],
			
            [['res_title'], 'string', 'max' => 600],
			
            [['res_grant_others', 'res_source', 'res_file'], 'string', 'max' => 200],
			
			[['res_file'], 'required', 'on' => 'res_upload'],
            [['res_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 5000000],
            [['modified_at'], 'required', 'on' => 'res_delete'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Res ID',
            'res_title' => 'Research Title',
            'res_staff' => 'Res Staff',
            'res_progress' => 'Progress',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'res_grant' => 'Research Grant',
            'res_grant_others' => 'Others',
            'res_source' => 'Resource/ Sponsorship',
            'res_amount' => 'Amount',
            'res_file' => 'Research File',
            'modified_at' => 'Modified At',
            'created_at' => 'Created At',
            'reminder' => 'Reminder',
        ];
    }
	
	public function getResearchers()
    {
        return $this->hasMany(Researcher::className(), ['res_id' => 'id'])->orderBy('res_order ASC');
    }
	
	public function getLeader(){
		$result = Researcher::find()
		->where(['res_id' => $this->id])
		->orderBy('res_order ASC')
		->one();
		if($result){
			if($result->staff_id == 0){
				return $result->ext_name;
			}else{
				return $result->staff->user->fullname;
			}
		}
	}
	
	public function listGrants(){
		$list = ResearchGrant::find()->all();
		return ArrayHelper::map($list, 'id', 'gra_abbr');
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
	
	public function getResearchGrant(){
        return $this->hasOne(ResearchGrant::className(), ['id' => 'res_grant']);
    }
	
	public function statusList(){
		$list = Status::find()->where(['user_show' => 1])->all();
		return ArrayHelper::map($list, 'status_code', 'status_name');
	}
	public function statusListAdmin(){
		$list = Status::find()->where(['admin_show' => 1])->all();
		return ArrayHelper::map($list, 'status_code', 'status_name');
	}
	
	public function getStatusInfo(){
        return $this->hasOne(Status::className(), ['status_code' => 'status']);
    }
	
	public function showStatus(){
		$status = $this->statusInfo;
		return '<span class="label label-'.$status->status_color .'">'.$status->status_name .'</span>';
	}
	
	public function showProgress(){
		$arr = $this->progressArr();
		if($this->res_progress == 0){
			$color = 'info';
		}else{
			$color = 'success';
		}
		return '<span class="label label-'.$color .'">'.strtoupper($arr[$this->res_progress]) .'</span>';
		
	}
	
	public function progressArr(){
		return [0 => 'On Going', 1 => 'Complete'];
	}
	
	public function strProgress(){
		$arr = $this->progressArr();
		return strtoupper($arr[$this->res_progress]);
	}
	
	public function stringResearchers(){
		$string ="";
		$researchers = $this->researchers;
		if($researchers){
			foreach($researchers as $researcher){
				if($researcher->staff_id == 0){
					$string .= $researcher->ext_name . '*<br />';
				}else{
					$string .= $researcher->staff->user->fullname . '<br />';
				}
				
			}
		}
		return $string;
	}
	
		public function plainResearchers(){
		$string ="";
		$researchers = $this->researchers;
		if($researchers){
			$i = 0;
			foreach($researchers as $researcher){
				$br = $i == 0 ? "" : "\n";
				if($researcher->staff_id == 0){
					$string .= $br .$researcher->ext_name . "*";
				}else{
					$string .= $br .$researcher->staff->user->fullname ;
				}
			$i++;
			}
		}
		return $string;
	}


}
