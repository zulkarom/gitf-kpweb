<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use common\models\Common;
use kartik\select2\Select2;
use common\models\Country;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use backend\models\Semester;
/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StudentPostGrad */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'My Profile';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">
<div class="card-body">  



<div class="row">
	<div class="col-md-6"> <?= DetailView::widget([
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
                'label' => 'Emel Pelajar',
                'value' => function($model){
                return $model->user->email;
                }
            ],
            'current_sem',
            'campus.campus_name',
            'program_code',
            [
                'label' => 'Taraf Pengajian',
                'value' => function($model){
                return $model->studyModeText;
                }
            ],
            'admission_year',
            [
                'label' => 'Tahun Kemasukan ',
                'value' => function($model){
                return date('d F Y', strtotime($model->admission_date));
                }
                ],
            [
                'label' => 'Pembiayaan Sendiri',
                'value' => function($model){
                return $model->sponsor;
                }
            ],
            [
                'label' => 'Sesi Masuk',
                'value' => function($model){
                return $model->semester->longFormat();
                }
            ],
            
            [
                'label' => 'Status Pelajar',
                'value' => function($model){
                return $model->stdStatusText;
                }
            ],
            [
                'label' => 'Negara Asal',
                'value' => function($model){
                return $model->country->country_name;
                }
                ],

            
        ],
    ]) ?></div>
	<div class="col-md-6">
	
	
	 <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

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
                'label' => 'Kewarganegaraan',
                'value' => function($model){
                    return $model->citizenText;
                }
            ],
            
            'address',
            'city',
            'phone_no',
            'personal_email',
           
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
            'bachelor_university',
            'bachelor_cgpa',
            'bachelor_year',

            
        ],
    ]) ?>
	
	 </div>
</div>


 
</div>
</div>