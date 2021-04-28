<?php

namespace backend\modules\conference\models;

use Yii;
use common\models\User;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "conference".
 *
 * @property int $id
 * @property string $conf_name
 * @property string $conf_abbr
 * @property string $date_start
 * @property string $conf_venue
 * @property string $conf_url
 */
class Conference extends \yii\db\ActiveRecord
{
	public $banner_instance;
	public $logo_instance;
	public $file_controller;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conference';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['conf_name', 'conf_abbr', 'date_start','date_end', 'conf_venue', 'conf_url'], 'required'],
			
            [['date_start','date_end', 'updated_at', 'created_at'], 'safe'],
			
            [['conf_name', 'conf_venue'], 'string', 'max' => 200],
			
			 [['conf_background', 'conf_scope', 'conf_lang', 'conf_publication', 'conf_contact', 'conf_submission', 'payment_info', 'announcement', 'conf_accommodation', 'conf_award', 'conf_committee', 'conf_address', 'payment_info_inv', 'phone_contact', 'email_contact', 'fax_contact'], 'string'],
			 
			 [['currency_local', 'currency_int'], 'string', 'max' => 10],
			
            [['conf_abbr'], 'string', 'max' => 50],
            [['conf_url'], 'string', 'max' => 100],
			
			[['conf_url'], 'unique'],
            [['conf_abbr'], 'unique'],
			
			[['email_contact'], 'unique'],
			
			[['user_id', 'created_by'], 'integer'],
			
