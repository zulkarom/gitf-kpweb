<?php

namespace backend\modules\aduan\models;

use Yii;

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
            [['name', 'nric', 'address', 'email', 'phone', 'topic_id', 'title', 'aduan', 'declaration', 'captcha', 'progress_id', 'created_at', 'updated_at'], 'required'],
            ['email', 'email'],
            [['address', 'aduan', 'upload_url'], 'string'],
            [['id','declaration', 'progress_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'email', 'title', 'captcha'], 'string', 'max' => 225],
            [['nric', 'phone'], 'string', 'max' => 20],
            [['topic_id'], 'string', 'max' => 100],
            [['upload_url'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg,gif,zip,pdf'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Aduan Id',
            'name' => 'Name',
            'nric' => 'IC Number',
            'address' => 'Address',
            'email' => 'Email',
            'phone' => 'Phone',
            'topic_id' => 'Topic',
            'title' => 'Title',
            'aduan' => 'Aduan',
            'declaration' => 'Declaration',
            'upload_url' => 'Upload File',
            'captcha' => 'Captcha',
            'progress_id' => 'Progress',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getTopic(){
        return $this->hasOne(AduanTopic::className(), ['id' => 'topic_id']);
    }

    public function getProgress(){
        return $this->hasOne(AduanProgress::className(), ['id' => 'progress_id']);
    }

    
}
