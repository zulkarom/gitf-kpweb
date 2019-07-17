<?php
$res = new Research;
$res_id = $this->id;


$row = $res->researchDetail($res_id);
function sel($x,$y){
	if($x==$y){
		return "selected";
	}else{
		return "";
	}
}
function list_staff($res,$sel,$leader){
	$arr = array($leader);
	$lists = $res->listStaffx($arr);
	$op = "<option value='0'></option>";
	foreach($lists as $srow){
		$sid = $srow['staff_id'];
		if($sel==$sid ){$s="selected";}else{$s="";}
		$op .= "<option value='".$sid."' ".$s.">".$srow['staff_name']."</option>";
	}
	return $op;
}


if($_SESSION['user_level']==1 and isset($_GET['id']) and $_GET['p']=="pubadmin"){
	$link= "index.php?p=pubadmin&t=det&id=".$pub->filter_get("u");
}else{
	$link= "index.php?p=res";
}

//index.php?p=pubadmin&t=det&id=4
$roww = 2;
?>


<?php
include("message.php");
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body">
<form method="post" action="index.php" enctype="multipart/form-data">

	<div class="form-group">
			<div class="row">
			<div class="col-sm-<?php echo $roww;?>"><label>Title: </label> </div>
			<div class="col-sm-8"><textarea class='form-control' name="res_title" required><?php 
			echo $row->res_title;?></textarea></div>
			</div>
			</div>

