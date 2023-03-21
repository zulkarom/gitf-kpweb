<?php
namespace backend\modules\downloads\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\db\Expression;

class UploadDownloadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFiles;
	public $category;
	public $nric;

    public function rules()
    {
        return [
			[['category'], 'required'],
			[['category'], 'integer'],
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf', 'maxFiles' => 10],
        ];
    }
	
	public function upload()
    {
        if ($this->validate()) {
			$path = \Yii::getAlias('@upload/external-download/'.$this->category.'/');
			
			
			if (!is_dir($path)) {
				FileHelper::createDirectory($path);
			}
			
            foreach ($this->imageFiles as $file) {
				$nric = trim($file->baseName);
				$nric = str_replace(" ", "", $nric);
						
				$curr = Download::findOne(['nric' => $nric, 'category_id' => $this->category]);
				if($curr){
					
					if($file->saveAs($path .  $file->baseName . '.' . $file->extension)){
						
						Yii::$app->session->addFlash('success', "A file for ". $nric." has been successfully uploaded");
					}
				}else{
					
					$new = new Download;
					$new->nric = $nric;
					$new->created_at = new Expression('NOW()');
					$new->category_id = $this->category;
					$new->created_by = Yii::$app->user->identity->id;
					if($new->save()){
						if($file->saveAs($path .  $file->baseName . '.' . $file->extension)){
							Yii::$app->session->addFlash('success', "A file for ". $nric." has been successfully uploaded");
						}
					}else{
						print_r($new->getErrors());
						die();
					}
				}
						

					
				
                
            }
            return true;
        } else {
            return false;
        }
    }
}