			[['banner_file'], 'required', 'on' => 'banner_upload'],
            [['banner_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, jpeg, png', 'maxSize' => 2000000],
            [['updated_at'], 'required', 'on' => 'banner_delete'],
			
			[['logo_file'], 'required', 'on' => 'logo_upload'],
            [['logo_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, jpeg, png', 'maxSize' => 2000000],
            [['updated_at'], 'required', 'on' => 'logo_delete'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'conf_name' => 'Conference Name',
            'conf_abbr' => 'Conference Abbr',
            'date_start' => 'Conference Date',
			'conf_address' => 'Organizer\'s Address',
			'phone_contact' => 'Organizer\'s Phone',
			'email_contact' => 'Organizer\'s Email',
			'fax_contact' => 'Organizer\'s Fax',
            'conf_venue' => 'Conference Venue',
            'conf_url' => 'Conference Url',
			'user_id' => 'Manager',
			'currency_int' => 'International Currency',
			'currency_local' => 'Local Currency',
			'logo_file' => 'Invoice/Receipt Logo',
			'payment_info_inv' => 'Invoice Payment Info',
			
        ];
    }
	
	public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
	
	public function getConferenceDate($sep = ' - '){
		if(($this->date_start == $this->date_end) or ($this->date_end == '0000-00-00')){
			return date('d M Y', strtotime($this->date_start));
		}else{
			return date('d M Y', strtotime($this->date_end)) . $sep . date('d M Y', strtotime($this->date_end));
		}
	}
	
	public function getConferenceDateRange($long = false){
		$start = $this->date_start;
		$end = $this->date_end;
		if($end == '0000-00-00' or $start == $end){
			if($long){
				return date('d F Y', strtotime($start));
			}else{
				return date('d M Y', strtotime($start));
			}
			
		}else{
			if($long){
				return $this->dateFormatTwo($start, $end, true);
			}else{
				return $this->dateFormatTwo($start, $end);
			}
			
		}
	}
	
	private function dateFormatTwo($date1, $date2, $long = false){
		$day1 = date('j', strtotime($date1));
		if($long){
			$month_str1 = date('F', strtotime($date1));
		}else{
			$month_str1 = date('M', strtotime($date1));
		}
		$year1 = date('Y', strtotime($date1));
		
		$day2 = date('j', strtotime($date2));
		if($long){
			$month_str2 = date('F', strtotime($date2));
		}else{
			$month_str2 = date('M', strtotime($date2));
		}
		$year2 = date('Y', strtotime($date2));
		
		if($month_str1 == $month_str2){
			if($year1 == $year2){
				return $day1 . ' - '.$day2.' ' . $month_str1 . ' ' . $year1;
			}else{
				return $day1 . ' ' . $month_str1 . ' ' . $year1 . ' - '. $day2 . ' ' . $month_str2 . ' ' . $year2 ;
			}
			
		}else{
			if($year1 == $year2){
				return $day1 . ' ' . $month_str1 . ' - '.$day2.' ' . $month_str2 . ' ' . $year1;
			}else{
				return $day1 . ' ' . $month_str1 . ' ' . $year1 . ' - '. $day2 . ' ' . $month_str2 . ' ' . $year2 ;
			}
		}
	}
	
	public function getConfDates()
    {
        return $this->hasMany(ConfDate::className(), ['conf_id' => 'id'])->orderBy('date_order ASC');
    }
	
	public function getEmails()
    {
        return $this->hasMany(EmailTemplate::className(), ['conf_id' => 'id']);
    }
	
	public function getConfDownloads()
    {
        return $this->hasMany(ConfDownload::className(), ['conf_id' => 'id'])->orderBy('download_order ASC');
    }
	
	public function getConfFees()
    {
        return $this->hasMany(ConfFee::className(), ['conf_id' => 'id'])->orderBy('fee_order ASC');
    }
	
	public function getConfRegistrations()
    {
        return $this->hasMany(ConfRegistration::className(), ['conf_id' => 'id']);
    }
	
	public function getConfPapers()
    {
        return $this->hasMany(ConfPaper::className(), ['conf_id' => 'id']);
    }
	
	public function getTentativeDays()
    {
        return $this->hasMany(TentativeDay::className(), ['conf_id' => 'id']);
    }
	
	public function getPages(){
		return [
			'conf_background' => ['Background', 'background'], 
			'conf_scope' => ['Conference Scope', 'scope'], 
			'conf_submission' => ['Registration & Submission', 'submission'], 
			'dates' => ['Important Dates', 'dates'], 
			'fees' => ['Fees & Payment', 'fees'],
			'conf_publication' =>['Publication', 'publication'], 
			'conf_award' => ['Award', 'award'],
			'conf_accommodation' => ['Venue & Accommodation', 'accommodation'], 
			'tentative' => ['Tentative', 'tentative'], 
			'conf_committee' => ['Committee', 'committee'], 
			'conf_lang' => ['Language', 'language'], 
			'conf_contact' => ['Contact Person', 'contact']
		];
	}
	
	public function getUserCount(){
		$kira = ConfRegistration::find()->where(['conf_id' => $this->id])->count();
		return $kira ? $kira : 0;
	}
	
	public function getPaperCount(){
		$kira = ConfPaper::find()->where(['conf_id' => $this->id])->count();
		return $kira ? $kira : 0;
	}
	
	public function getPaperCountAbstract(){
		$kira = ConfPaper::find()->where(['conf_id' => $this->id, 'status' => [30, 40]])->count();
		return $kira ? $kira : 0;
	}
	
	public function getPaperCountFullPaper(){
		$kira = ConfPaper::find()->where(['conf_id' => $this->id, 'status'=> [35,50]])->count();
		return $kira ? $kira : 0;
	}
	
	public function getPaperCountReview(){
		$kira = ConfPaper::find()->where(['conf_id' => $this->id, 'status'=> [60, 70]])->count();
		return $kira ? $kira : 0;
	}
	
	public function getPaperCountPayment(){
		$kira = ConfPaper::find()->where(['conf_id' => $this->id, 'status'=> [80, 90, 95]])->count();
		return $kira ? $kira : 0;
	}
	
	public function getPaperCountComplete(){
		$kira = ConfPaper::find()->where(['conf_id' => $this->id, 'status'=> [100]])->count();
		return $kira ? $kira : 0;
	}
	
	public function getMyPaperCount(){
		
		$kira = ConfPaper::find()
		->where(['user_id' => Yii::$app->user->identity->id ,'conf_id' => $this->id])
		->count();
		return $kira ? $kira : 0;
	}
	
	public function getEarlyBirdDate(){
		$find = ConfDate::find()->where(['conf_id' => $this->id, 'date_id' => 5])->one();
		if($find){
			return $find->date_start;
		}
	}
	
	public static function listDateNames(){
		return ConfDateName::find()->all();
	}
	
	public static function userIsRegistered($id){
		$count = ConfRegistration::find()->where(['conf_id' => $id, 'user_id' => Yii::$app->user->identity->id])->count();
		if($count > 0){
			return true;
		}else{
			return false;
		}
	}
	
	private function findEmail($id){
		return EmailTemplate::findOne(['templ_id' => $id, 'conf_id' => $this->id]);
	}
	
	public function sendEmail($email_id, $user_id){
		$email = $this->findEmail($email_id);
		$user = User::findOne($user_id);
		
		$content = $this->emailContentReplace($email->content, $user);
		$subject = $email->subject;
		$subject = str_replace('{CONF_SHORT}', $this->conf_abbr, $subject);
		
		return Yii::$app->mailer->compose()
		 ->setFrom(['auto.mail.esn@gmail.com' => $this->conf_abbr])
		 ->setReplyTo($this->email_contact)
		 ->setTo([$user->email => $user->fullname])
		 ->setHtmlBody($content)
		 ->setSubject($subject)
		 ->send(); 
		
		/* return Yii::$app->mailqueue->compose()
		 ->setFrom(['auto.mail.esn@gmail.com' => $this->conf_abbr])
		 ->setReplyTo($this->email_contact)
		 ->setTo([$user->email => $user->fullname])
		 ->setTextBody($content)
		 ->setSubject($subject)
		 ->queue(); */
	}
	
	public function emailContentReplace($content, $user){
		$replaces = [

		];
		
		foreach($replaces as $key=>$r){
			$content = str_replace($key, $r, $content);
		}
	
		return $content;
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
