
<?php
use richardfan\widget\JSRegister;

?>

<div class="container">
	<div class="row">
	<div class="col-md-8">
	<div class="ptitle">UJIAN PSIKOMETRIK / PSYCHOMETRIC TEST<br />
	</div>
	<br />
	<div class="form-group"><strong>NAMA/<i>Name</i>:</strong> <?php echo Yii::$app->user->can_name ;?><br />
	<strong>NRIC/PASSPORT NO:</strong>  <?php echo Yii::$app->user->username ;?><br />
	
	<div class="form-group">
	<a href=''>LOGOUT</a>
</div>

	
	</div>
	<div class="col-md-4">
		<div class="indicator"><span >MASA / TIME </span><span id="shortly"></span></div>
		<div class="bar-container" id="progress-timer"><div id="progress-bar">&nbsp;</div></div>
		
		<br />
		<div  class="indicator">SOALAN / QUESTION <span id="con-quest"></span></div>
		<div class="bar-container" id="p-quest">
		<div id="progress-quest">&nbsp;</div></div>
	
	</div>
	</div>
	

    <div class="box">

		
		<div style="text-align:center">
		

		
		</div>

		<?php
		$qstart = 999;
		}else { ?>
		
		<div id="ginstruction" class="instruction"><b>ANDA MEMPUNYAI MASA <span id="masa"></span> UNTUK MENJAWAB UJIAN PSIKOMETRIK INI. SEKIRANYA MASA TELAH TAMAT, JAWAPAN AKAN DIHANTAR SECARA AUTOMATIK.</b>
		
		<br /><br />
		<i>YOU HAVE <span id="masa-en"></span> TO ANSWER THIS PSYCHOMETRIC TEST. IF THE TIME ENDS, THE ANSWER WILL BE SUBMITTED AUTOMATICALLY.</i>
		
		</div>
		
		<div align="center">
<button class="btn btn-success" id="start-btn">MULA MENJAWAB / START ANSWERING</button>
		</div>
		
		<?php
		$qstart = 1;
		}
		?>
		
		
		
		<div id="quest-container">
		<?php 
		$total_q = count($quest);
		$i = 1;
		foreach($quest as $row){
			if($i >= $qstart){
				echo "<div id='q".$i."' class='hidden' >";
				echo "<div class='instruction'><b>".$row->cat_text ."</b> / ".$row->cat_text_bi ."</div>";
				echo "<div style='margin:0 auto;width:80%'>";
				echo "<div class='question-text'><b>".$row->que_text ." </b>/ <i>".$row->que_text_bi ."</i></div>";
				echo "<div style='text-align:center'><label class='lrad'><input name='qq".$row->que_id ."' type='radio' value='1'  /> YA / <i>YES</i></label> &nbsp;&nbsp;&nbsp;<label class='lrad'><input type='radio' name ='qq".$row->que_id ."' value='0' /> TIDAK  / <i>NO</i></label></div>";
				echo "</div><br /></div>";
			}
			
		$i++;
		}
		?>
		
	<input type="hidden"  id="curr-name" value="<?php echo $qstart?>" />
	
	<button class="btn btn-warning center-block hidden" id="next-btn">SETERUSNYA / NEXT</button>
	<button class="btn btn-danger center-block hidden" id="submit-btn">HANTAR JAWAPAN / SUBMIT ANSWER</button>
	
	</div>
	<div id="errmsg" style="text-align:center;color:red"></div>
	<div id="goodmsg" style="text-align:center;display:none">
	<br/>
	Sila Tunggu, Jawapan Anda Sedang Dihantar / Please wait, your answering is being submitted
	</div>
    </div>
	
	<div id="counter" class="hidden"></div>
	<div id="counterMsg"></div>
	<div class="form-group" align="center">
	<br />
<div id="timerMsg"></div>
</div>
	
	<div style="text-align:center;" id="conxls" class="hidden"><br /><a href="#" id="dwnxls" >Save as Excel</a></div>
</div>
<!-- <button id="test">test</button> -->

<?php JSRegister::begin(['position' => static::POS_END]); ?>
<?= $this->render('@frontend/javascript/ujian_js.php')?>
<?php JSRegister::end(); ?>
