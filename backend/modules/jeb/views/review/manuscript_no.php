<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use common\models\Todo;


/* @var $this yii\web\View */
/* @var $model common\models\Application */

$this->title = 'Set Manuscript No.';//$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Submission', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="box">
<div class="box-header">

</div>
<div class="box-body"><div class="application-view">
<style>
table.detail-view th {
    width:15%;
}
</style>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
			'title:ntext',
			[
				'label' => 'Authors',
				'format' => 'html',
				'value' => function($model){
					return $model->authors;
				}
			],
			
			[
				'label' => 'Scope',
				'format' => 'html',
				'value' => function($model){
					return $model->scope->scope_name;
				}
			],
			'abstract:ntext',
			'keyword',
			[
				'attribute' => 'submit_at',
				'label' => 'Submit Time',
				'format' => 'datetime'
			],
			

        ],
    ]) ?>

</div>
</div>
</div>


<?php 
if(Todo::can('jeb-managing-editor')){
	?>
	
	<?=$this->render('_form_manuscript_no', [
			'model' => $model,
	]);?>



<?php } ?>




