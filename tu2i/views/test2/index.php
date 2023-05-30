
<?php
use richardfan\widget\JSRegister;
use yii\helpers\Url;
use yii\helpers\Html;

$user =Yii::$app->user->identity;
$dirAssets = Yii::$app->assetManager->getPublishedUrl('@tu2i/assets/tu2iAssets');
$this->title = 'IDEA PERNIAGAAN / BUSINESS IDEA';
?>

<div class="container">
	<div class="row">
	<div class="col-md-8">
	<div class="ptitle">IDEA PERNIAGAAN / BUSINESS IDEA<br/>
	</div>
	<br />
	<div class="form-group"><strong>NAMA/<i>Name</i>:</strong> <?php echo $user->can_name ;?><br />
	<strong>NRIC/PASSPORT NO:</strong>  <?php echo $user->username ;?><br /></div>
	
	</div>
	<div class="col-md-4">
		<div class="indicator"><span >MASA / TIME </span><span id="shortly"></span></div>
		<div class="bar-container" id="progress-timer"><div id="progress-bar">&nbsp;</div></div>
		
	
	
	</div>
	</div>
	

    <div class="box">
	<?php 
	if($answer->status <> 3){
		
		?>
		<div class="instruction" id="ginstruction2"><b>CALON BOLEH MENJAWAB DALAM BAHASA MELAYU ATAU BAHASA INGGERIS</b> /<br /> <i>THE CANDIDATE CAN ANSWER IN BAHASA OR ENGLISH</i></div>
		
		<?php
	}
	
	?>
	

		<?php 
		if($answer->status == 1){ ?>
        <div id="ginstruction" class="instruction"><b>ANDA MEMPUNYAI MASA BAKI <span id="masa"></span> UNTUK MENJAWAB UJIAN IDEA PERNIAGAAN INI. SEKIRANYA MASA TELAH TAMAT, JAWAPAN AKAN DIHANTAR SECARA AUTOMATIK.</b>
		<br /><br />
		<i>YOU HAVE BALANCE TIME <span id="masa-en"></span> TO ANSWER THIS BUSINESS IDEA TEST. IF THE TIME ENDS, THE ANSWER WILL BE SUBMITTED AUTOMATICALLY.</i>
		
		
		</div>
		<button class="btn btn-success center-block" id="start-btn">SAMBUNG MENJAWAB / CONTINUE ANSWERING<</button>
		<?php
		$qstart = $this->user->question_last_saved;
		}else if($answer->status == 3){ ?>
		<div id="ginstruction" class="instruction"><b>ANDA TELAH MENJAWAB UJIAN INI </b>/ <i>YOU HAVE ANSWERED THE TEST</i></div>
		
		<div style="text-align:center">
<a href="<?=Url::to(['option'])?>" class="btn btn-warning " id="kembali-btn">KEMBALI / BACK</a>
		
		</div>

		<?php
		$qstart = 999;
		}else { ?>
		
		<div id="ginstruction" class="instruction"><b>ANDA MEMPUNYAI MASA <span id="masa"></span> UNTUK MENJAWAB UJIAN IDEA PERNIAGAAN INI. SEKIRANYA MASA TELAH TAMAT, JAWAPAN AKAN DIHANTAR SECARA AUTOMATIK.</b>
		
		<br /><br />
		<i>YOU HAVE <span id="masa-en"></span> TO ANSWER THIS BUSINESS IDEA TEST. IF THE TIME ENDS, THE ANSWER WILL BE SUBMITTED AUTOMATICALLY.</i>
		
		
		</div>
		
		<div align="center">
		<a href="<?=Url::to(['option/index'])?>" class="btn btn-warning " id="kembali-btn">KEMBALI / BACK</a> <button class="btn btn-success" id="start-btn">MULA MENJAWAB / START ANSWERING</button>
		</div>
		
		<?php
		$qstart = 1;
		}
		?>
		
		
		
		<div id="quest-container">
		
		<div id="question-form" class="hidden form-group" >
		
		<label>Jika anda diberikan peluang untuk memulakan perniagaan, apakah jenis perniagaan yang anda fikirkan? Jelaskan mengapa anda memilih perniagaan tersebut? Apakah jenis dan kelebihan produk/perkhidmatan yang anda ingin tawarkan? Terangkan faktor yang boleh memotivasikan kejayaan perniagaan anda. (200 – 250 patah perkataan)
