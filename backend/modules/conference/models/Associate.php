<?php

namespace backend\modules\conference\models;

use Yii;
use common\models\User;
use common\models\Country;

/**
 * This is the model class for table "jeb_associate".
 *
 * @property int $id
 * @property int $user_id
 */
class Associate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jeb_associate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required', 'on' => 'raw'],
			
			[['sv_main', 'pro_study', 'cumm_sem', 'matric_no', 'phone', 'country_id'], 'required', 'on' => 'conf_profile'],
			
			[['institution', 'country_id', 'title'], 'required', 'on' => 'update_external'],
			
            [['user_id', 'country_id'], 'integer'],
			
			[['title'], 'string', 'max' => 100],
			
            [['institution'], 'string', 'max' => 200],
			
            [['assoc_address', 'phone', 'sv_main', 'sv_co1', 'sv_co2', 'sv_co3'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'country_id' => 'Country',
			'institution' => 'Institution',
			'matric_no' => 'Matric No.',
			'pro_study' => 'Program of Study',
			'sv_main' => 'Main Supervisor',
			'sv_co1' => 'Co-Supervisor I',
			'sv_co2' => 'Co-Supervisor II',
			'sv_co3' => 'Co-Supervisor III',
			'cumm_sem' => 'Cumulative Semester'
        ];
    }
	
	public static function listSemNumber(){
		$array = [];
		for($i=1;$i<=16;$i++){
			$array[$i] = $i;
		}
		return $array;
	}
	
	public static function listProgramStudy(){
		$array[1] = 'Master';
		$array[2] = 'PhD';
		$array[0] = 'Others';
		return $array;
	}
	
	public function getProgramStudyText(){
	    $list = self::listProgramStudy();
	    if(in_array($this->pro_study, $list)){
	        return $list[$this->pro_study];
	    }else{
	        return '';
	    }
	}
	
	public function getUser(){
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}
	
	public function getCountry(){
		return $this->hasOne(Country::className(), ['id' => 'country_id']);
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
	
	public static function defaultTitle(){
		$array = ['Mr.','Mrs.', 'Miss','Dr.', 'Assoc. Prof.', 'Prof.'];
		$return = [];
		foreach($array as $a){
			$return[$a] = $a;
		}
		$return[999] = 'Others (Please specify...)';
		return $return;
	}
	
	public function getSupervisors(){
	    $sv = [];
	    
	}
	
	public function getSupervisorsList($br = false){
		$str = '';
		if($br == false){
		    $br = '<br />';
		}
		if($this->sv_main){
	        $str .= strtoupper($this->sv_main) . ' (MAIN)' . $br;
	    }
	    if($this->sv_co1){
	        $str .= strtoupper($this->sv_co1) . ' (CO.SV I)' . $br;
	    }
	    if($this->sv_co2){
	        $str .= strtoupper($this->sv_co1) . ' (CO.SV II)' . $br;
	    }
	    if($this->sv_co3){
	        $str .= strtoupper($this->sv_co1) . ' (CO.SV III)' . $br;
	    }
	    return $str;
	    
	}

}
