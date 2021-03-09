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

  <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'export' => false,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'yii\grid\SerialColumn'],
            
			[
                'label' => 'Reference & Date',
				'format' => 'html',
                'value' => function($model){
					$date = '';
					if($model->date_appoint <> '0000-00-00'){
						$date =  date('d M Y', strtotime($model->date_appoint));
					}
                    return $model->ref_no. '<br />' . $date;
                }
                
            ],
            
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
                'label' => 'Lectures',
                'value' => function($model){
                    return $model->countLecturesByStaff ;
                }
                
            ],

            [
                'label' => 'Tutorials',
                'value' => function($model){
                    return $model->countTutorialsByStaff  ;
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
				'format' => 'html',
                'value' => function($model){
                    return $model->statusLabel;
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
<div class="form-group">
<p>
<?= Html::submitButton('<i class="fa fa-check"></i> Approve', ['class' => 'btn btn-success', 'name'=> 'actiontype', 'value' => 'approve', 'data' => ['confirm' => 'Are you sure to approve the selected appointment letters']]) ?>
&nbsp
<?= Html::submitButton('Revert to Draft', ['class' => 'btn btn-warning', 'name'=> 'actiontype', 'value' => 'draft', 'data' => ['confirm' => 'Are you sure to revert the approval of the selected appointment letters']]) ?>
</p>

</div>


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