<br />
<i style="font-weight:normal">If you have the opportunity to venture into business, what kind of business that you have in your mind? Explain why you choose the business? What types of product/service to offer and its value proposition? Express your motivation factors in ensuring the success of your business. (200 – 250 words)</i>
		
		</label>
		
		<textarea id="karangan" class="form-control" rows="20"><?=$answer->biz_idea?></textarea>
		
		
		</div>
		
		

		
	<input type="hidden"  id="curr-name" value="<?php echo $qstart?>" />
	

	<button class="btn btn-danger hidden" id="submit-btn">HANTAR JAWAPAN / SUBMIT ANSWER</button>
	
	</div>
	<div id="errmsg" style="text-align:center;color:red"></div>
	<div id="goodmsg" style="text-align:center;display:none">
	<img src="<?=$dirAssets?>/images/loading.gif" /><br/>
	Sila Tunggu, Jawapan Anda Sedang Dihantar / Please wait, your answering is being submitted
	</div>
    </div>
	
	<div id="counter" class="hidden"></div>
	<div id="counterMsg"></div>
	<div id="timerMsg"></div>
	<div style="text-align:center;" id="conxls" class="hidden"><br /><a href="#" id="dwnxls" >Save as Excel</a></div>
</div>

<?php JSRegister::begin(['position' => static::POS_END]); ?>

<script>
/**
 * jQuery.textareaCounter
 * Version 1.0
 * Copyright (c) 2011 c.bavota - http://bavotasan.com
 * Dual licensed under MIT and GPL.
 * Date: 10/20/2011
**/
(function($){
	$.fn.textareaCounter = function(options) {
		// setting the defaults
		// $("textarea").textareaCounter({ limit: 100 });
		var defaults = {
			limit: 100
		};	
		var options = $.extend(defaults, options);
 
		// and the plugin begins
		return this.each(function() {
			var obj, text, wordcount, limited;
			
			obj = $(this);
			obj.after('<span style="font-size: 11px; clear: both; margin-top: 3px; display: block;" id="counter-text">Max. '+options.limit+' words</span>');

			obj.keyup(function() {
			    text = obj.val();
			    if(text === "") {
			    	wordcount = 0;
			    } else {
				    wordcount = $.trim(text).split(" ").length;
				}
			    if(wordcount > options.limit) {
			        $("#counter-text").html('<span style="color: #DD0000;">0 words left</span>');
					limited = $.trim(text).split(" ", options.limit);
					limited = limited.join(" ");
					$(this).val(limited);
			    } else {
			        $("#counter-text").html((options.limit - wordcount)+' words left');
			    } 
			});
		});
	};
})(jQuery);
</script>

<script src="<?=$dirAssets?>/js/jquery/jquery.plugin.js"></script>
<script src="<?=$dirAssets?>/js/jquery/jquery.countdown.js"></script>
<script src='<?=$dirAssets?>/js/jquery/timer.jquery.min.js'></script>

<script>
$("textarea").textareaCounter({ limit: 250 });

var originalTimer = 30; //minutes
var baki = '<?php echo $answer->answer_last_saved2;?>';
var res = baki.split(":");
var mm = 0;
var ss = 0;
if (baki == 0 || baki == '0'){
	mm = originalTimer;
	ss = 0;
}else{
	mm = parseInt(res[0]);
	ss = parseInt(res[1]);
	
	ori = originalTimer * 60;
	total = mm * 60 + ss;
	tick = ori - total;
	per = tick / ori * 100;
	perstring = per.toFixed(0)+"%";
	

	//alert(habis +"/"+total);
	$("#progress-bar").css("width",perstring);
	
}

var tempoh = mm * 60 + ss;
//var qlastsaved = <?php echo $answer->answer_last_saved2;?>;
var totalQuestion  = 1;
$('#shortly').text(mm+':'+ss);
//$('#con-quest').text(qlastsaved +'/'+totalQuestion);
if(ss > 0){
	stringsaat = ss + " SAAT";
	stringsaat2 = ss + " SECOND(S)";
}else{
	stringsaat ="";
	stringsaat2="";
}
if(mm > 0){
	stringminit = mm + " MINIT ";
	stringminit2 = mm + " MINUTE(S) ";
}else{
	stringminit ="";
	stringminit2="";
}
$('#masa').text(stringminit + stringsaat);
$('#masa-en').text(stringminit2 + stringsaat2);
var errmsg ="Soalan ini mesti dijawab / This question must be attempted";
var linklogout = "<br /><br /><a href='<?php echo Url::to(['option/index']); ?>'>Kembali / Back</a>";
var seterus = parseInt($("#curr-name").val() + 1);
/* prog = qlastsaved / totalQuestion * 100;
prog = prog.toFixed(0) + '%';
$('#progress-quest').css('width',prog); */




