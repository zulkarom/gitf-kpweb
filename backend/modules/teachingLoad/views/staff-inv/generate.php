<?php
use backend\models\Semester;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\date\DatePicker;

$this->title = 'Generate Reference ';
$this->params['breadcrumbs'][] = ['label' => 'Appointment Letter', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;



$form = ActiveForm::begin([
'id' => 'form-semester',
'method' => 'get',
]); ?>  
<div class="row">
    
<div class="col-md-5">
<?= $form->field($semester, 'semester_id')->dropDownList(
        Semester::listSemesterArray()
    )->label(false) ?>
    <input type="hidden" name="btn-action" id="btn-action" value="1" />
</div>
</div>
<?php
ActiveForm::end(); 
?>

<?php
$form = ActiveForm::begin([
'id' => 'form-reference'
]); ?>  

<div class="form-group">   


</div>

<div class="row">

<div class="col-md-12">


<div class="box">
<div class="box-body">


<div class="row">
<div class="col-md-4"><?=$form->field($model, 'ref_letter')?></div>
<div class="col-md-2"><?=$form->field($model, 'start_number')?></div>
<div class="col-md-3">
 <?=$form->field($model, 'date')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
]);
?>


</div>


</div>

<div class="form-group">
        
<?= Html::submitButton('Generate Reference', ['class' => 'btn btn-warning', 'name'=> 'actiontype', 'value' => 'generate']) ?>
    </div>

</div>
</div>




</div>
</div>

  <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'export' => false,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'yii\grid\SerialColumn'],
            
            
            [
                'label' => 'Staff',
                'value' => function($model){
                    return $model->staffInvolved->staff->staff_title . ' ' . $model->staffInvolved->staff->user->fullname ;
                }
                
            ],

            [
                'label' => 'Course',
                'value' => function($model){
                    return $model->courseOffered->course->codeCourseString ;
                }
                
            ],

            [
                'label' => 'Date',
                'value' => function($model){
					if($model->date_appoint == '0000-00-00'){
						return '';
					}else{
						return date('d M Y', strtotime($model->date_appoint)) ;
					}
                    
                }
                
            ],

            [
                'label' => 'Reference Letter',
                'value' => function($model){
                    return $model->ref_no ;
                }
                
            ],

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{surat}',
                //'visible' => false,
                'buttons'=>[
    
                    'surat'=>function ($url, $model) {

                        return '<a href="'.Url::to(['/teaching-load/appointment-letter/pdf/', 'id' => $model->id]).'" target="_blank" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-download-alt"></span></a>';
                    },
                ],
            
            ],
            
        ],
    ]); ?>
    </div>
</div>
<br />


<?php
ActiveForm::end(); 
?>

<?php 
$this->registerJs('

$("#semesterform-semester_id").change(function(){
  
    $("#form-semester").submit();
});

');

?>
