<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\ConfPaper */

$this->title = 'Fee Payment ';
?>



<div class="row">
    <div class="col-md-6">
    <h4 class="m-text23 p-b-34">Payment Methods</h4>

    <div style="padding-right:10px;">
<?=$conf->payment_info?>
    </div>
    </div>
    <div class="col-md-6"><div class="conf-paper-update">

<h4 class="m-text23 p-b-34">Payment Info</h4>


<div class="conf-paper-form">



<br />





<style>
table.detail-view th {
    width:40%;
}
</style>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           
            [
                'label' => 'Amount',
                'value' => function($model){
                    return $model->feeAmountFormat;
                }
            ],  
            [
                'label' => 'Evidence of Payment',
                'format' => 'raw',
                'value' => function($model){
                    return '<a href="'. Url::to(['payment/download-file', 'confurl' => $model->conference->conf_url ,'attr' => 'fee', 'id' => $model->id]) .'" target="_blank">Uploaded File</a>';
                }
            ], 
            'fee_note:ntext',       
            [
                'label' => 'Status',
                'value' => function($model){
                    return $model->statusFeeLabel;
                }
            ]
            

        ],
    ]) ?>

    <?php 
      if($model->fee_status == 1){ //submit
        echo '<p><div class="form-group">';
        echo Html::a('Edit',['payment/update', 'confurl' => $conf->conf_url],['class' => 'btn btn-secondary btn-sm']);
        echo '</div></p>';
}
?>


</div>


</div></div>
</div>





