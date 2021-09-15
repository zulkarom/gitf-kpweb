<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\KursusPeserta */

$this->title = $model->kursus->kursus_name;
$this->params['breadcrumbs'][] = ['label' => 'Pendaftaran Kursus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Kursus Anjur', 'url' => ['anjur', 'cid' => $model->kursus->kategori_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="box">
<div class="box-body">
<div class="kursus-anjur-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
             'label' => 'Nama Kursus',
             'value' => function($model){
                return $model->kursus->kursus_name;
             }
            ],
            [
             'label' => 'Kursus Siri',
             'value' => function($model){
                return $model->kursus_siri;
             }
            ],
            [
             'label' => 'Tarikh Mula',
             'value' => function($model){
                return date('d F Y', strtotime($model->date_start));
             }
            ],
            [
             'label' => 'Tarikh Tamat',
             'value' => function($model){
                return date('d F Y', strtotime($model->date_end));
             }
            ],
            [
             'label' => 'Kapasiti',
             'value' => function($model){
                return $model->capacity;
             }
            ],
            [
             'label' => 'Lokasi',
             'value' => function($model){
                return $model->location;
             }
            ],
            [
             'label' => 'Kursus Anjur Description',
             'value' => function($model){
                return $model->description;
             }
            ],
            [
             'label' => 'Kursus Description',
             'value' => function($model){
                return $model->kursus->description;
             }
            ],
            [
             'label' => 'Kursus Kategori Description',
             'value' => function($model){
                return $model->kursus->kursusKategori->description;
             }
            ],
            
        ],
    ]) ?>
    <p>
        <?= Html::a('Daftar Kursus', ['anjur-register', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

</div>
</div>
</div>