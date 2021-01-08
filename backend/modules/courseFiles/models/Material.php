<?php

namespace backend\modules\courseFiles\models;

use Yii;
use common\models\User;
use backend\modules\esiap\models\Course;

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
            [['material_name', 'course_id', 'created_by', 'created_at'], 'required'],
            [['created_by', 'course_id'], 'integer'],
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
            'material_name' => 'Material Group',
            'created_by' => 'Created By',
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
	
	public function getItems(){
         return $this->hasMany(MaterialItem::className(), ['material_id' => 'id']);
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
