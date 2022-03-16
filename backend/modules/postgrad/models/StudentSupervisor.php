<?php

namespace backend\modules\postgrad\models;

use Yii;

/**
 * This is the model class for table "pg_student_sv".
 *
 * @property int $id
 * @property int $supervisor_id
 * @property string $appoint_at
 */
class StudentSupervisor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pg_student_sv';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['supervisor_id', 'student_id'], 'required'],
            [['supervisor_id', 'sv_role', 'student_id'], 'integer'],
            [['appoint_at'], 'safe'],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'supervisor_id' => 'Supervisor',
            'sv_role' => 'Role',
            'appoint_at' => 'Appoint At',
        ];
    }
    
    public function getSupervisor(){
         return $this->hasOne(Supervisor::className(), ['id' => 'supervisor_id']);
    }

    
    public function roleList(){
        return [
            1 => 'Main',
            2 => 'Second',
            3 => 'Third'
        ];
        
    }
    
    public function roleName(){
        $list = $this->roleList();
        if(array_key_exists($this->sv_role, $list)){
            return $list[$this->sv_role];
        }
    }
    
    public function supervisorListArray(){
        $list =Supervisor::find()->alias('a')
        ->select('a.id, u.fullname, x.ex_name, a.is_internal')
        ->joinWith(['staff.user u', 'external x'])
        ->all();
        $array = array();
        if($list){
            foreach($list as $s){
                if($s->is_internal == 1){
                    $name = $s->fullname;
                }else{
                    $name = $s->ex_name;
                }
                $array[$s->id] = $name;
            }
        }
        return $array;
    }
    
}
