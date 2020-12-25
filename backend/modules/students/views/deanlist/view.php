<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\students\models\DeanList */

$this->title = $model->student->st_name;
$this->params['breadcrumbs'][] = ['label' => 'Dean Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="dean-list-view">


    <p>
	<?= Html::a('Back to List', ['index'], ['class' => 'btn btn-info']) ?>
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
            'semester_id',
            'matric_no',
			'student.st_name',
            'student.nric',
			'created_at:date',
        ],
    ]) ?>
</div>
</div>

</div>
