<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\form\ActiveForm;
use common\models\UploadFile;
/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\ConfRegistration */

$this->title = $model->user->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Participants', 'url' => ['index', 'conf' => $model->conf_id]];
$this->params['breadcrumbs'][] = $this->title;


$model->file_controller = 'register';


?>
<div class="conf-registration-view">



    <style>
table.detail-view th {
    width:15%;
}
</style>



<div class="row">
    <div class="col-md-6">

    <div class="box box-solid">
    <div class="box-header"> 
<div class="box-title"> 
    Profile
</div>
</div>
<div class="box-body">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' =>'Title',
                'value' => function($model){
                    return $model->user->associate ? $model->user->associate->title : '';
                }
            ],
            'user.fullname',
            'user.email',
            [
                'label' =>'Institution',
                'value' => function($model){
                    return $model->user->associate ? $model->user->associate->institution : '';
                }
            ],
            [
                'label' =>'Country',
                'value' => function($model){
                    if($model->user->associate){
                        if($model->user->associate->country){
                            $model->user->associate->country->country_name;
                        }
                    } 
                }
            ]
        ],
    ]) ?>

    <br />
	<div class="form-group">
    <a href="<?=Url::to(['/site/conf-login-as', 'conf_url' => $model->conference->conf_url, 'id' => $model->user_id])?>" target="_blank" class="btn btn-warning btn-sm">Login as</a>
 </div>

</div></div>

    </div>
    <div class="col-md-6">


<div class="box box-solid">
<div class="box-header"> 
<div class="box-title"> 
    Payment Info
</div>
</div>
<div class="box-body">



<style>
table.detail-view th {
    width:40%;
}
</style>

    <?php echo DetailView::widget([
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
                    if($model->fee_file){
                        return '<a href="'. Url::to(['download-file', 'confurl' => $model->conference->conf_url ,'attr' => 'fee', 'id' => $model->id]) .'" target="_blank">Uploaded File</a>';
                    }
                    
                }
            ], 
            'fee_note:ntext',       
            [
                'label' => 'Status',
                'value' => function($model){
                    return $model->statusFeeLabel;
                }
            ],
            [
                'label' => 'Action',
                'format' => 'raw',
                'value' => function($model){
                    $html = '';
                    $html .= Html::button('Update', ['class' => 'btn btn-warning btn-sm', 'id' => 'edit-payment']);
                    $html .= ' ';
                    if($model->fee_status == 1){ //submit
                        $html .= Html::a('Verify Payment',['verify-payment', 'id' => $model->id],['class' => 'btn btn-primary btn-sm']);
                    }else if($model->fee_status == 10){
                        $html .= Html::a('Revert',['revert-payment', 'id' => $model->id],['class' => 'btn btn-default btn-sm']);
                    }
                return $html;
                }
            ]
            

        ],
    ]);
    
   $this->registerJs('
   
   $("#edit-payment").click(function(){
        $("#con-form-payment").slideDown();
   });
   
   ');
    
    ?>

        
<div id="con-form-payment" style="display:none">


<div class="conf-paper-update">



<div class="conf-paper-form">

<?php $form = ActiveForm::begin(); ?>
<br />



<div class="row">
<div class="col-md-4"><?=$form->field($model, 'fee_currency') ->dropDownList($model->listCurrency())?></div>
<div class="col-md-8"><?=$form->field($model, 'fee_amount') ->textInput()?></div>
</div>


<?=$form->field($model, 'fee_note') ->textarea(['rows' => 3])?>

<br />


<?=UploadFile::fileInput($model, 'fee', $model->conference->conf_url)?>




<br />
<div class="form-group">
    <?= Html::submitButton('Update Payment', ['class' => 'btn btn-warning']) ?>
</div>

<?php ActiveForm::end(); ?>




</div></div>



</div>





</div></div>

    </div>
</div>


   




</div>
