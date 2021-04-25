<?php
namespace backend\modules\downloads\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFiles;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf', 'maxFiles' => 10000],
        ];
    }
	
	public function upload()
    {
        if ($this->validate()) {
			$path = \Yii::getAlias('@upload/internship/');
            foreach ($this->imageFiles as $file) {
                $file->saveAs($path .  $file->baseName . '.' . $file->extension);
            }
            return true;
        } else {
            return false;
        }
    }
}