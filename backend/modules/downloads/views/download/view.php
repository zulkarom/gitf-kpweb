<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\downloads\models\Download */

$this->title = $model->nric;
$this->params['breadcrumbs'][] = ['label' => 'Downloads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="download-view">

    <p>
	<?= Html::a('List', ['index', 'id' => $model->id], ['class' => 'btn btn-info']) ?>  
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
	<div class="box-body"><?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		'category.category_name',
		'nric',
		
        ],
    ]) ?></div>
	</div>

</div>
