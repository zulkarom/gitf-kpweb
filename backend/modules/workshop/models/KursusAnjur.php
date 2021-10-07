<?php

namespace backend\modules\workshop\models;

use Yii;
use yii\helpers\ArrayHelper;
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
        return 'pg_kursus_anjur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kursus_name', 'date_start', 'date_end', 'capacity', 'location', 'kategori_id'], 'required'],
            [['date_start', 'date_end'], 'safe'],
            [['capacity', 'kategori_id'], 'integer'],
            [['kursus_name', 'location'], 'string', 'max' => 225],
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
            'kursus_name' => 'Workshop Name',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'capacity' => 'Capacity',
            'location' => 'Location',
            'kategori_id' => 'Category',
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(KursusKategori::className(), ['id' => 'kategori_id']);
    }
    

    
    public function getCategoryList(){
        $list = KursusKategori::find()->all();
        return ArrayHelper::map($list, 'id' , 'kategori_name');
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
