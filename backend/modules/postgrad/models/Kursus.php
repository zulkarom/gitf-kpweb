<?php

namespace backend\modules\postgrad\models;

use Yii;
use backend\modules\postgrad\models\KursusKategori;
/**
 * This is the model class for table "kursus".
 *
 * @property int $id
 * @property string $kursus_name
 * @property int $kategori_id
 */
class Kursus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pg_kursus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kursus_name', 'kategori_id'], 'required'],
            [['kategori_id'], 'integer'],
            [['kursus_name'], 'string', 'max' => 225],
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
            'kursus_name' => 'Kursus Name',
            'kategori_id' => 'Kategori ID',
        ];
    }

     public function getKursusKategori()
    {
        return $this->hasOne(KursusKategori::className(), ['id' => 'kategori_id']);
    }

    public function flashError(){
        if($this->getErrors()){
            foreach($this->getErrors() as $error){
                if($error){
                    foreach($error as $e){
                        Yii::$app->session->addFlash('error', $e);
                    }
                }
            }
        }

    }
}
