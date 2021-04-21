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
        return 'dwd_download';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'nric'], 'required'],
            [['category_id'], 'integer'],
            [['nric'], 'string', 'max' => 20],
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
            'matric_no' => 'NRIC',
        ];
    }
	

   
   public function getCategory()
   {
       return $this->hasOne(DownloadCategory::className(), ['id' => 'category_id']);
   }
}
