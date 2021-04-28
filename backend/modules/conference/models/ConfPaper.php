<?php

namespace backend\modules\conference\models;

use Yii;
use common\models\User;
use yii\helpers\Html;


/**
 * This is the model class for table "conf_paper".
 *
 * @property int $id
 * @property int $conf_id
 * @property int $user_id
 * @property string $pap_title
 * @property string $pap_abstract
 * @property string $paper_file
 * @property string $created_at
 *
 * @property Conference $conf
 * @property User $user
 */
class ConfPaper extends \yii\db\ActiveRecord
{
	public $paper_instance;
	public $payment_instance;
	public $file_controller;
	public $form_abstract_only = 1;
	public $abstract_decide = 1;
	public $full_paper_decide = 1;
	public $payment_decide = 1;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conf_paper';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['conf_id', 'confly_number', 'user_id', 'pap_title', 'pap_abstract', 'created_at', 'status', 'keyword'], 'required', 'on' => 'create'],
			
			[['conf_id', 'user_id', 'pap_title', 'pap_abstract', 'created_at', 'status', 'paper_file', 'keyword', 'myrole'], 'required', 'on' => 'fullpaper'],
			
			[['payment_info', 'payment_at'], 'required', 'on' => 'payment'],
			
			[['abstract_decide'], 'required', 'on' => 'abstract_decide'],
			
            [['conf_id', 'user_id', 'status', 'form_abstract_only', 'abstract_decide', 'invoice_ts', 'myrole', 'confly_number', 'receipt_confly_no', 'invoice_confly_no'], 'integer'],
			
			[['invoice_amount', 'invoice_final', 'payment_amount', 'invoice_early'], 'number'],
			
            [['pap_title', 'pap_abstract', 'paper_file', 'invoice_currency', 'reject_note', 'payment_file', 'payment_info'], 'string'],
			
            [['created_at', 'reject_at', 'payment_at'], 'safe'],
			
            [['conf_id'], 'exist', 'skipOnError' => true, 'targetClass' => Conference::className(), 'targetAttribute' => ['conf_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
			
			[['paper_file'], 'required', 'on' => 'paper_upload'],
            [['paper_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'doc, docx', 'maxSize' => 5000000],
            [['updated_at'], 'required', 'on' => 'paper_delete'],
			
			[['payment_file'], 'required', 'on' => 'payment_upload'],
            [['payment_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf,jpg,jpeg,png,gif', 'maxSize' => 5000000],
            [['updated_at'], 'required', 'on' => 'payment_delete'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'conf_id' => 'Conf ID',
            'user_id' => 'User ID',
            'pap_title' => 'Title',
			'keyword' => 'Keywords',
			'status' => 'Status',
            'pap_abstract' => 'Abstract',
            'paper_file' => 'Upload Full Paper',
            'created_at' => 'Created At',
			'form_abstract_only' => 'Choose One:',
			'myrole' => 'My Role',
			'payment_file' => 'Payment Evidence File (optional)',
			'payment_at' => 'Payment Submitted At',
			'payment_info' => 'Payment Details',
			'payment_file' => 'Uploaded Payment File',
			'invoice_final' => 'Invoice Final Amount (after rounding)',
			'invoice_early' => 'Early Bird Amount'
        ];
    }
	
	public function getPaperRef(){
		//str_pad($value, 8, '0', STR_PAD_LEFT);
		$reg = $this->userRegistration;
		return $this->conference->conf_abbr . ': ' . str_pad($reg->confly_number, 3 , '0', STR_PAD_LEFT) . '-' .  str_pad($this->confly_number, 3 , '0', STR_PAD_LEFT);
	}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConference()
    {
        return $this->hasOne(Conference::className(), ['id' => 'conf_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
	
	public function getUserTitleName(){
		return $this->user->associate->title . ' ' . $this->user->fullname;
	}
	
	public function getUserRegistration()
    {
        return ConfRegistration::find()
		->where(['user_id' => $this->user_id, 'conf_id' => $this->conf_id])
		->one();
    }
	
	public function getAuthorRole(){
		return $this->hasOne(ConfFee::className(), ['id' => 'myrole']);
	}
	
	public function getNiceRole(){
		return $this->authorRole->fee_name;
	}
	
	public function getAuthors()
    {
        return $this->hasMany(ConfAuthor::className(), ['paper_id' => 'id'])->orderBy('author_order ASC');
    }
	
	public function authorString($break = '<br />'){
		$authors = $this->authors;
		$str = '';
		if($authors){
			$i = 1;
			foreach($authors as $au){
				$br = $i == 1 ? '' :  $break;
				$str .= $br. Html::encode($au->fullname);
			$i++;
			}
		}
		return $str;
	}
	
	public function getFirstAuthor(){
		$authors = $this->authors;
		$str = '';
		if($authors){
			$au = $authors[0];
			$str = Html::encode($au->fullname);
		}
		return $str;
	}
	
	public function getAcceptDateStr(){
		$date = $this->fp_accept_ts;
		if($date == 0){
			return 'to_be_determined';
		}else{
			return date('F dS, Y', $date);
		}
	}
	
	public function getCoAuthors($break = '<br />'){
		$authors = $this->authors;
		$str = '';
		if($authors){
			$i = 1;
			foreach($authors as $au){
				$br = $i == 2 ? '' :  $break;
				if($i > 1){
					$str .= $br. Html::encode($au->fullname);
				}
			$i++;
			}
		}
		return $str;
	}
	
	public function getPaperStatus(){
		$statuses = $this->statusList();
		$code = $this->status;
		if(array_key_exists($code, $statuses)){
			return $statuses[$code];
		}else{
			return '';
		}
		
	}
	
	public function statusList(){
		return [
			0 => 'DRAFT',
			10 => 'REJECTED',
			20 => 'WITHDRAWN',
			30 => 'ABSTRACT SUBMISSION',
			35 => 'ABSTRACT & PAPER SUBMISSION',
			40 => 'ABSTRACT ACCEPTED',
			50 => 'FULL PAPER SUBMISSION',
			60 => 'PAPER REVIEW',
			70 => 'PAPER CORRECTION',
			80 => 'PAPER ACCEPTED',
			90 => 'PAYMENT SUBMITTED',
			95 => 'PAYMENT DISAPPROVED',
			100 => 'COMPLETE',
			
		];
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
	
	public function getAbstractOptions(){
		return [
			1 => 'Accept Abstract',
			0 => 'Reject Abstract',
			
		];
	}
	
	public function getFullPaperOptions(){
		return [
			1 => 'Accept Full Paper',
			//2 => 'Review Full Paper',
			0 => 'Reject',
			
		];
	}
	
	public function getPaymentConfirmOptions(){
		return [
			1 => 'Accept Payment',
			//2 => 'Review Full Paper',
			0 => 'Reject Payment',
			
		];
	}
	
	public function nextConflyNumber(){
		$max = self::find()->where(['conf_id' => $this->conf_id])->max('confly_number');
		if($max){
			return $max + 1;
		}else{
			return 1;
		}
	}
	
	public function nextReceiptConflyNumber(){
		$max = self::find()->where(['conf_id' => $this->conf_id])->max('receipt_confly_no');
		if($max){
			return $max + 1;
		}else{
			return 1;
		}
	}
	
	public function nextInvoiceConflyNumber(){
		$max = self::find()->where(['conf_id' => $this->conf_id])->max('invoice_confly_no');
		if($max){
			return $max + 1;
		}else{
			return 1;
		}
	}
	
	public function getNiceAmount(){
		return $this->invoice_currency . ' ' . number_format($this->invoice_amount, 2);
	}


}
