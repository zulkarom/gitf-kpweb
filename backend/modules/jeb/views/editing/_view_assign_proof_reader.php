<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;

?>
 
<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">Proof Reader</h3>

</div>

<div class="box-body">
 
<style>
table.detail-view th {
    width:25%;
}
</style>

 <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
			[
				'label' => 'Proof Reader',
				'value' => function($model){
					return $model->proofReader->fullname;
				}
			],
			'asgn_profrdr_note'
			

        ],
    ]) ?>

</div>
</div>

