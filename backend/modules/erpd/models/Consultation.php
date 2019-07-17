<?php

namespace backend\modules\erpd\models;

use Yii;

/**
 * This is the model class for table "rp_consultation".
 *
 * @property int $id
 * @property int $csl_staff
 * @property string $csl_title
 * @property string $csl_funder
 * @property string $csl_amount
 * @property int $csl_level 1=local,2=international
 * @property string $date_start
 * @property string $date_end
 * @property string $csl_file
 */
class Consultation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rp_consultation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['csl_staff', 'csl_title', 'csl_funder', 'csl_amount', 'csl_level', 'date_start', 'date_end'], 'required'],
            [['csl_staff', 'csl_level'], 'integer'],
            [['csl_amount'], 'number'],
            [['date_start', 'date_end'], 'safe'],
            [['csl_title', 'csl_funder'], 'string', 'max' => 500],
            [['csl_file'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'csl_staff' => 'Csl Staff',
            'csl_title' => 'Consultation Title',
            'csl_funder' => 'Organizer/ sponsor/ funder/ collaborator',
            'csl_amount' => 'Value of Sponsorship (if applicable)',
            'csl_level' => 'Consultation Level',
            'date_start' => 'Join Date',
            'date_end' => 'End Date',
            'csl_file' => 'Consultation PDF File',
        ];
    }
	
	public function listLevel(){
		return [1=>'Local', 2 => 'International'];
	}
	
	public function getLevelName(){
		$arr = $this->listLevel();
		return $arr[$this->csl_level];
	}
}
