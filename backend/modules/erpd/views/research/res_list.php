<?php
$res = new Research;
 $curr = date('Y');
		if(!isset($_GET['fr'])){
			$y22 = date('Y');
		}else{
			$y22 = $_GET['fr'];
		}
		 
		if(!isset($_GET['to'])){
			$y11 = $curr - 5;//showing last 5 year by default
		}else{
			$y11 = $_GET['to'];
		}


if($_SESSION['user_level']==1 and isset($_GET['id'])){
	$staff_id = $pub->filter_get("id");
	$del = 0;
	$h2 = "<h3>".$pub->get_staff_name($staff_id)."</h3>
	<h4><a href='index.php?p=pubadmin' class='btn btn-default'>
	<span class='glyphicon glyphicon-arrow-left'></span> Back to Lecturers' Publication
	</a></h4>
	";
	$input = '<input type="hidden" name="p" value="pubadmin" />
	<input type="hidden" name="t" value="det" />
	<input type="hidden" name="id" value="'.$staff_id.'" />
	';
}else{
	$staff_id = $_SESSION['staff_id'];
	
	$h2 = "
	<br /><br />
		<a href='index.php?p=res&t=newres' class='btn btn-success'><span class='glyphicon glyphicon-plus'></span> NEW RESEARCH</a>
		
		 <a href='index.php?p=pdf&t=research&fr=".$y22."&to=".$y11."' target='_blank' class='btn btn-danger'>
	<span class='glyphicon glyphicon-download-alt'></span> REPORT </a>

	";
	$input = '<input type="hidden" name="p" value="res" />';
	//p=pubadmin&t=det&id=1
} 



?>


<form method="get" action="index.php">
<div class="row">
<div class="col-md-6"><?php echo $h2; ?></div>
<div class="col-md-6">



<div class="form-group">
<div class="row">
<div class="col-md-2"><label>From: </label></div>
<div class="col-md-3">
<select class="form-control" name="to">
<?php


$result = $res->res_list_year_fr($staff_id);

$x=0;
foreach($result as $row){
	$y = $row['c'];
	if($y>=$y11 && $x==0){$ss="selected";$x=1;}else{$ss="";}
	echo "<option value='".$y."' ".$ss.">".$y."</option>";
}
?>
</select>

</div>
<div class="col-md-1"><label>To: </label></div>
<div class="col-md-3">
<select class="form-control" name="fr">
<?php
$result = $res->res_list_year_end($staff_id);
foreach($result as $row){
	$y = $row['c'];
	if($y==$y22){$ss="selected";}else{$ss="";}
	echo "<option value='".$y."' ".$ss.">".$y."</option>";
}
?>
</select>

</div>
<div class="col-md-2">
<div class="form-group">
<?php
echo $input;
?>
<button type="submit" class="btn btn-default">Go </button></div>

</div>

</div>
</div>

</div>
</div>
</form>




<br />

<?php



include("message.php");


if(isset($_GET['fr'])){
	$y1 = $_GET['fr'];
}else{
	$y1 = 0;
}

if(isset($_GET['to'])){
	$y2 = $_GET['to'];
}else{
	$y2 = 0;
}


 $result = $res->listMyResearch($_SESSION['staff_id'],$y1,$y2);
 $tdata ="";
 $i=1;
 foreach($result as $row){
	 $st= $row['res_status'];
	 if($st==1){
		 $status = "Completed";
	 }else{
		 $status = "On Going";
	 }
	 if($row['res_leader']==$_SESSION['staff_id']){
		 $del = 1;
	 }else{
		 $del = 0;
	 }
	 $file = $row['res_file'];
	 $fs="";
	 if($file !=""){
		 $fs="<a href='index.php?p=pdf&t=res&m=".$row['res_id']."' target='_blank'><span class='fa fa-file-pdf-o'></span></a>";
	 }
	 $tdata .="<tr><td>".$i.". </td><td>".$fs."</td><td>";
	 $tdata .= "<a href='index.php?p=res&t=edit&m=".$row['res_id']."' >".str_replace("`","'",$row['res_title'])." <span class='glyphicon glyphicon-pencil'></a>";

	$ss = $res->getLeader($row['res_id']);
	foreach($ss as $leadID){
		$leadstaff = $leadID['staff_id'];
		$ext = $leadID['ext_name']." (Ext.)";
	}
	if($leadstaff==0){
		$leader = $ext;
	}else{
		$leader =$res->getStaffName($leadstaff);
	}
	 
	 $g = $row['res_grant'];
	 if($g==9){
		 $geran = "Others <br/>(".$row['res_grant_others'].")";
	 }else{
		 $geran =$res->getGrantName($row['res_grant']);
	 }
	 $tdata .= "</td><td>".$leader." </td><td>".date('d M Y',strtotime($row['date_start']))."</td><td>".$status."</td><td>".$geran."</td><td> RM".number_format($row['res_amount'], 2)."</td><td>";
	 if($del==1){
		$tdata .= "<a href='' class='btn btn-default btn-sm' data-toggle='modal' data-target='#modal-delete' data-res='".$row['res_id']."'><span class='glyphicon glyphicon-remove'></span></a>";
	}
	 $tdata .= "</td></tr>";
	 $i++;
 }
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body">
<table class='table table-hover table-striped'>
<thead><tr><th>No.</th><th></th><th>Title</th><th>Leader</th><th>Start</th><th>Status</th><th>Grant</th><th>Amount</th><th></th></tr></thead>
<?php echo $tdata; ?>
</table>
</div>
</div>


<div class="modal" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-content">
		<form method="post" action="index.php?p=res">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
		  </div>
		  <div id="modal-content" class="modal-body">
			<p>Are you sure to delete this research? </p>
			<p>This will also delete entries of other staff research that has been included as members of this research. </p>
			<p>This action cannot be undone.</p>
		   </div>
		  <div class="modal-footer">
		  
		  <input type="hidden" name="t" value="resDel" />
		  <input type="hidden" name="m" id="thedel" value="" />
		  <button type="submit" class="btn btn-danger">Delete</button>
		 
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
		  </div>
		   </form>
		</div>

		</div>
	  </div>
	</div>
	
	
<div class="modal fade" id="modal-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Research Information</h4>
		  </div>
		  <div id="modal-content" class="modal-body">
		  <div id="conres">Loading...</div>
		   </div>
		  <div class="modal-footer">
		  
		 
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>

		</div>
	  </div>
	</div>
	
	

<script>
$('#modal-delete').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget); // Button that triggered the modal
	var resId = button.data('res'); // Extract info from data-* attributes
	var modal = $(this);
	modal.find('#thedel').val(resId);
});
$('#modal-info').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget); // Button that triggered the modal
	var resId = button.data('res'); // Extract info from data-* attributes
	var modal = $(this);
	modal.find('#conres').load("index.php?p=res&t=detail&ajax=1&id="+resId);
	//modal.find('#conres').text("yooo");
});
</script>