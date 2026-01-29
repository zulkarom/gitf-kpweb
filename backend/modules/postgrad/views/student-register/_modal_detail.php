<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\modules\postgrad\models\StudentRegister;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StudentRegister */

?>

<div class="student-register-modal-detail">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Student',
                'value' => $model->studentName,
            ],
            [
                'label' => 'Semester',
                'value' => $model->semesterName,
            ],
            [
                'attribute' => 'status_daftar',
                'format' => 'raw',
                'value' => StudentRegister::statusDaftarOutlineLabel($model->status_daftar),
            ],
            [
                'attribute' => 'status_aktif',
                'value' => StudentRegister::statusAktifText($model->status_aktif),
            ],
            'date_register:date',
            'fee_amount',
            'fee_paid_at:date',
            'remark:ntext',
        ],
    ]) ?>

    <div style="margin-top:12px">
        <?= Html::a('Open Full Page', ['student-register/view', 'id' => $model->id], ['class' => 'btn btn-default btn-sm', 'target' => '_blank']) ?>
    </div>

</div>
