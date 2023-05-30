
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use SebastianBergmann\CodeCoverage\Report\PHP;

$user =Yii::$app->user->identity;
$dirAssets = Yii::$app->assetManager->getPublishedUrl('@tu2i/assets/tu2iAssets');
$this->title = 'UJIAN PSIKOMETRIK / PSYCHOMETRIC TEST';
?>

<div class="container">
	<div class="row">
	<div class="col-md-8">
	<div class="ptitle">UJIAN PSIKOMETRIK / PSYCHOMETRIC TEST<br />
	</div>
	<br />
	<div class="form-group"><strong>NAMA/<i>Name</i>:</strong> <?php echo $user->can_name ;?><br />
	<strong>NRIC/PASSPORT NO:</strong>  <?php echo $user->username ;?><br /></div>
	
	<div class="form-group">
	<?= Html::a('LOGOUT',['/site/logout'],['data-method' => 'post']) ?>
</div>

	
	</div>

	</div>
	
	<h4>Sila isi maklumat di bawah / Please fill in the information below.</h4>
	<br />
	
<div class="row">
	<div class="col-md-8">
	
	
	<?php $form = ActiveForm::begin(); ?>

    <?php 
    
    for($i = 1; $i<=4;$i++){
        $colum = 'column' . $i;
        if($batch->$colum){
            echo $form->field($model, $colum)->textInput(['required' => 'required'])->label($batch->$colum);
        }
    }
    
    
    
    
    ?>
<div class="form-group">
        
<?= Html::submitButton('Seterusnya / Next', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
	
	
	
	</div>
</div>
 









</div>
	


<!-- <button id="test">test</button> -->

