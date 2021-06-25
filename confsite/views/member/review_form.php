<?php

use yii\helpers\Html;
use yii\widgets\DetailView;




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
					return Html::a('<span class="glyphicon glyphicon-download-alt"></span> DOWNLOAD FILE', ['member/download-file', 'id' => $model->id, 'confurl' => $model->conference->conf_url, 'attr' => 'paper'], ['class' => 'btn btn-warning','target' => '_blank']);
				}
			]
  
        ],
    ]) ?>
	
	<br />
	

	<?php 
	
	 echo $this->render('_form_review', [
		'review' => $review,
		]); 
	
	
	?>
	
	



    </div>

 

	
	

</div>
			</div>
</div>

<br /><br /><br />