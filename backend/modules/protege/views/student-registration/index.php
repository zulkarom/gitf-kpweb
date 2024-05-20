<?php

use backend\modules\protege\models\OfferForm;
use backend\modules\protege\models\StudentRegistration;
use kartik\export\ExportMenu;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\protege\models\StudentRegistrationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Student Registrations: ' . $session->session_name;
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="form-group" style="text-align:right" align="right"> 
    <?php
$exportColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        'attribute' =>'company_offer_id',
        'value' => function($model){
            return $model->companyOffer->company->company_name;
        }
    ],
    'student_matric',
    'student_name',
    'program_abbr',
    'email:email',
    'phone',
    'register_at',
        ];
?>

<div style="display:none">
<?=ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $exportColumns,
    'filename' => 'PROTEGE_REGISTRATION_' . date('Y-m-d'),
    'onRenderSheet'=>function($sheet, $grid){
        $sheet->getStyle('A2:'.$sheet->getHighestColumn().$sheet->getHighestRow())
        ->getAlignment()->setWrapText(true);
    },
    'exportConfig' => [
        ExportMenu::FORMAT_EXCEL_X => false,
                ExportMenu::FORMAT_HTML => false,
                ExportMenu::FORMAT_CSV => false,
                ExportMenu::FORMAT_TEXT => false,
    ],
]);?>
</div>
<div class="form-group"> <button class="btn btn-success" id="dwl-exl"><i class="fa fa-download"></i> Download Excel</button></div>

<?php 
     $this->registerJs('
            $("#dwl-exl").click(function(){
                $("#w0-xls")[0].click();
            });
     ');
     ?>

</div>


<div class="box">
<div class="box-header">
</div>
<div class="box-body">
<div class="table-responsive">
<div class="student-registration-index">


<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        [
            'attribute' =>'company_offer_id',
            'filter' => Html::activeDropDownList($searchModel, 'company_id', OfferForm::listActiveCompanies(),['class'=> 'form-control','prompt' => 'Choose Company']),
            'value' => function($model){
                return $model->companyOffer->company->company_name;
            }
        ],
        
        'student_matric',
        'student_name',
        [
            'attribute' =>'program_abbr',
            'filter' => Html::activeDropDownList($searchModel, 'program_abbr', StudentRegistration::listPrograms(),['class'=> 'form-control','prompt' => 'Choose Program']),

        ],
        //'register_at',
        //'email:email',
        //'phone',

        ['class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {delete}',
                        //'visible' => false,
                        'buttons'=>[
                            'view'=>function ($url, $model) {
                                return Html::a('<span class="fa fa-eye"></span> View',['view', 'id' => $model->id],['class'=>'btn btn-primary btn-sm']);
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
</div>
</div></div>