<div class="form-group">
			<div class="row">

			<div class="col-sm-2"><label>Research Grant: </label> </div>
			<div class="col-sm-3"><select class='form-control'  name='res_grant' >
			<?php
			$result = $res->listGrant();
			$gra = $row->res_grant;
			foreach($result as $row_gra){
				$ss = sel($gra ,$row_gra['gra_id']);
				echo "<option value='".$row_gra['gra_id']."' ".$ss.">".$row_gra['gra_abbr']."</option>";
			}
			if($gra == 9){
				$showo = '';
			}else{
				$showo = 'style="display:none"';
			}
			?>
			</select></div>
			<div class="col-sm-5" <?php echo $showo;?> id="conothers"><input class='form-control' placeholder="Please Specify.."  type='text' name='res_grant_others' value="<?php echo $row->res_grant_others?>"  /></div>
			</div>
			</div>
			
			
			<div class="form-group">
			<div class="row">
			<div class="col-sm-<?php echo $roww;?>"><label>My Role: </label> </div>
			<div class="col-sm-2">
			<?php
			$ss = $res->getLeader($res_id);
			foreach($ss as $leadID){
				$leaderId = $leadID['resr_id'];
				$leadstaff = $leadID['staff_id'];
				$extname = $leadID['ext_name'];
			}
				
			
			
			if($leadstaff == $_SESSION['staff_id']){
				$isl = "checked";
				$ism = "";
			}else{
				$ism = "checked";
				$isl = "";
			}
			
			?>
				<div class='radioku'><input type="radio" name="myrole" value="1" id="rad1" <?php echo $isl?> /><label for='rad1' class='aku'>Leader 
					</label> </div>
			</div>
			<div class="col-sm-2">
				<div class='radioku'><input type="radio" name="myrole" value="0" id="rad2" <?php echo $ism?> /><label for='rad2' class='aku'>Member
				</label> </div>
			</div>
			</div>
			</div>
			
				<div class="form-group" id="fd_leader">
			<div class="row">
			<div class="col-sm-<?php echo $roww;?>"><label>Leader: </label> </div>
			<div class="col-sm-10" id="conleader">
			
			
	
			<?php 
			if($leadstaff  == $_SESSION['staff_id']){
				echo "<input type='hidden' value='".$_SESSION['staff_id']."' name='author_1' />";
				echo "<strong>".$res->getStaffName($_SESSION['staff_id'])."</strong>";
			}else{
				if($leadstaff==0){
					$inn = "<div id='conau_1'><input type='hidden' name='author_1' value='0' /><input type='text' name='authorx_1' class='form-control' value='".$extname."' /></div>";
					$cc = "";
				}else{
					$inn = "<select name='author_1' class='form-control'>".list_staff($res,$leadstaff,$_SESSION['staff_id'])."</select>";
					$cc = "checked";
				}
				
				$dcon="<div class='form-group' id='au_1'><div class='row'><div class='col-sm-7'>".$inn."</div><div class='col-sm-3'><div class='checkboxku'><input type='checkbox' name='leadernot' id='ck_1' onchange='chkstaff(1)' ".$cc." /><label for='ck_1' class='aku'>FKP Staff </label> </div></div></div></div>" ;
				echo $dcon;
			}
			
			
			?>
		

			</div>
			
			</div>

			</div>
			
		
			<div class="form-group" id="fd_members">
			<div class="row">
			<div class="col-sm-<?php echo $roww;?>"><label>Members: </label> </div>
			<div class="col-sm-10">
			
			
			<?php
			$result_au = $res->researchMembers($res_id,$leaderId);
			$num = count($result_au) + 1 ;
			echo '<input type="hidden" id="kira_au" name="kira_au" value="'.$num.'" />';
			
			echo '<div id="con-author">';
			$i=2;
			foreach($result_au as $row_au){
				$author="";
				$au_id = $row_au['resr_id'];
				$mem = $row_au['staff_id'];
			echo '<div class="form-group" id="au_'.$i.'">';
			if($mem == $_SESSION['staff_id']){
				echo "<strong>".$res->getStaffName($_SESSION['staff_id'])."</strong>";
			}else{
				if($mem == 0){
					$chek ="";
					$inn="<input type='hidden' name='author_".$i."' value='0' /><input type='text' class='form-control' name='authorx_".$i."' value='".$row_au['ext_name']."' />";
				}else{
					$chek="checked";
					$inn ="<select name='author_".$i."' class='form-control'>".list_staff($res,$mem,$row->res_leader)."</select>";
				}
				if($i==$num){$dis="";}else{$dis="disabled";}
				
				
				$input ="<div class='input-group'><div id='conau_".$i."'>".$inn."</div><div class='input-group-btn'><button type='button' id='rmv_au_".$i."' class='btn btn-default' onclick='removeInput(".$i.")' ".$dis."><span class='glyphicon glyphicon-remove'></span> &nbsp </button></div></div>";
				echo '<div class="row">
				<div class="col-sm-7">'.$input.'</div>
				<div class="col-sm-3">';
				
					echo "<div class='checkboxku'><input type='checkbox' id='ck_".$i."' onchange='chkstaff(".$i.")' ".$chek." /><label for='ck_".$i."' class='aku'>FKP Staff </label> </div>";
				echo '</div>
				</div>';
				
			}
			echo '</div>';
			$i++;
			}
			
			echo "</div>";
			?>
			
			<a class="btn btn-default btn-sm" id="more-au">
			<span class="glyphicon glyphicon-plus"></span> Add Member</a>
			
			</div>
			</div>
			</div>
			

		
			<div class="form-group" id="fd_date">
			<div class="row">
			<div class="col-sm-<?php echo $roww;?>"><label>Start Date: </label> </div>
			<div class="col-sm-2">
			
			 <div class='input-group date' id='dstart'>
			<input type='text' class='form-control' id='date_start' name='date_start' value='<?php echo $row->date_start;?>' />
			<span class='input-group-addon'>
			<span class='glyphicon glyphicon-calendar'></span>
                    </span>
			</div>
			
			
			</div>
			</div>
			</div>
			

		
		
		<div class="form-group" id="fd_date">
			<div class="row">
			<div class="col-sm-<?php echo $roww;?>"><label>End Date: </label> </div>
			<div class="col-sm-2">
			
			 <div class='input-group date' id='dend'>
			<input type='text' class='form-control' name='date_end' id='date_end' value='<?php echo $row->date_end;?>' />
			<span class='input-group-addon'>
			<span class='glyphicon glyphicon-calendar'></span>
                    </span>
			</div>
			
			
			</div>
			</div>
			</div>
			
		
			
			<div class="form-group" id="fd_isbn">
			<div class="row">
			<div class="col-sm-<?php echo $roww;?>"><label>Resource/ Sponsorship: </label> </div>
			<div class="col-sm-6"><input class='form-control'  type='text' name='res_source' value="<?php echo $row->res_source;?>"  /></div>
			</div>
			</div>
			
			<div class="form-group" id="fd_isbn">
			<div class="row">
			<div class="col-sm-<?php echo $roww;?>"><label>Status: </label> </div>
			<div class="col-sm-2"><select name='res_status' class="form-control">
			<?php
			$st = $row->res_status;
			if($st==1){
				$s1="selected";
				$s2="";
			}else{
				$s2="selected";
				$s1="";
			}
			?>
			<option value="0" <?php echo $s2;?>>On Going</option>
			<option value="1" <?php echo $s1;?>>Completed</option>
			</select></div>
			</div>
			</div>
			
			<div class="form-group" id="fd_index">
			<div class="row">
			<div class="col-sm-<?php echo $roww;?>"><label>Amount: </label> </div>
			<div class="col-sm-4">
			
			<div class="input-group">
  <span class="input-group-addon">RM</span>
  <input type="text" class="form-control" name="res_amount" value="<?php echo $row->res_amount;?>">
