<?php
use backend\models\Semester;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\date\DatePicker;

$this->title = 'Approval Letter';
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





<div class="form-group">
<p>
<?= Html::submitButton('Approve', ['class' => 'btn btn-success', 'name'=> 'actiontype', 'value' => 'approve']) ?>
&nbsp
<?= Html::submitButton('Back to Draft', ['class' => 'btn btn-primary', 'name'=> 'actiontype', 'value' => 'draft']) ?>
</p>

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
                'label' => 'Total Lecture',
                'value' => function($model){
                    return $model->countLecturesByStaff ;
                }
                
            ],

            [
                'label' => 'Total Tutorial',
                'value' => function($model){
                    return $model->countLecturesByStaff  ;
                }
                
            ],

            [
                'label' => 'Appointed',
                'value' => function($model){
                    return $model->appointed ;
                }
                
            ],

            [
                'label' => 'Status',
                'value' => function($model){
                    return $model->statusText;
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
