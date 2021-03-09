<?php
use yii\helpers\Html;
?>
<h4><?=$offer->semester->longFormat()?></h4>
<div class="box">

<div class="box-body">


  <table class="table table-striped">
  <tr>
  <td width="16%">Coordinator</td><td><?=$offer->coor->niceName ?></td>
  </tr>
   <tr>
  <td>Progress</td><td><div class="row"><div class="col-md-2"><?=$offer->progressOverallBar ?></div></div></td>
  </tr>
  <tr>
  <td>Course File Status</td><td><?=$offer->statusName ?></td>
  </tr>
 
</table>




<div class="table-responsive">
  <table class="table">
    <thead>
      <tr>
 
        <th>#</th>
        <th width="10%">Lectures</th>
        <th>Lecturers</th>
		 <th width="10%">Tutorials</th>
		 <th>Tutors</th>
		
      </tr>
    </thead>
    <tbody>
      
	  <?php 
	  
	  if($offer->lectures){
		  $i = 1;
		 foreach($offer->lectures as $lec){
			 echo '<tr>';
			$rowspan_1 = rowspan_1($lec->tutorials);
			echo '
			 <td '.$rowspan_1.'>'.$i.'. </td> 

		   <td '.$rowspan_1.'>
		  '.$lec->lec_name.'
		  </td>
		  <td '.$rowspan_1.'>';
		
		if($lec->lecturers){
			$n=1;
			foreach($lec->lecturers as $lecturer){
				$slash = $n==1 ? '':' / ';
				echo $slash.$lecturer->staff->niceName;
			$n++;
			}
		}
					
		     echo'</td>';
			 
		colum_2_first($lec->tutorials,$offer->id, $lec);
		 
		
		//delete lecture - kena confirm ni
	 	echo '<td '.$rowspan_1.'>
		
		</td>
      '; 
	  
	  echo '</tr>';
	  
	  
	  colum_2($lec->tutorials,$offer->id, $lec);
	 
      $i++;
		 }
	  }
	  
	  
	  
	  ?>
      
    </tbody>
  </table>
</div>

</div>

</div>



<?php 




function rowspan_1($clo_as){
	if($clo_as){
		$kira = count($clo_as) ;
		return "rowspan='".$kira."'";
		
	}else{
		return "";
	}
}
function colum_2_first($tutorial,$offer, $lec){
	if($tutorial){
		$tutorial = $tutorial[0];
		colum_2_td($tutorial,$offer, $lec);
	}else{
		empty_cell(4);
	}
	
}
function colum_2($tutorials,$offer, $lec){
	if($tutorials){
		$i=1;
			foreach($tutorials as $tutorial){
				if($i > 1){
					echo '<tr>';
					colum_2_td($tutorial,$offer, $lec);
					echo '</tr>';
				}
			$i++;
			}
		}
}

function colum_2_td($tutorial,$offer, $lec){
	echo'
	<td>'.$lec->lec_name . $tutorial->tutorial_name.'</td>

	<td>';
	if($tutorial->tutors){
			$n=1;
			foreach($tutorial->tutors as $lecturer){
				$slash = $n==1 ? '':' / ';
				echo $slash.$lecturer->staff->niceName;
			$n++;
			}
		}
//$tutorial->tutors


	echo'</td>
	<td>

	</td>
	';
				
}

function empty_cell($colum){
	$str = "";
	for($i=1;$i<=$colum;$i++){
		echo "<td></td>";
	}
}


?>
