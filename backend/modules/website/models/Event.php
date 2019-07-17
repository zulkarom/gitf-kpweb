<?php

namespace backend\modules\website\models;

use Yii;
use yii\db\Expression;
use common\models\User;


	/**
* This is the model class for table "web_event".
*
* @property int $id
* @property string $name
* @property string $event_date
* @property string $date_start
* @property string $date_end
* @property string $time_start
* @property string $time_end
* @property string $created_at
* @property string $city
* @property string $venue
* @property string $register_link
* @property string $intro_promo
* @property string $promoimg_file
* @property string $newsimg_file
* @property string $report_1
* @property string $report_2
* @property string $image_top
* @property string $image_middle
* @property string $image_bottom
* @property int $created_by
* @property string $updated_at
* @property string $venue
* @property string $register_link
* @property string $introduction
* @property string $created_at
*/

class Event extends \yii\db\ActiveRecord
{
	public $promoimg_instance;
	public $newsimg_instance;
	public $brochure_instance;
	public $imagetop_instance;
	public $imagemiddle_instance;
	public $imagebottom_instance;
	public $file_controller;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'web_event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required', 'on' => 'create'],
			
			//[['id', 'name', 'event_date', 'time_start', 'time_end', 'created_at', 'created_by', 'updated_at', 'venue', 'register_link', 'introduction'], 'required', 'on' => 'create'],
			
            [['id', 'created_by', 'publish_promo', 'publish_report'], 'integer'],
			
            [['date_start', 'date_end', 'time_start', 'time_end', 'created_at', 'updated_at'], 'safe'],
			
			
            [['register_link', 'intro_promo', 'contact_pic', 'city', 'report_1', 'report_2'], 'string'],
			
            [['name', 'venue'], 'string', 'max' => 200],
			
			[['promoimg_file'], 'required', 'on' => 'promoimg_upload'],
            [['promoimg_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png', 'maxSize' => 5000000],
            [['updated_at'], 'required', 'on' => 'promoimg_delete'],
			
			[['newsimg_file'], 'required', 'on' => 'newsimg_upload'],
            [['newsimg_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png', 'maxSize' => 5000000],
            [['updated_at'], 'required', 'on' => 'newsimg_delete'],
			
			[['imagetop_file'], 'required', 'on' => 'imagetop_upload'],
            [['imagetop_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png', 'maxSize' => 5000000],
            [['updated_at'], 'required', 'on' => 'imagetop_delete'],
			
			[['imagemiddle_file'], 'required', 'on' => 'imagemiddle_upload'],
            [['imagemiddle_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png', 'maxSize' => 5000000],
            [['updated_at'], 'required', 'on' => 'imagemiddle_delete'],
			
			[['imagebottom_file'], 'required', 'on' => 'imagebottom_upload'],
            [['imagebottom_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png', 'maxSize' => 5000000],
            [['updated_at'], 'required', 'on' => 'imagebottom_delete'],
			
			[['brochure_file'], 'required', 'on' => 'brochure_upload'],
            [['brochure_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png', 'maxSize' => 5000000],
            [['updated_at'], 'required', 'on' => 'brochure_delete'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Event Name',
            'event_date' => 'Event Date',
            'time_start' => 'Time Start',
            'time_end' => 'Time End',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'venue' => 'Venue',
			
			'promoimg_file' => 'Front Promotion Image',
			'newsimg_file' => 'Front News Image',
            'register_link' => 'Register Link',
            'introduction' => 'Introduction',
			
			'imagetop_file' => 'News Top Image',
			'imagemiddle_file' => 'News Middle Image',
			'imagebottom_file' => 'News Bottom Image',
			
			'target_participant' => 'Target Participant',
           'fee' => 'Fee',
           'objective' => 'Objective',
           'register_deadline' => 'Registration Deadline',
           'contact_pic' => 'Contact Person',
           'brochure_file' => 'Brochure File',
           'speaker' => 'Speaker',
		   
		    'publish_promo' => 'Publish to Upcoming Event',
			 'publish_report' => 'Publish to Latest News',
			 
			 'report_1' => 'Report Part One',
			 'report_2' => 'Report Part Two',
		   
        ];
    }
	
	public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

	
	
	public static function upcomingEvent(){
		return self::find()
		->where(['publish_promo' => 1])
		->andWhere(['>=', 'date_start', new Expression('NOW()')])
		->limit(4)
		->orderBy('date_start ASC')
		->all();
	}
	
	public static function latestNews(){
		return self::find()
		->where(['publish_report' => 1])
		->andWhere(['<=', 'date_end', new Expression('NOW()')])
		->limit(4)
		->orderBy('date_start DESC')
		->all();
	}
}
