<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\staff\models\Staff */

$this->title = trim($model->staff_no . ' - ' . $model->staff_title . ' ' . $model->staff_name);
$this->params['breadcrumbs'][] = ['label' => 'Staff', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-view">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
            <div class="box-tools pull-right">
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger btn-sm',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        </div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'label' => 'Staff No',
                        'value' => $model->staff_no,
                    ],
                    [
                        'label' => 'Name',
                        'value' => trim($model->staff_title . ' ' . $model->staff_name),
                    ],
                    [
                        'attribute' => 'staff_email',
                        'format' => 'email',
                    ],
                    [
                        'attribute' => 'personal_email',
                        'format' => 'email',
                    ],
                    [
                        'label' => 'Position',
                        'format' => 'raw',
                        'value' => $model->positionLabel,
                    ],
                    [
                        'label' => 'Type',
                        'format' => 'raw',
                        'value' => $model->typeLabel,
                    ],
                    [
                        'label' => 'Position Status',
                        'format' => 'raw',
                        'value' => $model->positionStatusLabel,
                    ],
                    [
                        'label' => 'Working Status',
                        'format' => 'raw',
                        'value' => $model->workingStatusLabel,
                    ],
                    'staff_edu',
                    'staff_expertise',
                    'staff_interest:ntext',
                    'staff_gscholar',
                    'officephone',
                    'handphone1',
                    'handphone2',
                    'ofis_location',
                    'staff_note:ntext',
                    [
                        'attribute' => 'leave_start',
                        'visible' => (string)$model->leave_start !== '',
                    ],
                    [
                        'attribute' => 'leave_end',
                        'visible' => (string)$model->leave_end !== '',
                    ],
                    [
                        'attribute' => 'leave_note',
                        'format' => 'ntext',
                        'visible' => (string)$model->leave_note !== '',
                    ],
                ],
            ]) ?>
        </div>
    </div>

</div>
