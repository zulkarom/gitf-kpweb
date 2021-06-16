

<?php 

$dates = $model->confDates;

if($dates){
	echo '<table class="table table-hovered">
		<thead>
		<tr>
			<th>Date Items</th>
			<th>Dates</th>
		</tr>
		</thead>
	';
	foreach($dates as $date){
		if($date->published == 1){
				echo '<tr>';
			echo '<td>' . $date->dateName->date_name . '</td>';
			echo '<td> <i class="fa fa-calendar"></i> ' . date('d F Y', strtotime($date->date_start)) . '</td>';
			
		echo '</tr>';
		}
	
	}
	
	$type = $model->type_name;
	if($type == 1){
	    $n = 'Conference';
	}else if ($type == 2){
	    $n= 'Colloquium';
	}
	echo '<tr>
<td>'.$n.' Date</td>
<td> <i class="fa fa-calendar"></i> '.$model->conferenceDateRange . '</td>
</tr>
';
	echo '</table>';
}

?>
