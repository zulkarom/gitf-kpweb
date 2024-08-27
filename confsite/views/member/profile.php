<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use common\models\Country;
use kartik\select2\Select2;
use richardfan\widget\JSRegister;

/* @var $this yii\web\View */
/* @var $searchModel confsite\models\ConfPaperSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Profile';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="conf-paper-index">


<?php
if($associate){
$model = $associate;
 $form = ActiveForm::begin(); ?>
			
<div class="block-content">

		<div class="container">
			
			
					<div class="row">
					<div class="col-sm-2"></div>
						<div class="col-sm-12">
						
						<div class="row">
				<div class="col">
					<h4 class="section_title">PROFILE UPDATE</h4>
					<br />
				</div>

			</div>

							<div class="section">
							
				<div class="row">
			
			
				<div class="col-md-4"><?= $form
            ->field($model, 'title')
            ->textInput() ?></div>	
			
<div class="col-md-8"><?= $form
            ->field($user, 'fullname')
            ->label('Full Name')
            ->textInput() ?></div>
			
			
			
			

</div>	

<div class="row">
	<div class="col-md-6">    <?php  
if($conf->commercial == 1 && $conf->fee_package == 2){
	$model->fee_package = $reg->fee_package;
  $fees = ArrayHelper::map($conf->confFees, 'id', 'fee_name');
  echo $form->field($model, 'fee_package')->dropDownList($fees, ['prompt' => 'Select']);
}

?></div>
	<div class="col-md-6"></div>
</div>


<div class="row">

<div class="col-md-6"><?php 
echo $form
            ->field($user, 'email')
            ->label('Email')
            ->textInput(['disabled' => true]) ?></div>
	<div class="col-md-6">
<?php 


echo $form->field($model, 'phone');


?>
	</div>

</div>		
			
			
				
				</div>

				



<div class="row">

<div class="col-md-6">
<?php 


echo $form->field($associate, 'institution');


?>
	</div>


	<div class="col-md-6">
<?php 
if(!$model->country_id){
	$model->country_id = 158;
}

echo $form->field($model, 'country_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Country::find()->all(),'id', 'country_name'),
    'language' => 'en',
    'options' => ['multiple' => false,'placeholder' => 'Select a country ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('Country');


?>
	</div>

</div>	

<div class="row">

<div class="col-md-6">
<?php 


echo $form->field($associate, 'assoc_address')->textarea(['rows' => 4]);


?>
	</div>


</div>	
					
				
				
				<div>

                
                    <?= Html::submitButton('UPDATE', ['class' => 'btn btn-primary']) ?>
                </div>
				
				<br /><br />
				
				</div>
				
				
				
				
				</div>
			
			
				
				
				

<?php ActiveForm::end(); } else {
	echo 'This page is not available';
} ?>
			
			
         <div>
		 
		 </div>
			
	
			</div>
</div>

<br /><br /><br />

    
</div>


<?php JSRegister::begin(); ?>
<script>
$("#associate-title").change(function(){
	var val = $(this).val();
	if(val == 999){
		var html = '<input type="text" id="associate-title" placeholder="Please specify" class="form-control" name="Associate[title]" / >';
		$("#con-title").html(html);
	}
});
</script>
<?php JSRegister::end(); ?>
