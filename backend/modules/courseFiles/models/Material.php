<?php

namespace backend\modules\courseFiles\models;

use Yii;
use common\models\User;
use backend\modules\esiap\models\Course;
use backend\modules\teachingLoad\models\CourseOffered;

/**
 * This is the model class for table "cf_material".
 *
 * @property int $id
 * @property string $material_name
 * @property int $created_by
 * @property string $created_at
 */
class Material extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cf_material';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['material_name', 'course_id', 'created_by', 'mt_type', 'created_at'], 'required'],
            [['created_by', 'course_id', 'status'], 'integer'],
            [['created_at'], 'safe'],
            [['material_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'material_name' => 'Material Group Name',
            'created_by' => 'Created By',
            'created_at' => 'Date',
			'mt_type' => 'Type',
			'typeDesc' => 'Type',
			'statusName' => 'Status',
			'created_at' => 'Created At',
			'createdBy.fullname' => 'Created By',
			'course.codeCourseString' => 'Course'
        ];
    }
	
	public function getCreatedBy(){
		return $this->hasOne(User::className(), ['id' => 'created_by']);
	}
	
	public function getCourse(){
         return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }
	
	public function getStatusName(){
		if($this->status == 0){
			return '<span class="label label-warning">DRAFT</span>';
		}else if($this->status == 10){
			return '<span class="label label-info">SUBMIT</span>';
		}
	}
	
	public function getItems(){
         return $this->hasMany(MaterialItem::className(), ['material_id' => 'id']);
    }
    
    public function getCourseFile(){
        return $this->hasMany(CourseOffered::className(), ['material_version' => 'id']);
    }
    
    
    public function getSubmittedCourseFiles(){
        //return 'xxxxxxx';
        return CourseOffered::find()->alias('f')
        ->where(['f.material_version' => $this->id])
        ->andWhere(['not in', 'f.status', [0, 20]]) 
        ->all();
    }
    
    public function getEditable(){
       // return $this->submittedCourseFile;
        if($this->submittedCourseFiles){
            return false;
        }
        
        return true;
    }
    
    public function getEditableLabel(){
       // return $this->editable;
        //return $this->submittedCourseFile->count() ;
        
        if($this->submittedCourseFiles){
            //$count = count($this->submittedCourseFiles);
            return '<span class="label label-warning">NO</span>';
        }else{
            return '<span class="label label-success">YES</span>';
            
        }
    }
	
	public function getTypeDesc(){
		if($this->mt_type == 1){
			return 'Course File';
		}else if($this->mt_type == 2){
			return 'Others';
		}
	}
	
	public function flashError(){
        if($this->getErrors()){
            foreach($this->getErrors() as $error){
                if($error){
                    foreach($error as $e){
                        Yii::$app->session->addFlash('error', $e);
                    }
                }
            }
        }

    }



}
