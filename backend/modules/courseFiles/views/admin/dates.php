<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
use yii\widgets\ActiveForm;
use backend\modules\courseFiles\models\Common;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\teachingLoad\models\CourseOfferedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dates Setting';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div class="col-md-10" align="right">
        <?= $this->render('_form_semester', [
                'model' => $semester,
            ]) ?>
    </div>
</div>
<div class="course-files-default-index">

<?php $form = ActiveForm::begin(); ?>

<div class="box">
<div class="box-header"></div>
<div class="box-body">    <p>

<div class="row">
<div class="col-md-4"> <?=$form->field($dates, 'open_deadline')->widget(DatePicker::classname(), [
    'removeButton' => false,
	'pickerIcon' => '<i class="fa fa-calendar"></i>',
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
]);
?></div>

<div class="col-md-4">
<?=$form->field($dates, 'audit_deadline')->widget(DatePicker::classname(), [
    'removeButton' => false,
	'pickerIcon' => '<i class="fa fa-calendar"></i>',
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
]);
?>
</div>

</div>





<i>* Leave it blank to always open.<br />
* Current time: 
<?php 
echo Common::currentTime();

;?>
	</i>
	</p></div>
</div>

<div class="form-group">
        
<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

    
