<?php

namespace backend\modules\workshop\models;

use Yii;
use backend\modules\postgrad\models\KursusKategori;
use yii\helpers\ArrayHelper;
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
            'kursus_name' => 'Training Name',
            'kategori_id' => 'Category',
        ];
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
