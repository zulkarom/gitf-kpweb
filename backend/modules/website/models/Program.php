<?php

namespace backend\modules\website\models;

use Yii;
use backend\modules\esiap\models\Program as SpProgram;

/**
 * This is the model class for table "web_program".
 *
 * @property int $id
 * @property int $program_id
 * @property string $summary
 * @property string $career
 */
class Program extends \yii\db\ActiveRecord
{
	public $rtype;
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'web_program';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['program_id'], 'required', 'on' => 'init'],
            [['id', 'program_id'], 'integer'],
            [['summary', 'career'], 'string'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'program_id' => 'Program ID',
            'summary' => 'Summary',
            'career' => 'Career',
        ];
    }
	
	public function getProgram(){
        return $this->hasOne(SpProgram::className(), ['id' => 'program_id']);
    }
	
	public static function syncProgram(){
		$list = SpProgram::find()->where(['faculty_id' => Yii::$app->params['faculty_id'], 'status' => 1])->all();
		if($list){
			foreach($list as $p){
				$id = $p->id;
				$web = self::findOne(['program_id' => $id]);
				if(!$web){
					$new = new Program;
					$new->scenario = 'init';
					$new->program_id = $id;
					$new->save();
					
				}
			}
		}
	}
	
	public function typeRequirement(){
		return [1 => ['STPM', 'STPM'], 2 => ['MATRIKULASI', 'MATRICULATION'], 3 => ['STAM', 'STAM'], 4 => ['DIPLOMA', 'DIPLOMA']];
	}
	
	public function getRequirements()
    {
        return $this->hasMany(ProgramRequirement::className(), ['program_id' => 'id'])->where(['req_type' => $this->rtype]);
    }
	
	public function listRequirements($type){
		return ProgramRequirement::find()->where(['program_id' => $this->id, 'req_type' => $type])->all();
	}

}
