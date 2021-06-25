<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use backend\modules\conference\models\ReviewForm;
use backend\modules\conference\models\UploadFile;

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\ConfPaper */

$this->title = $model->pap_title;
$this->params['breadcrumbs'][] = ['label' => 'Papers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$model->file_controller = 'member';
?>
<div class="conf-paper-view">


			<style>
table.detail-view th {
    width:17%;
}
</style>

			
			<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
				'attribute' => 'user_id',
				'label' => 'Submitted By',
				'value' => function($model){
					return $model->user->fullname;
				}
			],
			[
				'attribute' => 'created_at',
				'label' => 'Submitted Time',
				'format' => 'datetime'
			],
			[
				'attribute' => 'Status',
				'format' => 'html',
				'value' => function($model){
					return $model->paperStatus;
				}
				
			]
			,
            'pap_title:ntext',
			[
				'label' => 'Authors',
				'format' => 'html',
				'value' => function($model){
					return $model->authorString();
				}
				
			],
            'pap_abstract:ntext',
			'keyword:ntext',
			'reject_note:ntext',



  
        ],
    ]) ?>



</div>



<?php 
$review = $model->submittedReview;

if($review){

?>


     <h4 class="m-text23 p-b-34">Reviewer's Remark</h4>
<table class="table table-striped table-hover">
<thead>
<tr>
	<th width="3%">#</th>
	<th width="35%">Review Items</th>
	<th>Remark</th>
</tr>
</thead>
<tbody>
	
	<?php 
	
	$i =1;
	foreach(ReviewForm::find()->all() as $f){
	    $attr = 'q_'. $i . '_note';
	    echo '<tr>
		<td>'.$i.'. </td>
		<td>'.$f->form_quest.'</td>
	
		<td> ' . $review->$attr .' </td>
	</tr>';
	$i++;
	}
	
	
	if($review->reviewed_file){
	    echo '<tr>
	<td>#</td>
	<td>Reviewer\'s Uploaded File</td>
	<td>'. Html::a('Download', ['reviewer/download-file', 'attr' => 'reviewed', 'id' => $review->id, 'confurl' => $model->conference->conf_url], ['class' => 'btn btn-primary'] ) .'</td>
	</tr>';
	}
	?>
	
	
</tbody>
</table>

   <br /><br />
























<?php } ?>
