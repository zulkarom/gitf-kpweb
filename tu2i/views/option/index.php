
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
	
	<div class="row">
    <div class="col-md-3"><img src="<?=$dirAssets?>/images/umk.jpg" /></div>
    <div class="col-md-9">
	<h4><br />TEMUDUGA ATAS TALIAN
				IJAZAH SARJANA MUDA KEUSAHAWANAN<br />
				FAKULTI KEUSAHAWANAN DAN PERNIAGAAN</h4>
	
	<i><h4><br />
	ONLINE INTERVIEW
	BACHELOR OF ENTREPRENEURSHIP<br />
	FACULTY OF ENTREPRENEURSHIP AND BUSINESS</h4></i>

	</div>
</div>




	
	</div>
	<br />
	<div class="form-group"><strong>NAMA/<i>NAME</i>:</strong> <?php echo $user->can_name ;?><br />
	<strong>NRIC/PASSPORT NO:</strong>  <?php echo $user->username ;?><br /></div>
	<?= Html::a('LOGOUT',['/site/logout'],['data-method' => 'post']) ?>
	
	</div>

	</div>
	

    <div class="box">
	
	<div>

	<?php  
		if($answer->answer_status == 3){
			?>
			<strong>ANDA TELAH SELESAI MENJAWAB SEMUA SOALAN.</strong>
	<br />
	<i>YOU HAVE ALREADY FINISHED ANSWERING ALL THE QUESTIONS.</i>
			<?php
		}else{

			?>
			<strong>ANDA PERLU MENJAWAB DAN HANTAR KEDUA-DUA BAHAGIAN BERIKUT:</strong>
	<br />
	<i>YOU NEED TO ANSWER BOTH OF THESE TWO SECTION:</i>
			<?php
		}
		
		?>

	
	
	</div>
<br />


<div class="table-responsive">



<table class="table">
<thead>
    <tr>
	<th>#</th>
        <th>BAHAGIAN</th>
        <th>STATUS</th>
        <th></th>
    </tr>
</thead>
<tbody>
    <tr>
		<td>1.</td>
    <td><a href="<?=Url::to(['test/index'])?>">UJIAN PSIKOMETRIK / PSYCHOMETRIC TEST</a></td>
    <td><?=strtoupper($answer->status1Text)?></td>
    <td>
		<?php  
		if($answer->answer_status < 3){
			?>
			<a href="<?=Url::to(['test/index'])?>" class="btn btn-primary btn-sm">JAWAB</a>
			<?php
		}
		
		?>
		
	</td>
    </tr>

	<tr>
	<td>2.</td>
    <td><a href="<?=Url::to(['test2/index'])?>">SOALAN ESEI / ESSAY QUESTION</a></td>
    <td><?=strtoupper($answer->status2Text)?></td>
    <td>
		
	<?php  
		if($answer->answer_status2 < 3){
			?>
			<a href="<?=Url::to(['test2/index'])?>" class="btn btn-primary btn-sm">JAWAB</a>
			<?php
		}
		
		?>
	
	

    </tr>

</tbody>
</table>
</div>




		



		
		



    </div>
	
	
	

</div>
