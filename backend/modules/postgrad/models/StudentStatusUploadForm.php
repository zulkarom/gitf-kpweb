<?php

namespace backend\modules\postgrad\models;

use yii\base\Model;
use yii\web\UploadedFile;

class StudentStatusUploadForm extends Model
{
    /** @var UploadedFile */
    public $file;

    public function rules()
    {
        return [
            [['file'], 'required'],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => ['csv'], 'checkExtensionByMimeType' => false, 'maxSize' => 10 * 1024 * 1024],
        ];
    }
}
