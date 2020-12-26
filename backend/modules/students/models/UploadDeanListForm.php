<?php
namespace backend\modules\students\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadDeanListForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFiles;
	public $semester;

    public function rules()
    {
        return [
			[['semester'], 'required'],
			[['semester'], 'integer'],
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf', 'maxFiles' => 10000],
        ];
    }
	
	public function upload()
    {
        if ($this->validate()) {
			$path = \Yii::getAlias('@upload/deanlist/'.$this->semester.'/');
            foreach ($this->imageFiles as $file) {
                $file->saveAs($path .  $file->baseName . '.' . $file->extension);
            }
            return true;
        } else {
            return false;
        }
    }
}