<?php

namespace backend\modules\jeb\models;

use Yii;

/**
 * This is the model class for table "jeb_journal".
 *
 * @property int $id
 * @property int $volume
 * @property int $issue
 * @property int $status
 * @property string $description
 * @property string $published_at
 * @property string $archived_at
 */
class Journal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jeb_journal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['volume', 'issue', 'journal_name'], 'required', 'on' => 'create'],
			
            [['volume', 'issue', 'status'], 'integer'],
			
            [['description' , 'journal_name'], 'string'],
			
            [['published_at', 'archived_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'volume' => 'Volume',
            'issue' => 'Issue',
            'status' => 'Status',
            'description' => 'Description',
            'published_at' => 'Published At',
            'archived_at' => 'Archived At',
			'journal_name' => 'Journal Name',
        ];
    }
	
	public function journalStatus(){
		return [ 0 => 'Compiling', 10 => 'Forthcomming', 20 => 'Current Issue', 30 => 'Archived'];
	}
	
	public function statusLabel(){
		$status = $this->status;
		$color = 'warning';
		switch($status){
			case 20:$color = 'success';break;
			case 10:$color = 'info';break;
			case 30:$color = 'danger';break;
		}
		
		return '<span class="label label-'.$color.'">' . strtoupper($this->journalStatus()[$status]) . '</span>';
	}
	
	public static function listCompilingJournal(){
		return self::find()->where(['status' => 0])->limit(100)->all();
	}
	
	public static function listArchiveJournal(){
		return self::find()->where(['status' => 30])->all();
	}
	
	
	public function getJournalName(){
		return 'Volume ' . $this->volume . ' Issue ' . $this->issue;
	}
	
	public function getArticles()
    {
        return $this->hasMany(Article::className(), ['journal_id' => 'id'])->orderBy('publish_number ASC');
    }
	
	public function publishYear(){
		return date('Y', strtotime($this->published_at));
	}

	
	
}
