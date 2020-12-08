<?php
namespace backend\modules\internship\models;

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
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf', 'maxFiles' => 20],
        ];
    }
	
	public function upload()
    {
        if ($this->validate()) { 
            foreach ($this->imageFiles as $file) {
                $file->saveAs('@upload/internship/' .  $file->baseName . '.' . $file->extension);
            }
            return true;
        } else {
            return false;
        }
    }
}