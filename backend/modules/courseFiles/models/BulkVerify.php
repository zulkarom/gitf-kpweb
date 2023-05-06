<?php

namespace backend\modules\courseFiles\models;

use Yii;

/**
 * This is the model class for table "sp_bulk_verify".
 *
 * @property int $id
 * @property int $semester_id
 * @property int $is_enabled
 * @property string $fk2_file
 * @property string $fk2_date
 * @property string $fk2_name
 * @property string $fk3_file
 * @property string $fk3_date
 * @property string $fk3_name
 * @property string $table4_file
 * @property string $table4_date
 * @property string $table4_name
 * @property string $fk2_position
 * @property string $fk3_position
 * @property string $table4_position
 */
class BulkVerify extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sp_bulk_verify';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['semester_id'], 'required'],
            [['semester_id', 'is_enabled'], 'integer'],
            [['fk2_file', 'fk3_file', 'table4_file', 'fk2_position', 'fk3_position', 'table4_position'], 'string'],
            [['fk2_date', 'fk3_date', 'table4_date'], 'safe'],
            [['fk2_name', 'fk3_name', 'table4_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'semester_id' => 'Semester ID',
            'is_enabled' => 'Is Enabled',
            'fk2_file' => 'Fk2 File',
            'fk2_date' => 'Fk2 Date',
            'fk2_name' => 'Fk2 Name',
            'fk3_file' => 'Fk3 File',
            'fk3_date' => 'Fk3 Date',
            'fk3_name' => 'Fk3 Name',
            'table4_file' => 'Table4 File',
            'table4_date' => 'Table4 Date',
            'table4_name' => 'Table4 Name',
            'fk2_position' => 'Fk2 Position',
            'fk3_position' => 'Fk3 Position',
            'table4_position' => 'Table4 Position',
        ];
    }
}
