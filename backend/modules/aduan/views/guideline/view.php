<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\aduan\models\Guideline */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Guidelines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="guideline-view">


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

<div class="box">
<div class="box-header"></div>
<div class="box-body">    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'guideline_text:ntext',
        ],
    ]) ?></div>
</div>


</div>
