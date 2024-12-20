<?php

namespace backend\modules\esiap\models;

use Yii;
use backend\models\Department;
use backend\modules\staff\models\Staff;

/**
 * This is the model class for table "sp_course_access".
 *
 * @property int $id
 * @property int $staff_id
 * @property int $course_id
 * @property int $acc_order
 * @property string $updated_at
 *
 * @property Staff $staff
 * @property SpCourse $course
 */
class CourseAccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sp_course_access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['course_id'], 'required'],
            [['staff_id', 'course_id', 'acc_order'], 'integer'],
            [['updated_at'], 'safe'],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['staff_id' => 'id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Staff ID',
            'course_id' => 'Course ID',
            'acc_order' => 'Acc Order',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
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
    
    public static function hasAccess($offer){
        $staff_id = Yii::$app->user->identity->staff->id;
        
        if($offer->coor_access == 1 and $offer->coordinator == $staff_id){
            return true;
        }
        
        //KP 
        $course_id = $offer->course_id;
      
        if(Yii::$app->user->can('esiap-program-coor')){
            $program = Program::findOne(['head_program' => $staff_id]);
            if($program){
                $course = Course::findOne(['id' => $course_id, 'program_id' => $program->id]);
                if($course){
                    return true;
                }
            }
        }
        
        //KJ pulak 
        
        $department = Department::findOne(['head_dep' => $staff_id]);
        if($department){
            $course = Course::find()->alias('c')
            ->joinWith('program.department d')
            ->where(['c.id' => $course_id, 'd.id' => $department->id])
            ->one();
            if($course){
                return true;
            }
        }
        
        
        return false;
    }

}
