<?php

namespace backend\modules\esiap\models;

use Yii;

/**
 * This is the model class for table "sp_course_version".
 *
 * @property int $id
 * @property int $course_id
 * @property string $version_name
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_active
 */
class CourseVersion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_course_version';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'version_name', 'created_by', 'created_at', 'is_active'], 'required'],
			
            [['course_id', 'created_by', 'is_active'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['version_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'course_id' => 'Course ID',
            'version_name' => 'Version Name',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_active' => 'Is Active',
        ];
    }
	
	public function getClos()
    {
        return $this->hasMany(CourseClo::className(), ['crs_version_id' => 'id'])->orderBy('id ASC');
    }
	
/* 	public function getCloAssessments(){
		return self::find()
        ->select('sp_course_clo.clo_text')
        ->where(['sp_course_version.id' => $this->id, 'is_active' => 1])
        ->innerJoin('sp_course_clo', 'sp_course_clo.crs_version_id = sp_course_version.id')
		->innerJoin('sp_course_clo_assess', 'sp_course_clo.id = sp_course_clo_assess.clo_id')
        ->all();

	} */
	
	public function putOneCloAssessment(){
		$clos = $this->clos;
		if($clos){
			foreach($clos as $clo){
				$assess = $clo->cloAssessments;
				if(!$assess){
					//put one
					$assess = new CourseCloAssessment;
					$assess->scenario = 'fresh';
					$assess->clo_id = $clo->id;
					if($assess->save()){
						return true;
					}
					
				}
			}
		}
		return false;
	}
	
	public function getAssessments()
    {
		return $this->hasMany(CourseAssessment::className(), ['crs_version_id' => 'id'])->orderBy('id ASC');
        
    }
	
	public function getAssessmentDirect()
    {
		return $this->hasMany(CourseAssessment::className(), ['crs_version_id' => 'id'])->orderBy('id ASC')->innerJoin('sp_assessment_cat', 'sp_assessment_cat.id = sp_course_assessment.assess_cat')->where(['sp_assessment_cat.is_direct' => 1]);
        
    }
	
	public function getAssessmentIndirect()
    {
		return $this->hasMany(CourseAssessment::className(), ['crs_version_id' => 'id'])->orderBy('id ASC')->innerJoin('sp_assessment_cat', 'sp_assessment_cat.id = sp_course_assessment.assess_cat')->where(['sp_assessment_cat.is_direct' => 0]);
        
    }
	
	
	public function getSyllabus()
    {
        return $this->hasMany(CourseSyllabus::className(), ['crs_version_id' => 'id'])->orderBy('id ASC');
    }
	
	public function getReferences()
    {
        return $this->hasMany(CourseReference::className(), ['crs_version_id' => 'id'])->orderBy('id ASC');
    }
	

	public function getCourse(){
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }

	public function getSlt(){
		CourseSlt::checkSlt($this->id);
        return $this->hasOne(CourseSlt::className(), ['crs_version_id' => 'id']);
    }
	
	public function getSltAs(){
		CourseSltAs::checkSltAs($this->id);
        return $this->hasOne(CourseSlt::className(), ['crs_version_id' => 'id']);
    }
	

}
