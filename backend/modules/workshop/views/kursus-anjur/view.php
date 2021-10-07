<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\KursusAnjur */

$this->title = 'View Workshop';
$this->params['breadcrumbs'][] = ['label' => 'Kursus Anjurs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body">
<div class="kursus-anjur-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'format' => 'html',
                'label' => 'Kursus Name',
                'value' => function($model){
                    return $model->kursus_name;
                    
                }
            ],
            'kursus_name',
            'date_start',
            'date_end',
            'capacity',
            'location',
        ],
    ]) ?>



</div>
</div>
</div>

<div class="box">
<div class="box-header"><b><h4>List of Participants</h4></b></div>
<div class="box-body">
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Participant Name',
                'value' => function($model){
                    return $model->user->fullname;
                    
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
    ]); ?>
</div>
</div>