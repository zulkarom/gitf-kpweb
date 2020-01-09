<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\website\models\Program */

$this->title = 'View Program: ' . $model->program->pro_name;
$this->params['breadcrumbs'][] = ['label' => 'Programs', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="program-update">
<div class="box">
<div class="box-header">
<div class="box-title">Info</div></div>
<div class="box-body">
<div class="program-form">

<div class="form-group">
<label>
Summary:
</label>
<p><?= $model->summary ?></p>
</div>

<div class="form-group">
<label>
Career Oppotunity:
</label>
   <p> <?= $model->career ?></p>
</div>
    



<?= Html::a('UPDATE', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

</div></div>
</div>


<div class="box">
<div class="box-header">
<div class="box-title">Requirement</div></div>
<div class="box-body">
<div class="program-form">


<table class="table">
<?php 
$types = $model->typeRequirement();
foreach($types as $key=>$type){
	echo '<tr><td>' . $type[1] . '</td>
	<td>';
	
	$reqs = $model->listRequirements($key);
	if($reqs){
		echo '<ul>';
		foreach($reqs as $req){
			echo '<li>'.$req->req_text .'</li>';
		}
		echo '</ul>';
	}
	
	echo '</td>
	<td> ' . Html::a('Update', ['program/requirement', 'program' => $model->id, 'type' => $key], ['class' => 'btn btn-primary btn-sm']) . '</td>
	</tr>';
}

?>
</table>


</div></div>
</div>



</div>
