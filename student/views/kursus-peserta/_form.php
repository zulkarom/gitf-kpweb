<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\KursusKategori;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\jui\JuiAsset;
/* @var $this yii\web\View */
/* @var $model backend\models\KursusPeserta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kursus-peserta-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-10">
        <?= $form->field($model, 'kategori')->dropDownList(
            ArrayHelper::map(KursusKategori::find()->all(),'id', 'kategori_name'), ['class'=>'form-control kursus-select', 'prompt' => 'Pilih Kategori' ]
        )->label('Kursus Kategori')?>
        </div>
    </div>

    <br/>
    <div class="form-group">
        <?= Html::submitButton('Lihat Kursus', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

