<?php

namespace backend\modules\postgrad\models;

use Yii;
use yii\helpers\ArrayHelper;
use backend\modules\staff\models\Staff;
use common\models\Common;

/**
 * This is the model class for table "pg_supervisor".
 *
 * @property int $id
 * @property int $staff_id
 * @property int $external_id
 * @property int $created_at
 * @property int $updated_at
 */

class Supervisor extends \yii\db\ActiveRecord
{
    public $fields;
    public $fullname;
    public $ex_name;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pg_supervisor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id', 'external_id', 'created_at', 'updated_at', 'is_internal'], 'integer'],
            
            [['staff_id', 'external_id'], 'unique'],
            
            ['fields', 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_internal' => 'Internal/External',
            'typeName' => 'Internal/External',
            'staff_id' => 'Staff',
            'external_id' => 'External',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'svName' => 'Supervisor / Examiner',
            'svFieldsString' => 'Fields'
        ];
    }
    
    public function listType(){
        return [
            1 => 'Internal',
            0 => 'External'
        ];
    }
    
    public function getTypeName(){
        $list = $this->listType();
        if(array_key_exists($this->is_internal, $list)){
            return $list[$this->is_internal];
        }
    }
    
    public function getSvName(){
        
        if($this->is_internal == 1){
            $staff = $this->staff;
            if($staff){
                
                return $staff->staff_title .' ' . $staff->user->fullname;
            }
        }else{
            $external = $this->external;
            if($external){
                return $external->ex_name;
            }
        }
    }

    public function getSvNamePlain(){
        
        if($this->is_internal == 1){
            $staff = $this->staff;
            if($staff){
                
                return $staff->user->fullname;
            }
        }else{
            $external = $this->external;
            if($external){
                return $external->ex_name;
            }
        }
    }
    
    public function getExternal(){
        return $this->hasOne(External::className(), ['id' => 'external_id']);
    }
    
    public function getStaff(){
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }
    
    public function getSvFields()
    {
        return $this->hasMany(SupervisorField::className(), ['sv_id' => 'id']);
    }
    
    public function getSupervisees()
    {
        return $this->hasMany(StudentSupervisor::className(), ['supervisor_id' => 'id']);
    }
    
    // helpers for counting supervisees by role
    public function getCountByRole($role)
    {
        return StudentSupervisor::find()
            ->where(['supervisor_id' => $this->id, 'sv_role' => $role])
            ->count();
    }
    
    public function getCountMain()
    {
        return $this->getCountByRole(1);
    }
    
    public function getCountSecond()
    {
        return $this->getCountByRole(2);
    }
    
    public function getCountTotal()
    {
        return StudentSupervisor::find()
            ->where(['supervisor_id' => $this->id])
            ->count();
    }
    
    public function getExaminees(){
        return Student::find()->alias('a')
        ->select('u.fullname, r.stage_name, s.status as stage_status')
        ->joinWith(['user u'])
        ->leftJoin('pg_student_stage s', 's.student_id = a.id')
        ->leftJoin('pg_stage_examiner e', 'e.stage_id = s.id')
        ->leftJoin('pg_res_stage r', 'r.id = s.stage_id')
        ->where(['e.examiner_id' => $this->id])
        ->all();
    }
    
    public function getSvFieldsArray(){
        return ArrayHelper::map($this->svFields, 'id', 'field_id');
    }
    
    public function getSvFieldNameArray(){
        return ArrayHelper::map($this->svFields, 'id', 'fieldName');
    }
    
    public function getSvFieldsString(){
        return Common::array2Str($this->getSvFieldNameArray());
    }
    
    
}