</div>



			
			
			</div>
			</div>
			</div>
			
			
			
			<div class="form-group" id="fd_file">
			<div class="row">
			<div class="col-sm-<?php echo $roww;?>"><label>File: </label> </div>
			<div class="col-sm-6">
			<?php 
			if($row->res_file){
			$filename = $row->res_file;
			echo '<div id="pdfimg"><a href="index.php?p=pdf&t=res&m='.$res_id.'&k='.rand(0,100).'" target="_blank"><span class="glyphicon glyphicon-file"></span> View</a></div>';
			}else{
				echo '<div id="pdfimg"></div>';
			}
			?>

		
			</div>
			</div>
			</div>
			
			<div class="form-group">
			
			<div class="row">
			<div class="col-sm-<?php echo $roww;?>">
			<label>Select pdf to change file: </label>
			</div>
			<div class="col-md-6">
			<input type="file" name="file">
			</div>
			</div>
			
			
			
			</div>
			
			
			
			<div class="box-footer">
			<div class="row">
			<div class="col-sm-<?php echo $roww;?>"></div>
			<div class="col-sm-3"><button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-floppy-disk"></span> SAVE RESEARCH</button></div>
			</div></div>
			<input type="hidden" name="p" value="res" />
			<input type="hidden" name="t" value="processEdit" />
			<input type="hidden" name="ad" value="1" />
			<input type="hidden" name="m" value="<?php echo $res_id; ?>" />
			<input type="hidden" name="submit_edit_res" value="1" />
			
			</form>
			</div>
			</div>

			<script>
			$(document).ready(function(){
				
				$('#date_start').datepicker({
				  autoclose: true,
				  format: 'yyyy-mm-dd'
				})
				
				$('#date_end').datepicker({
				  autoclose: true,
				  format: 'yyyy-mm-dd'
				})
				
				$("#more-au").click(function(){
					var num = $("#kira_au").val();
					num = parseInt(num) + 1;
					$("#kira_au").val(num);
					
					dcon=generateList(num);
					
					$( "#con-author" ).append(dcon);
					var pre = num - 1;
					$("#rmv_au_"+pre).attr('disabled','disabled');
				});
				
				$("#rad2").click(function(){//member
					dcon=leaderNot();
					$( "#conleader" ).html(dcon);
					$( "#con-author" ).html("");
					cc = youMember();
					$( "#con-author" ).append(cc);
					$("#kira_au").val(2);
				});
				
				$("#rad1").click(function(){
					xx = "<input type='hidden' name='author_1' value='<?php echo $_SESSION['staff_id']?>' /><strong><?php  echo $res->getStaffName($_SESSION['staff_id']);?></strong>";
					$( "#conleader" ).html(xx);
					//auto add you as member pulak
					$( "#con-author" ).html("");
					$("#kira_au").val(1);
					
				});
				
				$("#sgrant").change(function(){
					vv = $("#sgrant").val();
					if(vv == 9){
						$("#conothers").show();
					}else{
						$("#conothers").hide();
					}
					//alert(vv);
				});
				

			});	
				
			
			function generateList(num){
				inn = inputList(num);
				inputc = "<div class='input-group'>"+inn+"<div class='input-group-btn'><button id='rmv_au_"+num+"' class='btn btn-default' onclick='removeInput("+num+")'><span class='glyphicon glyphicon-remove'></span> &nbsp</button></div></div>";
				dcon="<div class='form-group' id='au_"+num+"'><div class='row'><div class='col-sm-7'>"+inputc+"</div><div class='col-sm-3'><div class='checkboxku'><input type='checkbox' id='ck_"+num+"' onchange='chkstaff("+num+")' checked /><label for='ck_"+num+"' class='aku'>FKP Staff </label> </div></div></div></div>" ;
				return dcon;
			}
			
			function leaderNot(){
				inn = inn = inputList(1);
				dcon="<div class='form-group' id='au_1'><div class='row'><div class='col-sm-7'>"+inn+"</div><div class='col-sm-3'><div class='checkboxku'><input type='checkbox' name='leadernot' id='ck_1' onchange='chkstaff(1)' checked /><label for='ck_1' class='aku'>FKP Staff </label> </div></div></div></div>" ;
				return dcon;
			}
			
			function youMember(){
				xx = "<strong><?php  echo $res->getStaffName($_SESSION['staff_id']);?></strong>";
				inn = "<input type='hidden' name='author_2' value='<?php echo $_SESSION['staff_id'];?>' />";
				dcon= "<div class='form-group' id='au_2'><div class='row'><div class='col-sm-7'>"+inn+xx+"</div></div></div>" ;
				return dcon;
			}
			
			function inputList(id){
				op ="<?php echo list_staff($res,0,$_SESSION['staff_id'])?>";
				inn = "<div id='conau_"+id+"'><select name='author_"+id+"' class='form-control'>"+op+"</select></div>";
				return inn;
			}
			
			function chkstaff(id){
				if(document.getElementById('ck_'+id).checked){
					//dcon=leaderNot();
					//inputList(id)
					$("#conau_"+id).html(inputList(id));
				}else{
					//
					$("#conau_"+id).html("<input type='hidden' name='author_"+id+"' value='0' /><input type='text' class='form-control' name='authorx_"+id+"' />");
					
				}
			}
			
			
			function removeInput(id){
				
						$('#au_'+id).remove();
						var num = $("#kira_au").val();
						num = parseInt(num) - 1;
						$("#kira_au").val(num);
						var pre = parseInt(id) - 1;
						$("#rmv_au_"+pre).removeAttr('disabled');
				}

			
			</script>


