<?php

namespace backend\modules\downloads\models;

use Yii;

/**
 * This is the model class for table "st_download".
 *
 * @property int $id
 * @property int $category_id
 * @property string $matric_no
 */
class Download extends \yii\db\ActiveRecord
{
	public $folder;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'st_download';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'matric_no'], 'required'],
            [['category_id'], 'integer'],
            [['matric_no'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category',
            'matric_no' => 'Matric No',
        ];
    }
	
	public function getStudent()
   {
       return $this->hasOne(Student::className(), ['matric_no' => 'matric_no']);
   }
   
   public function getCategory()
   {
       return $this->hasOne(DownloadCategory::className(), ['id' => 'category_id']);
   }
}
