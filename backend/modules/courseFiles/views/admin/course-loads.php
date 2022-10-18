<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\modules\courseFiles\models\Common;
use backend\modules\esiap\models\CourseAccess;

$closed = Common::isDue($offer->semesterDates->open_deadline);

?>
<h4><?=$offer->semester->longFormat()?></h4>
<?php 
$access = false;
if(CourseAccess::hasAccess($offer) and !$closed){
    $access = true;
}
$access = true;
?>
<div class="box">

<div class="box-body">


  <table class="table table-striped">
  <tr>
  <td width="20%">Coordinator</td><td>
  
  
  <?php
  if($access){
      echo '<a href="'.Url::to(['default/teaching-assignment-coordinator', 'id' => $offer->id]).'" target="_blank">' . $offer->coor->niceName  . '</a>'; 
  }else{
      echo $offer->coor->niceName ;
  }
  
  ?>
  
  
  </td>
  </tr>
   <tr>
  <td>Coordinator Progress</td><td><div class="row"><div class="col-md-2"><?=$offer->progressCoordinatorBar ?></div></div></td>
  </tr>
   <tr>
  <td>Course File Overall Progress</td><td><div class="row"><div class="col-md-2"><?=$offer->progressOverallBar ?></div></div></td>
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
		<th>Progress</th>
		 <th width="10%">Tutorials</th>
		 <th>Tutors</th>
		 <th>Progress</th>
		
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

		   <td '.$rowspan_1.'>';
		   if($access){
			  echo '<a href="'.Url::to(['default/teaching-assignment-lecture', 'id' => $lec->id]).'" target="_blank">' . $lec->lec_name . '</a>'; 
		   }else{
			  echo $lec->lec_name;  
		   }
		  
		  echo '</td>
		  <td '.$rowspan_1.'>';
		  
		  if($lec->lecturers){
			  $str_lec = '';
			$n=1;
			foreach($lec->lecturers as $lecturer){
				$slash = $n==1 ? '':' / ';
				$str_lec .= $slash.$lecturer->staff->niceName;
			$n++;
			}
			
			if($access){
			  echo '<a href="'.Url::to(['default/teaching-assignment-lecture', 'id' => $lec->id]).'" target="_blank">' . $str_lec . '</a>'; 
		   }else{
			  echo $str_lec;  
		   }
			
		}
		
		
		
					
		     echo'</td><td '.$rowspan_1.'>'.$lec->progressOverallBar.'</td>';
			 
		colum_2_first($lec->tutorials,$offer->id, $lec, $access);
		 
		
		//delete lecture - kena confirm ni
	 	echo '<td '.$rowspan_1.'>
		
		</td>
      '; 
	  
	  echo '</tr>';
	  
	  
	  colum_2($lec->tutorials,$offer->id, $lec, $access);
	 
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
function colum_2_first($tutorial,$offer, $lec, $access){
	if($tutorial){
		$tutorial = $tutorial[0];
		colum_2_td($tutorial,$offer, $lec, $access);
	}else{
		empty_cell(4);
	}
	
}
function colum_2($tutorials,$offer, $lec, $access){
	if($tutorials){
		$i=1;
			foreach($tutorials as $tutorial){
				if($i > 1){
					echo '<tr>';
					colum_2_td($tutorial,$offer, $lec, $access);
					echo '</tr>';
				}
			$i++;
			}
		}
}

function colum_2_td($tutorial,$offer, $lec, $access){
	echo'
	<td>';
	
	if($access){
	  echo '<a href="'.Url::to(['default/teaching-assignment-tutorial', 'id' => $tutorial->id]).'" target="_blank">' . $tutorial->tutorialName . '</a>'; 
   }else{
	 echo $tutorial->tutorialName;
   }
	
	
	echo '</td>
	
	<td>';
	
	if($tutorial->tutors){
		
		
		$str_tut = '';
			$n=1;
			foreach($tutorial->tutors as $lecturer){
				$slash = $n==1 ? '':' / ';
				$str_tut .= $slash.$lecturer->staff->niceName;
			$n++;
			}
		if($access){
		  echo '<a href="'.Url::to(['default/teaching-assignment-tutorial', 'id' => $tutorial->id]).'" target="_blank">' . $str_tut . '</a>'; 
	   }else{
		 echo $str_tut;
	   }
	}
		
	
	
//$tutorial->tutors


	echo'</td>
	<td>'.$tutorial->progressOverallBar.'</td>
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
