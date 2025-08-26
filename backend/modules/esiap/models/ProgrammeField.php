<?php

namespace backend\modules\esiap\models;

use Yii;

/**
 * This is the model class for table "programme_fields".
 *
 * @property int $id
 * @property string $level          master | phd
 * @property string $bidang_malay   Field name in Malay
 * @property string $bidang_eng     Field name in English
 * @property string $study_mode     research | coursework
 * @property string $code           Programme code
 * @property int $program_id        Program group ID
 *
 * @property Program $program
 */
class ProgrammeField extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pg_program_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['level', 'bidang_malay', 'bidang_eng', 'study_mode', 'code', 'program_id'], 'required'],
            [['program_id'], 'integer'],
            [['level', 'study_mode', 'code'], 'string', 'max' => 20],
            [['bidang_malay'], 'string', 'max' => 100],
            [['bidang_eng'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level' => 'Level',
            'bidang_malay' => 'Field (BM)',
            'bidang_eng' => 'Field (EN)',
            'study_mode' => 'Study Mode',
            'code' => 'Programme Code',
            'program_id' => 'Program Group',
        ];
    }

    /**
     * Relation: Program this field belongs to
     * @return \yii\db\ActiveQuery
     */
    public function getProgram()
    {
        return $this->hasOne(Program::className(), ['id' => 'program_id']);
    }
}
