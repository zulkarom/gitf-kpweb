<?php

namespace backend\modules\chapterinbook\models;

use Yii;

/**
 * This is the model class for table "proc_paper".
 *
 * @property int $id
 * @property int $proc_id
 * @property string $paper_title
 * @property string $author
 * @property int $paper_no
 * @property string $paper_page
 * @property string $paper_file
 */
class Paper extends \yii\db\ActiveRecord
{
	public $paper_instance;
	public $file_controller;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cp_chapter_paper';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['paper_title', 'paper_no'], 'required'],
            [['chap_id', 'paper_no'], 'integer'],
            [['paper_file'], 'string'],
            [['paper_title', 'author'], 'string', 'max' => 255],
            [['paper_page'], 'string', 'max' => 100],
			[['paper_file'], 'required', 'on' => 'paper_upload'],
            [['paper_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 10000000],
            [['updated_at'], 'required', 'on' => 'paper_delete'],

			
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'chap_id' => 'Proc ID',
            'paper_title' => 'Paper Title',
            'author' => 'Author',
            'paper_no' => 'Paper No',
            'paper_page' => 'Paper Page',
            'paper_file' => 'Paper File',
        ];
    }
	
	public function getChapterinbook(){
        return $this->hasOne(Chapterinbook::className(), ['id' => 'chap_id']);
    }

}
