<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StudentPostGrad */

$this->title = $model->user->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Postgraduate Students', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="student-post-grad-view">

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
<div class="box-body">  
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            [
                'label' => 'Name',
                'value' => function($model){
                    return $model->user->fullname;
                }
            ],
            'matric_no',
            'nric',
            [
                'label' => 'Tarikh Lahir',
                'value' => function($model){
                    return date('d F Y', strtotime($model->date_birth));
                }
            ],
            [
                'label' => 'Jantina',
                'value' => function($model){
                    return $model->genderText;
                }
            ],
            [
                'label' => 'Taraf Perkahwinan',
                'value' => function($model){
                    return $model->maritalText;
                }
            ],
            [
                'label' => 'Negara Asal',
                'value' => function($model){
                    return $model->country->country_name;
                }
            ],
            [
                'label' => 'Kewarganegaraan',
                'value' => function($model){
                    return $model->citizenText;
                }
            ],
            'prog_code',
            [
                'label' => 'Taraf Pengajian',
                'value' => function($model){
                    return $model->eduLvlText;
                }
            ],
            'address',
            'city',
            'phone_no',
            'personal_email:email',
            [
                'label' => 'Emel Pelajar',
                'value' => function($model){
                    return $model->user->email;
                }
            ],
            [
                'label' => 'Agama',
                'value' => function($model){
                    return $model->religionText;
                }
            ],
            [
                'label' => 'Bangsa',
                'value' => function($model){
                    return $model->raceText;
                }
            ],
            'bachelor_name',
            'university_name',
            'bachelor_cgpa',
            'bachelor_year',
            'session',
            'admission_year',
            [
                'label' => 'Tahun Kemasukan Semester 1',
                'value' => function($model){
                    return date('d F Y', strtotime($model->admission_date_sem1));
                }
            ],
            [
                'label' => 'Pembiayaan Sendiri / Tajaan',
                'value' => function($model){
                    return $model->sponsorText;
                }
            ],
            [
                'label' => 'Sesi Masuk',
                'value' => function($model){
                    return $model->semester->longFormat();
                }
            ],
            'student_current_sem',
            'city_campus',
            [
                'label' => 'Status Pelajar',
                'value' => function($model){
                    return $model->stdStatusText;
                }
            ],
        ],
    ]) ?>
</div>
</div>
</div>
