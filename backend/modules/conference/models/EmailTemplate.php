<?php

namespace backend\modules\conference\models;

use Yii;

/**
 * This is the model class for table "conf_email_tmplt".
 *
 * @property int $id
 * @property int $conf_id
 * @property int $templ_id
 * @property string $subject
 * @property string $content
 */
class EmailTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'conf_email_tmplt';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['conf_id', 'templ_id', 'subject', 'content'], 'required'],
            [['conf_id', 'templ_id'], 'integer'],
            [['content'], 'string'],
            [['subject'], 'string', 'max' => 100],
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
            'templ_id' => 'Templ ID',
            'subject' => 'Subject',
            'content' => 'Content',
        ];
    }
	
	public function getEmailSet(){
         return $this->hasOne(EmailSet::className(), ['id' => 'templ_id']);
    }
	
	public function queueEmail($user, $email){
		
		$content = $this->emailContentReplace($email->notification, $user);
		$subject = $email->notification_subject;
		$subject = str_replace('{manuscript-number}', $this->manuscriptNo(), $subject);
		$subject = str_replace('{journal-abbr}', $this->journal->journal_abbr, $subject);
		
		
		return Yii::$app->mailqueue->compose()
		 ->setFrom(['auto.mail.esn@gmail.com' => $this->journal->journal_abbr . ' JOURNAL'])
		 ->setReplyTo($this->journal->journal_email)
		 ->setTo([$user->email => $user->fullname])
		 ->setTextBody($content)
		 ->setSubject($subject)
		 ->queue();
	}
	
	public function emailContentReplace($content, $user){
		
		$replaces = [
		'{manuscript-information}' => $manuscript,
		'{manuscript-information-x}' => $manuscriptx,
		'{manuscript-number}' => $this->manuscriptNo(),
		'{manuscript-title}' => $this->title,
		'{manuscript-abstract}' => $this->abstract,
		'{manuscript-keywords}' => $this->keyword,
		'{fullname}' => $user->fullname,
		'{email}' => $user->email,
		'{pre-evaluation-note}' =>  $this->pre_evaluate_note,
		'{response-note}' => $this->response_note,
		'{correction-note}' => $this->correction_note,
		'{reject-note}' => $this->reject_note,
		'{withdraw-note}' => $this->withdraw_note,
		'{journal-abbr}' => $this->journal->journal_abbr,
		'{journal-url}' => $this->journal->journal_url,
		'{journal-full-name}' => $this->journal->journalName,
		'{journal-address}' => $this->journal->journal_address,
		'{journal-phone1}' => $this->journal->phone1,
		'{journal-phone2}' => $this->journal->phone2,
		'{journal-email}' => $this->journal->journal_email,
		'{login-admin-url}' => $setting->admin_url,
		'{author-fee-amount}' => $invoiceAmount,
		'{payment-note}' => $this->payment_note,
		'{bank-name}' => $setting->bank_name,
		'{account-name}' => $setting->account_name,
		'{account-number}' => $setting->account_no,
		
		
		 
		];
		
		foreach($replaces as $key=>$r){
			$content = str_replace($key, $r, $content);
		}
	
		return $content;
	}

}
