<?php
namespace backend\modules\students\models;

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

    public function rules()
    {
        return [
			[['category'], 'required'],
			[['category'], 'integer'],
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'pdf', 'maxFiles' => 10000],
        ];
    }
	
	public function upload()
    {
        if ($this->validate()) {
			$path = \Yii::getAlias('@upload/student-download/'.$this->category.'/');
			
			
			if (!is_dir($path)) {
				FileHelper::createDirectory($path);
			}
			
            foreach ($this->imageFiles as $file) {
				
				$matric = $file->baseName;
				$student = Student::findOne(['matric_no' => $matric]);
				if($student){
					
					if(empty($student->nric)){
						ii::$app->session->addFlash('error', "Student Ic Number for (".$matric.") is empty. Make sure the the student ic number is set in student data!");
					}else{
						
						$curr = Download::findOne(['matric_no' => $matric, 'category_id' => $this->category]);
						if($curr){
							
							if($file->saveAs($path .  $file->baseName . '.' . $file->extension)){
								
								Yii::$app->session->addFlash('success', "A file for ". $student->st_name ." (". $matric .") has been successfully uploaded");
							}
						}else{
							
							$new = new Download;
							$new->matric_no = $matric;
							$new->created_at = new Expression('NOW()');
							$new->category_id = $this->category;
							$new->created_by = Yii::$app->user->identity->id;
							if($new->save()){
								if($file->saveAs($path .  $file->baseName . '.' . $file->extension)){
									Yii::$app->session->addFlash('success', "A file for ". $student->st_name ." (". $matric .") has been successfully uploaded");
								}
							}else{
								print_r($new->getErrors());
								die();
							}
						}
						
					}
					
				}else{
					Yii::$app->session->addFlash('error', "Student data for (".$matric.") not found. Make sure the student exist in the student data first.");
				}
                
            }
            return true;
        } else {
            return false;
        }
    }
}