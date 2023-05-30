
<?php
use richardfan\widget\JSRegister;
use yii\helpers\Url;
use yii\helpers\Html;

$user =Yii::$app->user->identity;
$dirAssets = Yii::$app->assetManager->getPublishedUrl('@tu2i/assets/tu2iAssets');
$this->title = 'UJIAN PSIKOMETRIK / PSYCHOMETRIC TEST';
?>


<div class="container">
	<div class="row">
	<div class="col-md-8">
	<div class="ptitle">
	
	<h4><br />
				IJAZAH SARJANA MUDA KEUSAHAWANAN<br />
				FAKULTI KEUSAHAWANAN DAN PERNIAGAAN</h4>
	
				<i><h4><br />
				BACHELOR OF ENTREPRENEURSHIP<br />
				FACULTY OF ENTREPRENEURSHIP AND BUSINESS</h4></i>
	
	</div>
	<br />
	<div class="form-group"><strong>NAMA/<i>NAME</i>:</strong> <?php echo $user->can_name ;?><br />
	<strong>NRIC/PASSPORT NO:</strong>  <?php echo $user->username ;?><br /></div>
	
	</div>

	</div>
	

    <div class="box">
	
	<div>
	<strong>ANDA PERLU MENJAWAB DAN HANTAR KEDUA-DUA BAHAGIAN BERIKUT:</strong>
	<br />
	<i>YOU NEED TO ANSWER BOTH OF THESE TWO SECTION:</i>
	
	</div>
<br />
		<div class="form-group">
		<a href="<?=Url::to(['test/index'])?>" class="btn btn-primary">UJIAN PSIKOMETRIK / PSYCHOMETRIC TEST</a> <a href="<?=Url::to(['test2/index'])?>" class="btn btn-primary">IDEA PERNIAGAAN / BUSINESS IDEA</a>
		</div>
		


		<?= Html::a('LOGOUT',['/site/logout'],['data-method' => 'post']) ?>
		
		



    </div>
	
	
	

</div>
