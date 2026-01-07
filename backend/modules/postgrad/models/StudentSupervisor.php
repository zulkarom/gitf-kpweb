<?php

namespace backend\modules\postgrad\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "pg_student_sv".
 *
 * @property int $id
 * @property int $supervisor_id
 * @property string $appoint_at
 * @property int $is_active
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
            [['supervisor_id', 'sv_role', 'student_id', 'is_active'], 'integer'],
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
            'is_active' => 'Active',
            'appoint_at' => 'Appoint At',
        ];
    }
    
    public function getSupervisor(){
         return $this->hasOne(Supervisor::className(), ['id' => 'supervisor_id']);
    }
    
    public function getStudent(){
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
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
    
    public static function isActiveColorMap()
    {
        return [
            1 => 'success',  // Active
            0 => 'default',  // Inactive
        ];
    }

    public static function isActiveText($code)
    {
        return ((int)$code === 1) ? 'Active' : 'Inactive';
    }

    public static function isActiveLabel($code)
    {
        $int = (int)$code;
        $text = self::isActiveText($int);
        $map = self::isActiveColorMap();
        $color = array_key_exists($int, $map) ? $map[$int] : 'default';
        return Html::tag('span', $text, ['class' => 'label label-' . $color]);
    }

    public function getIsActiveLabel()
    {
        return self::isActiveLabel($this->is_active);
    }
    
    public static function supervisorListArray(){
        $list = Supervisor::find()->alias('a')
            ->select('a.id, u.fullname, x.ex_name, a.is_internal')
            // use LEFT JOIN for staff/user so external supervisors (no staff) are kept
            ->joinWith(['staff.user u'], false, 'LEFT JOIN')
            ->joinWith(['external x'])
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
