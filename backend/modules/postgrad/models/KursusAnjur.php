<?php

namespace backend\modules\postgrad\models;

use Yii;
use backend\modules\postgrad\models\KursusAnjur;
/**
 * This is the model class for table "kursus_anjur".
 *
 * @property int $id
 * @property string $kursus_siri
 * @property string $date_start
 * @property string $date_end
 * @property int $capacity
 * @property string $location
 * @property int $kursus_id
 */
class KursusAnjur extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kursus_anjur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kursus_siri', 'date_start', 'date_end', 'capacity', 'location', 'kursus_id'], 'required'],
            [['date_start', 'date_end'], 'safe'],
            [['capacity', 'kursus_id'], 'integer'],
            [['kursus_siri', 'location'], 'string', 'max' => 225],
            [['description'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kursus_siri' => 'Kursus Siri',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'capacity' => 'Capacity',
            'location' => 'Location',
            'kursus_id' => 'Kursus',
        ];
    }

    public function getKursus()
    {
        return $this->hasOne(Kursus::className(), ['id' => 'kursus_id']);
    }
    
    public function getPeserta(){
        return $this->hasMany(KursusPeserta::className(), ['anjur_id' => 'id']);
    }

    public function getCountPeserta($id){
        return KursusPeserta::find()
        ->where(['anjur_id' => $id])
        ->count();
    }
}
