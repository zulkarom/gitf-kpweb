<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;
use backend\modules\postgrad\models\StudentStage;
use backend\modules\postgrad\models\ResearchStage;
use backend\models\Semester;
use backend\modules\postgrad\models\StudentRegister;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\Supervisor */

$this->title = 'View Supervisor / Examiner';
$semesterId = $semesterId ?? Yii::$app->request->get('semester_id');
$this->params['breadcrumbs'][] = ['label' => 'Supervisors', 'url' => ['index', 'semester_id' => $semesterId]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style>
table.detail-view th {
    width:15%;
}
</style>

<div class="supervisor-view">


<h3><i class="fa fa-user"></i> <?= $model->svName ?></h3>


<div class="row">
	<div class="col-md-4">


	
	     <div class="box">
<div class="box-header"></div>

<?php
$quickViewUrl = Url::to(['student-quick-view']);
$js = <<<JS
(function(){
  function loadStudentQuickView(studentId, semesterId){
    var url = '{$quickViewUrl}';
    var data = { student_id: studentId };
    if(semesterId !== undefined && semesterId !== null && semesterId !== ''){
      data.semester_id = semesterId;
    }
    var modal = $('#studentQuickViewModal');
    modal.find('.modal-body').html('Loading...');
    modal.modal('show');
    $.get(url, data)
      .done(function(html){
        modal.find('.modal-body').html(html);
      })
      .fail(function(){
        modal.find('.modal-body').html('Failed to load.');
      });
  }

  $(document).on('click', '.js-student-quick-view', function(e){
    e.preventDefault();
    var studentId = $(this).data('student-id');
    var semesterId = $(this).data('semester-id');
    if(!studentId){ return; }
    loadStudentQuickView(studentId, semesterId);
  });
})();
JS;
$this->registerJs($js);
?>

<div class="modal fade" id="studentQuickViewModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Student Quick View</h4>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>
<div class="box-body">
    <?php 
    $data[] = 'svName';
    $data[] = 'typeName';
        
        $data[] = 'svFieldsString';
    
    echo DetailView::widget([
        'model' => $model,
        'attributes' => $data,
    ]) ?>
    
    	<br />
	    <p>
<?= Html::a('Supervisors', ['index', 'semester_id' => $semesterId], ['class' => 'btn btn-default']) ?> 
<?= Html::a('Examination Committees', ['stage-examiner/index', 'supervisor_id' => $model->id], ['class' => 'btn btn-default']) ?>

        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?> 
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
</div>
	
	

	
	</div>
	<div class="col-md-8">

	<?php
		$semesterItems = Semester::listSemesterArray();
		$semesterItems = ['' => '- All Semester -'] + $semesterItems;
	?>

	<?php $formSem = \yii\widgets\ActiveForm::begin([
		'method' => 'get',
		'action' => ['view', 'id' => $model->id],
	]); ?>
	<?= Html::hiddenInput('id', $model->id) ?>
	<?= Html::hiddenInput('sv_name', $superviseeFilterModel->sv_name) ?>
	<?= Html::hiddenInput('sv_program_id', $superviseeFilterModel->sv_program_id) ?>
	<?= Html::hiddenInput('sv_role', $superviseeFilterModel->sv_role) ?>
	<?= Html::hiddenInput('sv_status_daftar', $superviseeFilterModel->sv_status_daftar) ?>
	<?= Html::hiddenInput('ex_name', $examineeFilterModel->ex_name) ?>
	<?= Html::hiddenInput('ex_stage_id', $examineeFilterModel->ex_stage_id) ?>
	<?= Html::hiddenInput('ex_committee_role', $examineeFilterModel->ex_committee_role) ?>
	<?= Html::hiddenInput('ex_result', $examineeFilterModel->ex_result) ?>
	<div class="row" style="margin-bottom:10px;">
		<div class="col-md-4">
			<?= $formSem->field($model, 'id')->dropDownList($semesterItems, [
				'name' => 'semester_id',
				'value' => $semesterId,
				'onchange' => 'this.form.submit();'
			])->label(false) ?>
		</div>
	</div>
	<?php \yii\widgets\ActiveForm::end(); ?>
	
	
	<div class="box">
<div class="box-header">
<h3 class="box-title">
Senarai Pelajar
</h3>
</div>
<div class="box-body">

<?= GridView::widget([
    'dataProvider' => $superviseeProvider,
    'filterModel' => $superviseeFilterModel,
    'filterUrl' => ['view', 'id' => $model->id, 'semester_id' => $semesterId],
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'label' => 'Matric No / Name',
            'attribute' => 'sv_name',
            'format' => 'raw',
            'filter' => Html::activeTextInput($superviseeFilterModel, 'sv_name', ['class' => 'form-control']),
            'value' => function($s) use ($semesterId) {
                if (!$s->student) {
                    return '';
                }
                $matricNo = (string)$s->student->matric_no;
                $fullname = $s->student->user ? (string)$s->student->user->fullname : '';
                $text = trim($matricNo . ' - ' . strtoupper($fullname), ' -');
                return Html::a($text, '#', [
                    'class' => 'js-student-quick-view',
                    'data-student-id' => $s->student->id,
                    'data-semester-id' => $semesterId,
                ]);
            }
        ],
        [
            'label' => 'Program',
            'attribute' => 'sv_program_id',
            'value' => function($s) {
                if (!$s->student || !$s->student->program) {
                    return '';
                }
                return $s->student->program->pro_name;
            },
            'filter' => Html::activeDropDownList(
                $superviseeFilterModel,
                'sv_program_id',
                (new \backend\modules\postgrad\models\Student())->listProgram(),
                ['class' => 'form-control', 'prompt' => '']
            ),
        ],
        [
            'label' => 'Role',
            'attribute' => 'sv_role',
            'format' => 'raw',
            'value' => function($s) {
                $roleClass = ($s->sv_role == 1 ? 'primary' : ($s->sv_role == 2 ? 'warning' : 'default'));
                return '<span class="label label-'.$roleClass.'">'.$s->roleName().'</span>';
            },
            'filter' => Html::activeDropDownList(
                $superviseeFilterModel,
                'sv_role',
                [
                    1 => 'Main',
                    2 => 'Second',
                    3 => 'Third',
                ],
                ['class' => 'form-control', 'prompt' => '']
            ),
        ],
        [
            'label' => 'Student Status',
            'attribute' => 'sv_status_daftar',
            'format' => 'raw',
            'value' => function($s) {
                if (!$s->student) {
                    return StudentRegister::statusDaftarLabel(null);
                }
                return StudentRegister::statusDaftarLabel($s->student->last_status_daftar);
            },
            'filter' => Html::activeDropDownList(
                $superviseeFilterModel,
                'sv_status_daftar',
                StudentRegister::statusDaftarList(),
                ['class' => 'form-control', 'prompt' => '']
            ),
        ],
    ],
]); ?>


