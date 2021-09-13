<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StudentPostGrad */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Student Post Grads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="student-post-grad-view">

    <h1><?= Html::encode($this->title) ?></h1>

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'matric_no',
            'name',
            'nric',
            'date_birth',
            'gender',
            'marital_status',
            'nationality',
            'citizenship',
            'prog_code',
            'edu_level',
            'address',
            'city',
            'phone_no',
            'personal_email:email',
            'student_email:email',
            'religion',
            'race',
            'bachelor_name',
            'university_name',
            'bachelor_cgpa',
            'bachelor_year',
            'session',
            'admission_year',
            'admission_date_sem1',
            'sponsor',
            'student_current_sem',
            'city_campus',
            'student_status',
        ],
    ]) ?>

</div>
