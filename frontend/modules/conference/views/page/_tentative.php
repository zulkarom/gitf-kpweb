<?php 
$days = $model->tentativeDays;

if($days ){
foreach($days as $day){
?>
<div class="table-responsive">
  <table class="table table-hover">
    <thead>
      <tr>
        <th colspan="2"><div align="center"><?=date('d M Y (l)' ,strtotime($day->conf_date))?></div></th>
      </tr>
	  <tr>
        <th width="20%">Time</th>
		<th>Activities</th>
      </tr>
    </thead>
    <tbody>
	
	<?php 
	$times = $day->tentativeTimes;
	
	if($times){
		foreach($times as $time){
			echo '<tr>
        <td>'.$time->ttf_time .'</td>
        <td>'.$time->ttf_item .'</td>
      </tr>';
		}
		
	}
	
	
	?>
      
    </tbody>
  </table>
</div>
<br /><br />
<?php 

}
}

?>