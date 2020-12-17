<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\TmplAppointment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tmpl Appointments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tmpl-appointment-view">

   <p>
    <?= Html::a('List', ['index'], ['class' => 'btn btn-success']) ?> 
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'template_name',
            'dekan',
            'yg_benar:ntext',
            'tema:ntext',
            'per1:ntext',
            'signiture_file:ntext',
            'created_at',
            'updated_at',
        ],
    ]) ?>
    </div>
</div>

</div>
