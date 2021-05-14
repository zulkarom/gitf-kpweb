<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use backend\modules\journal\models\ReviewForm;
use yii\widgets\ActiveForm;
use common\models\Upload;


/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = 'Paper Review';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="block-content">

		<div class="container">
			<div class="row">
				<div class="col">
					<h2 class="section_title text-center"><?= Html::encode($this->title) ?> </h2>
				</div>

			</div>
			<br /><div class="article-view">
			<style>
table.detail-view th {
    width:17%;
}
</style>


  <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'pap_title:ntext',
            'pap_abstract:ntext',
			'keyword:ntext',
			
			[
				'attribute' => 'paper_file',
				'label' => 'Uploaded Full Paper',
				'format' => 'raw',
				'value' => function($model){
					return Html::a('<span class="glyphicon glyphicon-download-alt"></span> DOWNLOAD FILE', ['paper/download-file', 'id' => $model->id, 'attr' => 'paper'], ['class' => 'btn btn-default','target' => '_blank']);
				}
			]
  
        ],
    ]) ?>
	
	<br />
	

	<?php 
	
	 echo $this->render('_form_review', [
		'review' => $review
		]); 
	
	
	?>
	
	



    </div>

 

	
	

</div>
			</div>
</div>

<br /><br /><br />