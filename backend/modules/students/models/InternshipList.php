<?php

namespace backend\modules\students\models;

use Yii;

/**
 * This is the model class for table "li_senarai".
 *
 * @property int $id
 * @property string $name
 * @property string $matrik
 * @property string $nric
 * @property string $program
 * @property string $jilid
 * @property string $surat
 */
class InternshipList extends \yii\db\ActiveRecord
{
	
	public $folder = 'internship';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'li_senarai';
    }
	
	public function getMatric_no(){
		return $this->matrik;
	}

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
            [['matrik'], 'string', 'max' => 10],
            [['nric'], 'string', 'max' => 18],
            [['program'], 'string', 'max' => 82],
            [['jilid'], 'string', 'max' => 5],
            [['surat'], 'string', 'max' => 8],
			
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Student Name',
            'matrik' => 'Matric No.',
            'nric' => 'NRIC',
            'program' => 'Program',
            'jilid' => 'Jilid',
            'surat' => 'Surat',
        ];
    }
}