$(function () {
	
	
$("#karangan").on('keyup', function() {
var words = this.value.match(/\S+/g).length;

countWords(words)
});

function countWords(words){
	if (words > 250) {
  // Split the string on first 200 words and rejoin on spaces
  var trimmed = $(this).val().split(/\s+/, 200).join(" ");
  // Add a space at the end to make sure more typing creates new words
  $(this).val(trimmed + " ");
}else {
  $('#display_count').text(words);
  $('#word_left').text(250-words);
}
}
	
$("#start-btn").click(function(){
	var curr = parseInt($("#curr-name").val());
    startTimer();
	$("#start-btn").addClass("hidden");
	$("#kembali-btn").addClass("hidden");
	$('#ginstruction').addClass("hidden");
	$('#ginstruction2').addClass("hidden");
	$("#question-form").removeClass("hidden");
	$("#progress-timer").removeClass("hidden");
	$("#con-quest").removeClass("hidden");
	$("#p-quest").removeClass("hidden");
	//con-quest 
	$("#q"+curr).removeClass("hidden");
	$('#con-quest').text(curr+'/'+totalQuestion);
	$.post("<?php echo Url::to(['test2/change-status/1'])?>");
	$("#submit-btn").removeClass("hidden");
	
});


$("#dwnxls").click(function(){
	downloadexcel();
});
$("#test").click(function(){
	if (jQuery('input[type=radio][name=qq12]').length) {
	   alert(true);
	}else{
		alert(false);
	}
});

	
	
$("#submit-btn").click(function(){
	
   $("#goodmsg").show();

		$("#submit-btn").addClass("hidden");
		$("#question-form").addClass("hidden");
		submitForm(0,0);
		$('#ginstruction').html("Ujian Idea Perniagaan Tamat / Business Idea Test Ends"+linklogout); 
		$('#ginstruction').removeClass("hidden");
		stopTimer();
		$('#shortly').countdown('toggle');
});

$("#testing").click(function(){
	alert($("input[name=qq1]:checked").val());
	
});

	
	

});
function stopTimer(){
	$('#counter').timer('remove');
		$('#timerMsg').addClass("hidden");
}
function liftOff() { 
	$('#ginstruction').html("Masa telah tamat / The time ends"+linklogout); 
	$('#ginstruction').removeClass("hidden");
	$('#quest-container').hide();
	submitForm(0,0);
	stopTimer();
} 
function checkNetConnection(action){
 jQuery.ajaxSetup({async:false});
 re="";
 r=Math.round(Math.random() * 10000);
 $.ajax({
        url: "<?=$dirAssets?>/images/dot.png",
		data:{subins:r},
        success: function(d){
		  re=true;
		 },
		 error:function(){
		  re=false;
		 }
    });
 
 

 //alert(re);
 return re;
}



function submitForm(action,curtime) { 
	if(action ==0){
		
		$("#errmsg").hide();
		$("#goodmsg").show();
		setTimeout(
		  function() 
		  {
			ajaxSubmit(action,curtime);
		  }, 3000);
	}else if(action ==1){
		ajaxSubmit(action,curtime);
	}	
		

} 

function ajaxSubmit(action,curtime){
	if(checkNetConnection(action)){
		$.ajax({
        type: "POST",
        url: "<?php echo Url::to(['test2/submit'])?>",
        data: 
		{ 
			time: $('#shortly').text() ,
			karangan: $('#karangan').val() ,
			aksi: action,
		},
        dataType: "json",
        timeout: 15000, // in milliseconds
        success: function(result){
			if(action==0){
				if(result ==1){
					$("#errmsg").html("");
					$("#goodmsg").html("<strong>Jawapan Anda Telah Berjaya Dihantar.<br />Terima Kasih Kerana Menjalani Ujian Ini. </strong><br /> <i>Your Answers Has Been Successfully Submitted. Thanks for Answering The Test.</i>");
					$("#conxls").removeClass("hidden");
				}else{
					$("#errmsg").html("Server Problem!");
				}
				
			}else if(action ==1){
				if(result ==1){
					$('#timerMsg').text("Last saved at: "+curtime);
				}else{
					$('#timerMsg').text("Server Problem!");
				}
			}
		}
		,
        error: function(request, status, err) {
            if(status == "timeout"){
                errInternetConnection(action);
            }
        }
    });
	}else{
		errInternetConnection(action);
	}
}

