<?php

namespace backend\modules\manual\models;

use Yii;

/**
 * This is the model class for table "mnl_section".
 *
 * @property int $id
 * @property int $module_id
 * @property string $section_name
 */
class Section extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mnl_section';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['module_id'], 'required'],
            [['module_id'], 'integer'],
            [['section_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module_id' => 'Module ID',
            'section_name' => 'Section Name',
        ];
    }
}
