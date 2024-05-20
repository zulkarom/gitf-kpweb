<?php

use backend\modules\protege\models\CompanyOffer;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\protege\models\CompanyOfferSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Company Offers: ' . $session->session_name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-offer-index">

<div class="box box-solid">
<div class="box-header">
</div>
<div class="box-body">

<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-6">
<?=$form->field($offer, 'companies')->widget(Select2::classname(), [
                'data' => $offer->listActiveCompaniesNotAdded($session->id),
                'options' => ['multiple' => true,'placeholder' => 'Select companies'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])?>
    </div>
    <div class="col-md-3"><?= $form->field($offer, 'available_slot')->textInput() ?></div><div class="col-md-3"><?= $form->field($offer, 'is_published')->dropDownList(CompanyOffer::getPublishArray()) ?></div>
</div>
    

<div class="form-group">
        
<?= Html::submitButton('Add Companies', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div></div>







    <div class="box">
    <div class="box-header">
    </div>
    <div class="box-body">
    <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
                //'label' =>'Institution',
                'label' => 'Company',
                'value' => function($model){
                    return $model->company->company_name;
                }
            ],
            [
                'label' => 'Available Slot',
                'format' => 'html',
                'value' => function($model){
                    return $model->availableText();
                }
            ],
            [
                'label' => 'Registration',
                'value' => function($model){
                    return $model->sumRegistered();
                }
            ],
            [
                'label' => 'status',
                'format' => 'html',
                'value' => function($model){
                    return $model->publishLabel;
                }
            ],

            ['class' => 'yii\grid\ActionColumn',
         
                            'template' => '{view} {update} {delete}',
                            //'visible' => false,
                            'buttons'=>[
                                'view'=>function ($url, $model) {
                                    return Html::a('Registration',['/protege/student-registration/index', 'StudentRegistrationSearch[company_offer_id]' => $model->id],['class'=>'btn btn-primary btn-sm']);
                                },
                                'update'=>function ($url, $model) {
                                    return Html::a('<span class="fa fa-edit"></span>',['update', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                                },
                                'delete'=>function ($url, $model) {
                                    return Html::a('<span class="fa fa-trash"></span>', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger btn-sm',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this data?',
                            'method' => 'post',
                        ],
                    ]) 
            ;
                                }
                            ],
                        
                        ],
        ],
    ]); ?>
    </div>
    </div></div>

    
</div>
