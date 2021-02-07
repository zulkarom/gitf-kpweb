<?php

namespace backend\modules\aduan\models;

use Yii;

/**
 * This is the model class for table "adu_aduan_action".
 *
 * @property int $id
 * @property int $aduan_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property string $title
 * @property string $action_text
 */
class AduanAction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adu_aduan_action';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['action_text', 'progress_id'], 'required'],
            [['aduan_id', 'created_by', 'progress_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['action_text'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aduan_id' => 'Aduan ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'action_text' => 'Write a reply',
        ];
    }
	
	public function getProgress(){
        return $this->hasOne(AduanProgress::className(), ['id' => 'progress_id']);
    }
	
	public function getAduan(){
        return $this->hasOne(Aduan::className(), ['id' => 'aduan_id']);
    }
	
	public function sendActionEmail(){
		$link = 'https://fkp-portal.umk.edu.my/web/aduan/kemaskini?id='.$this->aduan->id.'&t='.$this->aduan->token;
		Yii::$app->mailer->compose()
		->setFrom(['fkp.umk.email@gmail.com' => 'eAduan FKP'])
		->setTo($this->aduan->email)
		->setSubject('Maklumat Tindakan Aduan#' . $this->aduan->id)
		
		->setHtmlBody('Salam Sejahtera, <br />
		'. $this->aduan->name . '<br />
		<br />Terima kasih kerana menggunakan eAduan FKP.
		<br />Berikut adalah maklumat tindakan terhadap aduan anda. <br/><br/>
		Aduan#: '.$this->aduan->id .'<br/>
		Maklum balas tindakan: <br />
		'.$this->action_text .'
		<br /><br />
		Anda boleh mengemaskini atau memberi maklum balas aduan anda di <a href="'.$link.'">'.$link.'</a>
		
		
		<br /><br />
		Email ini dihantar melalui sistem eAduan FKP. Sebarang email balas melalui email ini tidak akan sampai kepada pihak pengurusan.<br /><br />
		
		<br /><br />Terima kasih
		<br />Pengurusan FKP.
		
		')
		->send();
	}
	
	public function sendClarificationEmail(){
		$link = 'https://fkp-portal.umk.edu.my/web/aduan/kemaskini?id='.$this->aduan->id.'&t='.$this->aduan->token;
		Yii::$app->mailer->compose()
		->setFrom(['fkp.umk.email@gmail.com' => 'eAduan FKP'])
		->setTo($this->aduan->email)
		->setSubject('Mohon Penjelasan Lanjut Terhadap Aduan#' . $this->aduan->id)
		
		->setHtmlBody('Salam Sejahtera, <br />
		'. $this->aduan->name . '<br />
		<br />Terima kasih kerana menggunakan eAduan FKP.
		<br />Pihak kami memerlukan sedikit penjelasan berkaitan dengan aduan anda. <br/><br/>
		Aduan#: '.$this->aduan->id .'<br/>
		Penjelasan terhadap aduan: <br />
		'.$this->action_text .'
		<br /><br />
		Anda boleh memberi penjelasan di pautan <a href="'.$link.'">'.$link.'</a>
		
		
		<br /><br />
		Email ini dihantar melalui sistem eAduan FKP. Sebarang email balas melalui email ini tidak akan sampai kepada pihak pengurusan.<br /><br />
		
		<br /><br />Terima kasih
		<br />Pengurusan FKP.
		
		')
		->send();
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
