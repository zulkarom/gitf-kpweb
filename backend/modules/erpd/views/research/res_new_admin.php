<?php
$res = new Research;
if($_SESSION['user_level']==1){
if(isset($_POST['submit_new_res']) ==1){
	$res->proses_new_res();
}

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


$roww = 2;
?>
<h2>New Research</h2>
<h4><a href="index.php?p=res" class="btn btn-default">
<span class="glyphicon glyphicon-arrow-left"></span> Back to Research List
</a></h4><br/>
<?php
include("message.php");
?>
<form method="post" action="index.php">

	<div class="form-group">
			<div class="row">
			<div class="col-sm-<?php echo $roww;?>"><label>Title: </label> </div>
			<div class="col-sm-8"><textarea class='form-control' name="res_title" required></textarea></div>
			</div>
			</div>

<div class="form-group">
			<div class="row">

			<div class="col-sm-2"><label>Research Grant: </label> </div>
			<div class="col-sm-3">
			<select class='form-control'  name='res_grant' id="sgrant">
			<option value="0"></option>
			<?php
			$result = $res->listGrant();
			foreach($result as $row_gra){
				echo "<option value='".$row_gra['gra_id']."'>".$row_gra['gra_abbr']."</option>";
			}
			
			?>
			</select></div>
			<div class="col-sm-5" style="display:none" id="conothers"><input class='form-control' placeholder="Please Specify.."  type='text' name='res_grant_others' value=""  /></div>
			</div>
			</div>
			

		<input type="hidden" id="kira_au" name="kira_au" value="1" />
			<div class="form-group" id="fd_leader">
			<div class="row">
			<div class="col-sm-<?php echo $roww;?>"><label>Leader: </label> </div>
			<div class="col-sm-10" id="conleader">
			<?php
			$op =list_staff($res,0,0);
			$inn = "<div id='conau_1'><select name='author_1' class='form-control'>".$op."</select></div>";
			?>
			<div class='form-group' id='au_1'><div class='row'><div class='col-sm-7'><?php echo $inn;?></div><div class='col-sm-3'><div class='checkboxku'><input type='checkbox' name='leadernot' id='ck_1' onchange='chkstaff(1)' checked /><label for='ck_1' class='aku'>FKP Staff </label> </div></div></div></div>

			</div>
			
			</div>

			</div>
			
						
			
			<div class="form-group">
			<div class="row">
			<div class="col-sm-<?php echo $roww;?>"><label>Members: </label></div>
			<div class="col-sm-10">
			
			<div id="con-author">
			
			
			
			
			
			</div>
			
			<a class="btn btn-default btn-sm" id="more-au">
			<span class="glyphicon glyphicon-plus"></span> Add Member</a>
			
			</div>
			</div></div>
		
			<div class="form-group" id="fd_date">
			<div class="row">
			<div class="col-sm-<?php echo $roww;?>"><label>Start Date: </label> </div>
			<div class="col-sm-2">
			
			 <div class='input-group date' id='dstart'>
			<input type='text' class='form-control' name='date_start' value='' required />
			<span class='input-group-addon'>
			<span class='glyphicon glyphicon-calendar'></span>
                    </span>
			</div>
			
			
			</div>
			</div>
			</div>
			
			  <script type='text/javascript'>

			
			 $(function () {
            $('#dstart').datetimepicker({
               format: 'YYYY-MM-DD'
            });
        });
        </script>
		
		
		<div class="form-group" id="fd_date">
			<div class="row">
			<div class="col-sm-<?php echo $roww;?>"><label>End Date: </label> </div>
			<div class="col-sm-2">
			
			 <div class='input-group date' id='dend'>
			<input type='text' class='form-control' name='date_end' value='' required />
			<span class='input-group-addon'>
			<span class='glyphicon glyphicon-calendar'></span>
                    </span>
			</div>
			
			
			</div>
			</div>
			</div>
			
			  <script type='text/javascript'>

			
			 $(function () {
            $('#dend').datetimepicker({
               format: 'YYYY-MM-DD'
            });
        });
        </script>
			
			<div class="form-group" id="fd_isbn">
			<div class="row">
			<div class="col-sm-<?php echo $roww;?>"><label>Resource/ Sponsorship: </label> </div>
			<div class="col-sm-6"><input class='form-control'  type='text' name='res_source' value=""  /></div>
			</div>
			</div>
			
			<div class="form-group" id="fd_isbn">
			<div class="row">
			<div class="col-sm-<?php echo $roww;?>"><label>Status: </label> </div>
			<div class="col-sm-2"><select name='res_status' class="form-control">
			<option value="0">On Going</option>
			<option value="1">Completed</option>
			</select></div>
			</div>
			</div>
			
			<div class="form-group" id="fd_index">
			<div class="row">
			<div class="col-sm-<?php echo $roww;?>"><label>Amount: </label> </div>
			<div class="col-sm-4">
			
			<div class="input-group">
  <span class="input-group-addon">RM</span>
  <input type="text" class="form-control" name="res_amount" value="">
</div>

			
			
			</div>
			</div>
			</div>
			
			
			
			<div class="form-group">
			<div class="row">
			<div class="col-sm-<?php echo $roww;?>"></div>
			<div class="col-sm-3"><button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-floppy-disk"></span> SAVE RESEARCH</button></div>
			</div></div>
			<input type="hidden" name="p" value="resAdmin" />
			<input type="hidden" name="t" value="admin" />
			<input type="hidden" name="res_leader" value="<?php echo $_SESSION['staff_id']; ?>" />
			<input type="hidden" name="submit_new_res" value="1" />
			
			</form>


			<script>
			$(document).ready(function(){
				
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
				inn = inputList(1);
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
				op ="<?php echo list_staff($res,0,0)?>";
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


<?php
}
?>