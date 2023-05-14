<script>
var originalTimer = 15; //minutes
var baki = '<?=$answer->answer_last_saved;?>';
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
var qlastsaved = <?=$answer->question_last_saved;?>;
var totalQuestion  = <?php echo $total_q;?>;
$('#shortly').text(mm+':'+ss);
$('#con-quest').text(qlastsaved +'/'+totalQuestion);
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
var seterus = parseInt($("#curr-name").val() + 1);
prog = qlastsaved / totalQuestion * 100;
prog = prog.toFixed(0) + '%';
$('#progress-quest').css('width',prog);




$(function () {
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
	
    var curr = parseInt($("#curr-name").val());
	var qval = $("input[name=qq"+curr+"]:checked").val();
	//alert(qval);
	if (qval==1 || qval==0){
		$("#goodmsg").show();

		$("#q"+curr).addClass("hidden");
		$("#submit-btn").addClass("hidden");
		submitForm(0,0);
		$('#ginstruction').html("Ujian Tamat / The Test Ends"+linklogout); 
		$('#ginstruction').removeClass("hidden");
		stopTimer();
		$('#shortly').countdown('toggle');
	}else{
		$("#errmsg").text(errmsg);
	}
});
$("#start-btn").click(function(){
	var curr = parseInt($("#curr-name").val());
    startTimer();
	$("#start-btn").addClass("hidden");
	$('#ginstruction').addClass("hidden");
	$("#progress-timer").removeClass("hidden");
	$("#con-quest").removeClass("hidden");
	$("#p-quest").removeClass("hidden");
	//con-quest 
	$("#q"+curr).removeClass("hidden");
	$('#con-quest').text(curr+'/'+totalQuestion);
	$.post("<?php echo Config::get('URL')?>test/changestatus/1");
	if(<?php echo $qstart;?>==<?php echo $total_q;?>){
		$("#submit-btn").removeClass("hidden");
	}else{
		$("#next-btn").removeClass("hidden");
	}
	
});
$("#testing").click(function(){
	alert($("input[name=qq1]:checked").val());
	
});
$("#next-btn").click(function(){
    var curr = parseInt($("#curr-name").val());
	var total = totalQuestion;
	var next = curr + 1
	var qval = $("input[name=qq"+curr+"]:checked").val();
	if (qval==1 || qval==0){
		$("#errmsg").text("");
		if (next < total){
			//$("#q"+curr).addClass("hidden");
			$("#q"+curr).addClass("hidden");
			$("#q"+next).removeClass("hidden");
			$("#curr-name").val(next);
			$('#con-quest').text(next +'/'+totalQuestion);
			prog = next/totalQuestion * 100;
			prog = prog.toFixed(0) + '%';
			$('#progress-quest').css('width',prog);
		}else{ //last question
			$("#q"+curr).addClass("hidden");
			$("#q"+next).removeClass("hidden");
			$("#submit-btn").removeClass("hidden");
			$("#next-btn").addClass("hidden");
			$("#curr-name").val(next);
			$('#con-quest').text(next +'/'+totalQuestion);
			$('#progress-quest').css('width','100%');
			
		}
	}else{
		$("#errmsg").text(errmsg);
	}
	
	
	
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
        url: "<?php echo Config::get('URL')?>/images/dot.png",
		data:{subins:r},
        success: function(d){
		  re=true;
		 },
		 error:function(){
		  re=false;
		 }
    });
 
 
/*  $.get("<?php echo Config::get('URL')?>/images/dot.png",{subins:r},function(d){
  re=true;
 }).error(function(){
  re=false;
 }); */
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
        url: "<?php echo Config::get('URL')?>test/submit/<?php echo $qstart;?>",
        data: 
		{ 
			time: $('#shortly').text() ,
			aksi: action,
			qlast: $('#curr-name').val() ,
			<?php
			for($i=1;$i<=$total_q;$i++)
				if($i >= $qstart){
					echo 'q'.$i.': $("input[name=qq'.$i.']:checked").val(),'."\n";
				}
			
			?>
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
function rowval(num){
	if (jQuery('input[type=radio][name=qq'+num+']').length) {
		var val = -1;
		if($("input[name=qq"+num+"]:checked").val()==undefined){
			val = -1;
		}else{
			val = $("input[name=qq"+num+"]:checked").val();
		}
		var rowarr = [num,val];
		
		return rowarr;
	}else {
		return false;
	}
	
}
function downloadexcel(){
	var bigarr = [];
	for(i=1;i<=120;i++){
		if(rowval(i)){
			bigarr.push(rowval(i))
		}
	}
	var data = bigarr
	var ws_name = "answers";
	var wb = new Workbook(), ws = sheet_from_array_of_arrays(data);
	/* add worksheet to workbook */
	wb.SheetNames.push(ws_name);
	wb.Sheets[ws_name] = ws;
	var wbout = XLSX.write(wb, {bookType:'xlsx', bookSST:true, type: 'binary'});

	saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), "psikometrik-<?php echo $this->user->user_name ;?>.xlsx")
}

</script>