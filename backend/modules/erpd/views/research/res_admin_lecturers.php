<div class="box">
<div class="box-header"></div>
<div class="box-body"><table class="table table-hover table-striped">

<?php
$res = new Research;
$cyear = date("Y");
$lyear = $cyear -1;
$llyear = $cyear -2;
echo "<thead>
<tr>
	<th>No.</th>
	<th>Name</th>
	<th>".$cyear."</th>
	<th>".$lyear."</th>
	<th>".$llyear."</th>
	<th>Others</th>
	<th>Total</th>
</tr>
</thead>
<tbody>";

$result = $res->listResearchersUniq();
$i=1;
foreach($result as $row){
	$staff_id = $row['staff_id'];
	$total = $res->get_num_res($staff_id);
	$y1 = $res->get_num_res($staff_id,$cyear);
	$y2 = $res->get_num_res($staff_id,$lyear);
	$y3 = $res->get_num_res($staff_id,$llyear);
	$other = $total - $y1 - $y2 - $y3;
	echo "<tr>
	<td>".$i."</td>
		<td>".$row['staff_name']."</td>
		<td>".$y1."</td>
		<td>".$y2."</td>
		<td>".$y3."</td>
		<td>".$other."</td>
		<td>".$total."</td>
	</tr>";
$i++;
}

?>
</tbody>
</table></div>
</div>