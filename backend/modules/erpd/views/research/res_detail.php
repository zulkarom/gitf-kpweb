<?php
$res = new Research;
$id = $_GET['id'];
$row = $res->researchDetail($id);
if($row->res_status == 1){
	$status = "Completed";
}else{
	$status ="On Going";
}

$result_au = $res->listresearchersEx($id);
	$string_mem = "";
	$i =1;
	foreach($result_au as $row_au){
		$staff = $row_au['staff_id'];
		if($staff==0){
			$name = $row_au['ext_name']." (Ext.)";
		}else{
			$name = $res->getStaffName($staff);
		}
		if($i==1){
			
			$string_mem .= "<strong>".$name." (Leader)</strong><br />";
		}else{
			$string_mem .= $name."<br />";
		}
	$i++;
	}
?>
<div class="row">
	<div class="col-sm-2"><strong>Title:</strong></div>
	<div class="col-sm-10"><?php echo $row->res_title;?></div>
</div>
<div class="row">
	<div class="col-sm-2"><strong>Grant:</strong></div>
	<div class="col-sm-10"><?php 
	$gra = $row->res_grant;
	echo $res->getGrantName($gra);
	if($gra == 9){
		echo "<br/>(".$row->res_grant_others .")";
	}
	?></div>
</div>
<div class="row">
	<div class="col-sm-2"><strong>Members:</strong></div>
	<div class="col-sm-10"><?php echo $string_mem;?></div>
</div>
<div class="row">
	<div class="col-sm-2"><strong>Start Date:</strong></div>
	<div class="col-sm-10"><?php echo $row->date_start;?></div>
</div>
<div class="row">
	<div class="col-sm-2"><strong>End Date:</strong></div>
	<div class="col-sm-10"><?php echo $row->date_end;?></div>
</div>
<div class="row">
	<div class="col-sm-2"><strong>Resource:</strong></div>
	<div class="col-sm-10"><?php echo $row->res_source;?></div>
</div>
<div class="row">
	<div class="col-sm-2"><strong>Status:</strong></div>
	<div class="col-sm-10"><?php echo $status;?></div>
</div>
<div class="row">
	<div class="col-sm-2"><strong>Amount:</strong></div>
	<div class="col-sm-10">RM<?php echo number_format($row->res_amount,2);?></div>
</div>



