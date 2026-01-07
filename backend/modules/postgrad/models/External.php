<?php

namespace backend\modules\postgrad\models;

use Yii;
use backend\models\University;
use yii\helpers\ArrayHelper;
use backend\modules\postgrad\models\Supervisor;
use backend\modules\postgrad\models\SupervisorField;
use common\models\Common;

/**
 * This is the model class for table "pg_external".
 *
 * @property int $id
 * @property string $ex_name
 * @property string $inst_name
 * @property int $created_at
 * @property int $updated_at
 */
class External extends \yii\db\ActiveRecord
{
    public $fields;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pg_external';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ex_name', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at', 'university_id'], 'integer'],
            [['ex_name'], 'string', 'max' => 200],
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
            'ex_name' => 'External Name',
            'university_id' => 'Institution',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    public function universityList(){
        $list = University::find()->select('id, uni_name')->all();
        return ArrayHelper::map($list, 'id', 'uni_name');
    }
    
    public function getUniversity(){
         return $this->hasOne(University::className(), ['id' => 'university_id']);
    }
    
    public function getUniversityName(){
        $uni = $this->university;
        if($uni){
            return $uni->uni_name;
        }
    }
    
    public static function listExternalArray(){
        $list = self::find()->all();
        return ArrayHelper::map($list, 'id', 'ex_name');
    }

    public function getSupervisor()
    {
        return $this->hasOne(Supervisor::className(), ['external_id' => 'id']);
    }

    public function getSvFields()
    {
        return $this->hasMany(SupervisorField::className(), ['sv_id' => 'id'])
            ->via('supervisor');
    }

    public function getSvFieldNameArray()
    {
        return ArrayHelper::map($this->svFields, 'id', 'fieldName');
    }

    public function getSvFieldsString()
    {
        return Common::array2Str($this->getSvFieldNameArray());
    }

}
