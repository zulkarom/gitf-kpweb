<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\KursusPeserta */

$this->title = $model->user->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Pendaftaran Kursus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="box">
<div class="box-body">
<div class="kursus-peserta-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // [
            //  'label' => 'Nama',
            //  'value' => function($model){
            //     return $model->user->fullname;
            //  }
            // ],
            [
             'label' => 'Kursus',
             'value' => function($model){
                return $model->kursusAnjur->kursus->kursus_name.' - '.$model->kursusAnjur->kursus_siri;
             }
            ],
            [
             'label' => 'Date Start',
             'value' => function($model){
                return date('d F Y', strtotime($model->kursusAnjur->date_start));
             }
            ],
            [
             'label' => 'Date End',
             'value' => function($model){
                return date('d F Y', strtotime($model->kursusAnjur->date_end));
             }
            ],
            [
             'label' => 'Capacity',
             'value' => function($model){
                return $model->kursusAnjur->capacity;
             }
            ],
            [
             'format' => 'html',
             'label' => 'Status',
             'value' => function($model){
                if($model->status == 10){
                    return '<span class="label label-info">'.$model->statusText.'</span>';
                }else if($model->status == 20){
                    return '<span class="label label-primary">'.$model->statusText.'</span>';
                }else if($model->status == 30){
                    return '<span class="label label-success">'.$model->statusText.'</span>';
                }else{
                    return '<span class="label label-danger">'.$model->statusText.'</span>';
                }
             }
            ],
        ],
    ]) ?>

    <p>
        <?php if($model->status == 10): ?>
           <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
    </p>

</div>
</div>
</div>