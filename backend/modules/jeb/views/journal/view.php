<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\jeb\models\Journal */

$this->title = 'Volume ' . $model->volume . ' Issue ' . $model->issue;
$this->params['breadcrumbs'][] = ['label' => 'Journals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="journal-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

    </p>

    <div class="box">
<div class="box-body">

<style>
table.detail-view th {
    width:25%;
}
</style>


<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'volume',
            'issue',
            [
				'attribute' => 'status',
				'format' => 'html',
				'value' => function($model){
					return $model->statusLabel();
				}
			],
            'description:ntext',
        ],
    ]) ?></div>
</div>

</div>
