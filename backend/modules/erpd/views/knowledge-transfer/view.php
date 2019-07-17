<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\KnowledgeTransfer */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Knowledge Transfers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="knowledge-transfer-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'ktp_title',
            'staff_id',
            'date_start',
            'date_end',
            'ktp_research',
            'ktp_community',
            'ktp_source',
            'ktp_amount',
            'ktp_description:ntext',
            'ktp_file',
            'reminder',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
