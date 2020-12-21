<?php

namespace backend\modules\teachingLoad\models;

use Yii;

/**
 * This is the model class for table "tld_tmpl_appoint".
 *
 * @property int $id
 * @property string $template_name
 * @property string $dekan
 * @property string $yg_benar
 * @property string $tema
 * @property string $per1
 * @property string $signiture_file
 * @property string $created_at
 * @property string $updated_at
 */
class TmplAppointment extends \yii\db\ActiveRecord
{
    public $signiture_instance;
    public $file_controller;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tld_tmpl_appoint';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['yg_benar', 'tema', 'per1', 'signiture_file'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['template_name'], 'string', 'max' => 200],
            [['dekan'], 'string', 'max' => 100],

            [['adj_y'], 'number'],

            [['signiture_file'], 'required', 'on' => 'signiture_upload'],
            [['signiture_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png', 'maxSize' => 5000000],
            [['updated_at'], 'required', 'on' => 'signiture_delete'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'template_name' => 'Nama Template',
            'dekan' => 'Nama Dekan',
            'yg_benar' => 'Yang menjalanakan tugas',
            'tema' => 'Daulat Raja',
            'per1' => 'Perkara 1',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}