function errInternetConnection(action){
	if(action==1){
		var tt = $('#timerMsg').text();
		$('#timerMsg').text(tt + "#");
	}else if(action ==0){
		$("#goodmsg").hide();
		$("#errmsg").show();
		$("#errmsg").html("Jawapan anda tidak boleh dihantar buat masa ini oleh kerana terdapat masalah internet / Your answer cannot be submitted for the time being due to internet connection problem.<br/><br/><button class='btn btn-default' id='hantarlagi'>Cuba Hantar Lagi / Try to Resubmit</button>");
		$("#conxls").removeClass("hidden");
		reloadbuttonresubmit();
	}
}


function reloadbuttonresubmit(){
	$("#hantarlagi").click(function(){
		submitForm(0,0)
	});
}
function watchCountdown(periods){
	//$('#monitor').text(periods[5] + ':' +  periods[6] );
	mm = periods[5];
	ss = periods[6];
	
	ori = originalTimer * 60;
	total = mm * 60 + ss;
	tick = ori - total;
	per = tick / ori * 100;
	perstring = per.toFixed(0)+"%";
	$("#progress-bar").css("width",perstring);
	//$("#progress-timer").text(tick+total);
}

function startTimer(){
	$('#shortly').countdown({
	until: shortly,  
    onExpiry: liftOff,
	onTick: watchCountdown
	}); 
	
	var shortly = new Date();
	shortly.setSeconds(shortly.getSeconds() + tempoh); 
	$('#shortly').countdown('option', {until: shortly,format: 'MS', compact: true,}); 
	
	
	$('#counter').timer({
		duration: '5s',
		callback: function() {
			var dt = new Date();
			var curtime = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
			//$('#timerMsg').text("Last saved at: "+curtime);
			submitForm(1,curtime);
			
		},
		repeat: true //repeatedly call the callback
	});
}


////////////about excel//////////////



function datenum(v, date1904) {
	if(date1904) v+=1462;
	var epoch = Date.parse(v);
	return (epoch - new Date(Date.UTC(1899, 11, 30))) / (24 * 60 * 60 * 1000);
}
 
function sheet_from_array_of_arrays(data, opts) {
	var ws = {};
	var range = {s: {c:10000000, r:10000000}, e: {c:0, r:0 }};
	for(var R = 0; R != data.length; ++R) {
		for(var C = 0; C != data[R].length; ++C) {
			if(range.s.r > R) range.s.r = R;
			if(range.s.c > C) range.s.c = C;
			if(range.e.r < R) range.e.r = R;
			if(range.e.c < C) range.e.c = C;
			var cell = {v: data[R][C] };
			if(cell.v == null) continue;
			var cell_ref = XLSX.utils.encode_cell({c:C,r:R});
			
			if(typeof cell.v === 'number') cell.t = 'n';
			else if(typeof cell.v === 'boolean') cell.t = 'b';
			else if(cell.v instanceof Date) {
				cell.t = 'n'; cell.z = XLSX.SSF._table[14];
				cell.v = datenum(cell.v);
			}
			else cell.t = 's';
			
			ws[cell_ref] = cell;
		}
	}
	if(range.s.c < 10000000) ws['!ref'] = XLSX.utils.encode_range(range);
	return ws;
}
 
/* original data */





 
function Workbook() {
	if(!(this instanceof Workbook)) return new Workbook();
	this.SheetNames = [];
	this.Sheets = {};
}
 


function s2ab(s) {
	var buf = new ArrayBuffer(s.length);
	var view = new Uint8Array(buf);
	for (var i=0; i!=s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
	return buf;
}
function rowval(){
	var val = $("#karangan").val();
	rowarr = [1,val];
	return rowarr;
	
	
}
function downloadexcel(){
	var bigarr = [];
	bigarr.push(rowval());
	var data = bigarr
	var ws_name = "answers";
	var wb = new Workbook(), ws = sheet_from_array_of_arrays(data);
	/* add worksheet to workbook */
	wb.SheetNames.push(ws_name);
	wb.Sheets[ws_name] = ws;
	var wbout = XLSX.write(wb, {bookType:'xlsx', bookSST:true, type: 'binary'});

	saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), "bis-idea-<?php echo $user->username ;?>.xlsx")
}

</script>

<?php JSRegister::end(); ?>
