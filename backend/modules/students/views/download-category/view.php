<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\students\models\DownloadCategory */

$this->title = $model->category_name;
$this->params['breadcrumbs'][] = ['label' => 'Download Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="download-category-view">

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
	<div class="box-body"> <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		'id',
		'category_name',
		'is_default',
		'description:ntext',
		'created_at',
        ],
		]) ?>
	</div>
   </div>
</div>
