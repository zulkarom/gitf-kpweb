<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\students\models\Student */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="student-view">

 

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
		'matric_no',
		'nric',
		'st_name',
		'program',
		'is_active',
        ],
    ]) ?></div>
</div>

</div>
