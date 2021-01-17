<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\date\DatePicker;

$this->title = 'Student Attendance';
$this->params['breadcrumbs'][] = $this->title;
?>
<h4>Reset & Add Class Date</h4>
<div class="box">
<div class="box-body"><div class="student-form">

    <?php $form = ActiveForm::begin(['fieldConfig' => ['inputOptions' => ['autocomplete' => 'off', 'class' => 'form-control']]]) ?>
    <div class="row">
    <div class="col-sm-3">
	    <?=$form->field($model, 'start_date')->widget(DatePicker::classname(), [
		    'removeButton' => false,
		    'pluginOptions' => [
		        'autoclose'=>true,
		        'format' => 'yyyy-mm-dd',
		        'todayHighlight' => true,
		        
		    ],  
		])->label('Start Date');
		?>
	</div>

	<div class="col-sm-2">
		<?= $form->field($model, 'number_of_class')->textInput(['maxlength' => true, 'type' => 'number']) ?>
	</div>
	
	<div class="col-sm-3">
	    <?=$form->field($model, 'exclude_date')->widget(DatePicker::classname(), [
		    'removeButton' => false,
		    'pluginOptions' => [
		        'autoclose'=>true,
		        'format' => 'yyyy-mm-dd',
		        'todayHighlight' => true,
		        
		    ],  
		])->label('Exclude Date');
		?>
	</div>
	<div class="col-sm-2"><div class="form-group">
        <br/>
        <?= Html::submitButton('<span class="glyphicon glyphicon-plus"></span> Reset & Add', ['class' => 'btn btn-success']) ?>
    </div>
	</div>
	</div>

    

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>

<h4>List of Class Date</h4>
<div class="box">
<div class="box-body"><div class="student-form">

    <?php $form = ActiveForm::begin() ?>
    <div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>#</th>
        <th>Date</th>
        
      </tr>
    </thead>
    <tbody>
	<?php 
	$attendance = json_decode($lecture->attendance_header);
	if($attendance){
		$i = 1;
		foreach($attendance as $attend){
			echo '<tr>
        <td>'.$i.'. </td>
        <td>'. date('l, d M Y', strtotime($attend)) .'</td>
        <td width="20%">';
		
	/*<th>Edit</th>
		<th></th> 	echo DatePicker::widget([
			'name' => 'class_date[]',
			'value' => $attend,
			'removeButton' => false,
			'pluginOptions' => [
				'autoclose'=>true,
		        'format' => 'yyyy-mm-dd',
		        'todayHighlight' => true,
			]
		]); 
		
		echo '</td>
		<td><a href="" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> </a></td>';*/
		
		
      echo '</tr>';
	  $i++;
		}
	}
	
	
	?>
      
      
    </tbody>
  </table>
</div>

    
	<div class="form-group">
        <br/>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span>  Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>