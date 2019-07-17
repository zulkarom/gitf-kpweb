<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\Award */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Awards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="award-view">


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
            'id',
            'awd_staff',
            'awd_name',
            'awd_level',
            'awd_type',
            'awd_by',
            'awd_date',
            'awd_file',
        ],
    ]) ?>

</div>