</div>
</div>



	<div class="box">
<div class="box-header">
<h3 class="box-title">
Examination Committee <?= isset($examineeProvider) ? ('(' . (int)$examineeProvider->getTotalCount() . ')') : '' ?>
</h3>
</div>
<div class="box-body">
<?= GridView::widget([
    'dataProvider' => $examineeProvider,
    'filterModel' => $examineeFilterModel,
    'filterUrl' => ['view', 'id' => $model->id, 'semester_id' => $semesterId],
    'columns' => [
        ['class' => 'yii\\grid\\SerialColumn'],
        [
            'label' => 'Name',
            'attribute' => 'ex_name',
            'format' => 'raw',
            'filter' => Html::activeTextInput($examineeFilterModel, 'ex_name', ['class' => 'form-control']),
            'value' => function($x) use ($semesterId) {
                $name = (($x->matric_no ? $x->matric_no . ' - ' : '') . strtoupper($x->fullname));
                return Html::a($name, '#', [
                    'class' => 'js-student-quick-view',
                    'data-student-id' => $x->id,
                    'data-semester-id' => $semesterId,
                ]);
            }
        ],
        [
            'label' => 'Stage',
            'attribute' => 'ex_stage_id',
            'filter' => Html::activeDropDownList(
                $examineeFilterModel,
                'ex_stage_id',
                \yii\helpers\ArrayHelper::map(ResearchStage::find()->orderBy(['id' => SORT_ASC])->all(), 'id', 'stage_abbr'),
                ['class' => 'form-control', 'prompt' => '']
            ),
            'value' => function($x) {
                return $x->stage_name_en ? $x->stage_name_en : $x->stage_name;
            },
        ],
        [
            'label' => 'Committee Role',
            'attribute' => 'ex_committee_role',
            'value' => function($x) {
                return isset($x->committee_role_label) ? $x->committee_role_label : '';
            },
            'filter' => Html::activeDropDownList(
                $examineeFilterModel,
                'ex_committee_role',
                [
                    1 => 'Chairman',
                    2 => 'Deputy Chairman',
                    3 => 'Examiner 1',
                    4 => 'Examiner 2',
                ],
                ['class' => 'form-control', 'prompt' => '']
            ),
        ],
        [
            'label' => 'Result',
            'attribute' => 'ex_result',
            'value' => function($x) {
                return StudentStage::statusText($x->stage_status);
            },
            'filter' => Html::activeDropDownList(
                $examineeFilterModel,
                'ex_result',
                StudentStage::statusList(),
                ['class' => 'form-control', 'prompt' => '']
            ),
        ],
    ],
]); ?>


</div>
</div>



	
	
	</div>
</div>




    
    




</div>
