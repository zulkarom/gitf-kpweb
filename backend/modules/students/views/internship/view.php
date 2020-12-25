<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\students\models\InternshipList */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Internship Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="internship-list-view">



    <p>
	<?= Html::a('Download Letter', ['download-letter', 'id' => $model->id], ['class' => 'btn btn-info', 'target' => '_blank']) ?>
	
	
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
            'name',
            'matrik',
            'nric',
            'program',
            'jilid',
            'surat',
		
        ],
    ]) ?></div>
</div>


</div>
