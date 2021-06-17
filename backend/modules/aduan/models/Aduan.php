<?php

namespace backend\modules\aduan\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "adu_aduan".
 *
 * @property int $id
 * @property string $name
 * @property string $nric
 * @property string $address
 * @property string $email
 * @property string $phone
 * @property string $topic_id
 * @property string $title
 * @property string $aduan
 * @property int $declaration
 * @property string $upload_url
 * @property string $captcha
 * @property int $progress_id
 * @property string $created_at
 * @property string $updated_at
 */
class Aduan extends \yii\db\ActiveRecord
{
	public $post_code;
	
	public $kira;
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adu_aduan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {	
        return [
            [['name', 'nric',  'email', 'phone', 'topic_id', 'title', 'aduan', 'progress_id', 'created_at', 'updated_at', 'type', 'token', 'email_code'], 'required'],
			
			[['progress_id'], 'required', 'on' => 'admin_update'],
			
			[['email', 'id' ], 'required', 'on' => 'kemaskini'],
			
			[['post_code' ], 'required', 'on' => 'verify'],
			
			[['declaration'], 'required', 'on' => 'frontend',  'requiredValue' => 1, 'message'=>'PERHATIAN: Anda mesti tanda pengakuan di atas sebelum menghantar aduan.'],
			
			
            ['email', 'email'],
			
            [['address', 'aduan', 'upload_url', 'token'], 'string'],
			
            [['id','declaration', 'progress_id', 'type', 'email_code'], 'integer'],
			
            [['created_at', 'updated_at'], 'safe'],
			
            [['name', 'email', 'title', 'captcha'], 'string', 'max' => 225],
			
            [['nric', 'phone'], 'string', 'max' => 20],
			
            [['topic_id'], 'string', 'max' => 100],
			
            [['upload_url'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg,gif,pdf', 'maxSize' => 2000000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Aduan#',
            'name' => 'Nama Penuh',
            'nric' => 'No. Matrik/Staff/Ic',
            'address' => 'Alamat',
            'email' => 'Emel',
            'phone' => 'Telefon',
            'topic_id' => 'Kategori',
            'title' => 'Tajuk',
            'aduan' => 'Aduan',
            'declaration' => 'Declaration',
            'upload_url' => 'Upload File',
            'captcha' => 'Captcha',
            'progress_id' => 'Progress',
            'created_at' => 'Tarikh',
            'updated_at' => 'Updated At',
			'type' => 'Klasifikasi',
			'post_code' => 'Kod Verifikasi'
        ];
    }

    public function getTopic(){
        return $this->hasOne(AduanTopic::className(), ['id' => 'topic_id']);
    }

    public function getProgress(){
        return $this->hasOne(AduanProgress::className(), ['id' => 'progress_id']);
    }
	

	
	public function upload(){
		$uploadFile = UploadedFile::getInstance($this, 'upload_url');
		if($uploadFile){
			$year = date('Y') + 0 ;
			$time = time();
			$path = $year.'/'.$this->id .'/';
			$directory = Yii::getAlias('@upload/aduan/'.$path);
			if (!is_dir($directory)) {
				FileHelper::createDirectory($directory);
			}
			$this->upload_url = $path.$uploadFile->name; 
			
			if($uploadFile->saveAs($directory.'/'. $uploadFile->name)){
				$this->save();
				return true;
			}
			
		}else{
			return true;
		}
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
	
	public function download(){
		
		$file = Yii::getAlias('@upload/aduan/' . $this->upload_url);
        
        if($this->upload_url){
            if (file_exists($file)) {
            $ext = pathinfo($this->upload_url, PATHINFO_EXTENSION);

            $filename = 'Aduan.' . $ext ;
            
            self::sendFile($file, $filename, $ext);
            
            
            }else{
                echo 'file not exist!';
            }
        }else{
            echo 'file not exist!';
        }
	}
	
	public static function sendFile($file, $filename, $ext){
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: inline; filename=" . $filename);
        header("Content-Type: " . self::mimeType($ext));
        header("Content-Length: " . filesize($file));
        header("Content-Transfer-Encoding: binary");
        readfile($file);
        exit;
    }

    public static function mimeType($ext){
        switch($ext){
            case 'pdf':
            $mime = 'application/pdf';
            break;
			
			case 'zip':
            $mime = 'application/zip';
            break;
            
            case 'jpg':
            case 'jpeg':
            $mime = 'image/jpeg';
            break;
            
            case 'gif':
            $mime = 'image/gif';
            break;
            
            case 'png':
            $mime = 'image/png';
            break;
            
            default:
            $mime = '';
            break;
        }
        
        return $mime;
    }
	
	public function sendEmail(){
		$link = 'https://fkp-portal.umk.edu.my/web/aduan/kemaskini?id='.$this->id.'&t='.$this->token;
		Yii::$app->mailer->compose()
		->setFrom(['auto.mail@fkp-portal.umk.edu.my' => 'eAduan FKP'])
		->setTo($this->email)
		->setSubject('Maklumat Aduan#' . $this->id)
		//->setTextBody('Salam Sejahtera, '. $this->name . ' \n Terima kasih kerana menggunakan eAduan FKP. Berikut adalah salinan maklumat aduan anda. \n\n
		//Text aduan: ' . $this->aduan . ' \n\nTerima kasih')
		
		->setHtmlBody('Salam Sejahtera, <br />
		'. $this->name . '<br />
		<br />Terima kasih kerana menggunakan eAduan FKP.
		<br /><br />Berikut adalah maklumat aduan anda. <br/><br/>
		Aduan#: '.$this->id .'<br/>
		Text Aduan: <br />
		'.$this->aduan .'
		<br /><br />
		Anda boleh mengemaskini atau memberi maklum balas aduan anda di <a href="'.$link.'">'.$link.'</a>
		
		
		<br /><br />
		Email ini dihantar secara automatik. Sebarang email balas melalui email ini tidak akan sampai kepada pihak pengurusan.<br /><br />
		
		<br /><br />Terima kasih
		<br />Pengurusan FKP.
		
		')
		->send();
	}
	
	public function sendCode(){
		Yii::$app->mailer->compose()
		->setFrom(['auto.mail@fkp-portal.umk.edu.my' => 'eAduan FKP'])
		->setTo($this->email)
		->setSubject('Kod Verifikasi Aduan#'.$this->id)
		->setHtmlBody('Salam Sejahtera, 
		<br />'. $this->name . ' <br /><br />
		Berikut merupakan kod verifikasi aduan anda:<br />
		<b>Kod Verifikasi: ' . $this->email_code . '</b>
		<br /><br />
		Email ini dihantar secara automatik. Sebarang email balas melalui email ini tidak akan sampai kepada pihak pengurusan.<br /><br />
		
		Terima kasih
		<br />Pengurusan FKP.
		
		
		
		
		')
		//->setHtmlBody('Hi, ' . $this->name . '<br />')
		->send();
	}
	
	public function getEmailAdmin(){
		$set = Setting::findOne(1);
		
		if($set){
			if($set->penyelia > 0){
				
				if($set->user){
					if($set->user->email){
						if (filter_var($set->user->email, FILTER_VALIDATE_EMAIL)) {
							return $set->user->email;
						}
						
					}
				}
			}
		}
		return false;
	}
	
	public function sendEmailAdmin(){
		if($this->emailAdmin){
		
			Yii::$app->mailer->compose()
		->setFrom(['auto.mail@fkp-portal.umk.edu.my' => 'Notifikasi eAduan'])
		->setTo($this->emailAdmin)
		->setSubject('Maklumat Aduan#' . $this->id)
		
		//->setTextBody('Salam Sejahtera, '. $this->name . ' \n Terima kasih kerana menggunakan eAduan FKP. Berikut adalah salinan maklumat aduan anda. \n\n
		//Text aduan: ' . $this->aduan . ' \n\nTerima kasih')
		
		->setHtmlBody('Assalamualaikum dan Salam Sejahtera, <br />
		Penyelia Aduan<br /><br />
		Berikut adalah maklumat aduan yang baru diterima. <br/><br/>
		Aduan#: '.$this->id .'<br/>
		Text Aduan: <br />
		'.$this->aduan .'
		<br /><br />
		Sila login ke FKP portal <a href="https://fkp-portal.umk.edu.my">
		https://fkp-portal.umk.edu.my
		</a> untuk tindakan selanjutnya.
		
		
		<br /><br />
		Email ini dihantar secara automatik.<br />
		
		<br /><br />Terima kasih
		<br />Portal FKP.
		
		')
		->send();
			
		}
		
	}
	
	public function getCountThisYear(){
		$year = date('Y');
		return self::find()
		->where(['>=', 'progress_id', '20'])
		->andWhere(['YEAR(created_at)' => $year])
		->count();
	}
	
	public function getCountLastYear(){
		$year = date('Y') - 1;
		return self::find()
		->where(['>=', 'progress_id', '20'])
		->andWhere(['YEAR(created_at)' => $year])
		->count();
	}
	
	public function getCountToday(){
		$date = date('Y-m-d');
		return self::find()
		->where(['>=', 'progress_id', '20'])
		->andWhere(['DATE(created_at)' => $date])
		->count();
	}
	
	public function getCountThisMonth(){
		$year = date('Y');
		$month = date('m');
		return self::find()
		->where(['>=', 'progress_id', '20'])
		->andWhere([
		'YEAR(created_at)' => $year,
		'MONTH(created_at)' => $month
		])
		->count();
	}
	
	public static function typeName(){
		return [
			1 => 'Pelajar',
			2 => 'Staff',
			3 => 'Lain-lain'
		];
	}
	
	public function getDataType(){
		$year = date('Y');
		$result = self::find()
        ->select('type, COUNT(id) as kira')
        ->where(['>=', 'progress_id', '20'])
		->andWhere(['YEAR(created_at)' => $year])
        ->groupBy('type')
        ->all();
		
		$label = [];
		$data = [];
		$typeName = self::typeName();
		if($result){
			foreach($result as $row){
				$label[] = $typeName[$row->type];
				$data[] = $row->kira;
			}
		}
		
		return [$label, $data];
	}
	
	public function getDataStatus(){
		$year = date('Y');
		$result = self::find()
        ->select('progress_id, COUNT(id) as kira')
        ->where(['>=', 'progress_id', '20'])
		->andWhere(['YEAR(created_at)' => $year])
        ->groupBy('progress_id')
        ->all();
		
		$label = [];
		$data = [];
		$typeName = self::typeName();
		if($result){
			foreach($result as $row){
				$label[] = $row->progress->progress;
				$data[] = $row->kira;
			}
		}
		
		return [$label, $data];
	}
	
	public function getDataTopic(){
		$year = date('Y');
		$result = self::find()
        ->select('topic_id, COUNT(id) as kira')
        ->where(['>=', 'progress_id', '20'])
		->andWhere(['YEAR(created_at)' => $year])
        ->groupBy('topic_id')
        ->all();
		
		$label = [];
		$data = [];
		$typeName = self::typeName();
		if($result){
			foreach($result as $row){
				$label[] = $row->topic->topic_name;
				$data[] = $row->kira;
			}
		}
		
		return [$label, $data];
	}
	
	


    
}
