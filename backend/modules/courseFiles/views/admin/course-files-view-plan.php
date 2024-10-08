
<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\modules\courseFiles\models\Common;
use backend\modules\esiap\models\CourseAccess;

$item = $model->itemPlan;
$offer =  $modelOffer;
$closed = Common::isDue($offer->semesterDates->open_deadline);
$access = false;
if(CourseAccess::hasAccess($offer) and !$closed){
    $access = true;
}


?>
<style>
.grup {
	margin-left:24px;
	font-weight:normal;
	font-style:italic;
}
</style>

<div class="box">
<div class="box-header">
  <div class="box-title"><b>Peringkat Perancangan/Planning Level
    <br/><div class="box-title">(PLAN)</b></div>
</div>
</div>
<div class="box-body">
 <table class="table">
    <thead>
      <tr>
        <th style="width:5%">No.</th>
        <th style="width:40%">Item</th>
        <th style="width:40%">Files</th>
        <th>Check</th>
      </tr>
    
        
        <tr>
        <?php 
    
      
	   $version = $offer->course_version;
	   $version2 = $offer->course_version2;
	   $material = $offer->material;
        $check = '';
          echo '<tr><td>'.$item[0]->id.'</td>
                <td>'.$item[0]->item.'<i><br/>'.$item[0]->item_bi.'</i></td>
                <td>';
			if($version == 0){
				$check = Common::pTick(false);
				echo 'Coordinator need to select course version.';
			}else{
				$check = Common::pTick();
				if($version2 > 0){
					echo '<div class="grup"><i>Group 1</i></div>';
				}
				
				echo '<ul>
			
				<li><a href="'.Url::to(['/esiap/course/fk1', 'course'=> $offer->course_id, 'version' => $version]).'" target="_blank">FK01 - PRO FORMA KURSUS</a></li>
				</ul>
				';
				if($version2 > 0){
					echo '<div class="grup"><i>Group 2</i></div>';
					echo '<ul>
			
				<li><a href="'.Url::to(['/esiap/course/fk1', 'course'=> $offer->course_id, 'version' => $version2]).'" target="_blank">FK01 - PRO FORMA KURSUS</a></li>
				</ul>
				';
				}
			}
				 
				
			echo '</td>
                <td>'.$check.'</td>';
       
          echo '<tr><td>'.$item[1]->id.'</td>
                <td>'.$item[1]->item.'<i><br/>'.$item[1]->item_bi.'</i></td>
                <td>';
				if($version == 0){
				echo 'The coordinator needs to select course version.';
			}else{
				if($version2 > 0){
					echo '<div class="grup"><i>Group 1</i></div>';
				}
				echo '<ul>
					<li><a href="'.Url::to(['/esiap/course/fk2', 'course'=> $offer->course_id, 'version' => $version, 'offer' => $offer->id]).'" target="_blank">FK02 - MAKLUMAT KURSUS</a></li>';
					
					$type_link = $offer->courseVersion->version_type_id == 1 ? 'tbl4' : 'tbl4-pdf';
					echo '<li><a href="'.Url::to(['/esiap/course/' . $type_link, 'course'=> $offer->course_id, 'version' => $version, 'team' => $offer->id]).'" target="_blank">TABLE 4</a></li>
					</ul>
					';
				if($version2 > 0){
					echo '<div class="grup"><i>Group 2</i></div>';
					echo '<ul>
					<li><a href="'.Url::to(['/esiap/course/fk2', 'course'=> $offer->course_id, 'version' => $version2, 'offer' => $offer->id]).'" target="_blank">FK02 - MAKLUMAT KURSUS</a></li>';
					$type_link = $offer->courseVersion2->version_type_id == 1 ? 'tbl4' : 'tbl4-pdf';
					echo '<li><a href="'.Url::to(['/esiap/course/' . $type_link, 'course'=> $offer->course_id, 'version' => $version2, 'team' => $offer->id]).'" target="_blank">TABLE 4</a></li>
					</ul>
					';
				}
			}
				
				
			echo '</td>
                <td>'.$check.'</td>';

          echo '<tr><td>'.$item[2]->id.'</td>
                <td>'.$item[2]->item.'<i><br/>'.$item[2]->item_bi.'</i></td>
                <td>';
				if($version == 0){
				echo 'The coordinator needs to select course version.';
			}else{
				if($version2 > 0){
					echo '<div class="grup"><i>Group 1</i></div>';
				}
				echo '<ul>
					<li><a href="'.Url::to(['/esiap/course/fk3', 'course'=> $offer->course_id, 'version' => $version, 'offer' => $offer->id]).'" target="_blank">FK03 - PENJAJARAN KONSTRUKTIF</a></li>
					</ul>
					';
				if($version2 > 0){
					echo '<div class="grup"><i>Group 2</i></div>';
					echo '<ul>
					<li><a href="'.Url::to(['/esiap/course/fk3', 'course'=> $offer->course_id, 'version' => $version2, 'offer' => $offer->id]).'" target="_blank">FK03 - PENJAJARAN KONSTRUKTIF</a></li>
					</ul>';
				}
			}
				
			echo '</td>
                <td>'.$check.'';
				
				 
				
				
		echo '</td>';

          echo '<tr><td>'.$item[3]->id.'</td>
                <td>'.$item[3]->item.'<i><br/>'.$item[3]->item_bi.'</i></td>
                <td>';
			$check = Common::pTick();
			if($offer->coordinatorRubricsFiles)
			  {
				$i=1;
				echo '<ul>';
				foreach ($offer->coordinatorRubricsFiles as $files) {
				  echo '<li>' . Html::a(strtoupper($files->file_name), ['coordinator-rubrics-file/download-file', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
				  echo '</li>';
				  $i++;
				}
				echo '</ul>';
			  }else{
				  if($offer->na_cont_rubrics == 1){
					  echo '<ul>
							<li><a href="'.Url::to('@web/doc/na.pdf').'" target="_blank">N/A</a></li>
						</ul>
						';
				  }else{
					  echo '<ul>
							<li>'.Common::pTick(false).'</li>
						</ul>
						';
					  $check = Common::pTick(false);
				  }
			  }
				
				echo '</td>
                <td>'.$check.'';

                      
                     

          echo'</td>';

          echo '<tr><td>'.$item[4]->id.'</td>
                <td>'.$item[4]->item.'<i><br/>'.$item[4]->item_bi.'</i></td>
                <td>';
				
				if($offer->material_version == 0){
				$check = Common::pTick(false);
				echo 'The coordinator needs to select material version.';
			}else{
				if($material && $material->items){
					$check = Common::pTick();
					echo '<ul>';
					$i = 1;
				foreach ($material->items as $file) {
				  echo '<li>' . Html::a(strtoupper($file->item_name), ['/course-files/material/download-file', 'attr' => 'item','id'=> $file->id],['target' => '_blank']);
				  echo '</li>';
				  $i++;
				}
				echo '</ul>';
				}
			}
				
			echo '</td>
                <td>' . $check;
          echo '</td>';

          echo '<tr><td>'.$item[5]->id.'</td>
                <td>'.$item[5]->item.'<i><br/>'.$item[5]->item_bi.'</i></td>
                <td>';
			$boo = false;	
			if($offer->appointmentLetter){
				echo '<ul>';
				$boo = true;
				foreach ($offer->appointmentLetter as $letter) {
				
						if($letter->staffInvolved){
						$name =  $letter->staffInvolved->staff->staff_title . ' ' .$letter->staffInvolved->staff->user->fullname; 
    						if($letter->manual_file){
    						    $boo = $boo == false ? false : true;
    						    echo '<a href="' . Url::to(['/teaching-load/default/appointment-letter-manual', 'id' => $letter->id]) . '" target="_blank">'.strtoupper($name).' '. Common::pTick().'</a>';
    						}else if($letter->status == 10){
								$boo = $boo == false ? false : true;
								echo'<li><a href="'.Url::to(['/teaching-load/appointment-letter/pdf/', 'id' => $letter->id]).'" target="_blank" >'.strtoupper($name).' '. Common::pTick().'</a></li>' ;
							}else{
								$boo = false;
								echo'<li>'.strtoupper($name).' '.Common::pTick(false).'</li>';
							}
						
						}
					
				}
				echo '</ul>';
			}else{
				$boo = false;
				echo'<ul><li>'.Common::pTick(false).'</li></ul>';
			}
				
		echo '</td>
                <td>' . Common::pTick($boo);



                      
                      
          echo'</td>';

          echo '<tr><td>'.$item[6]->id.'</td>
                <td>'.$item[6]->item.'<i><br/>'.$item[6]->item_bi.'</i></td>
                <td>';
				
				if($offer->appointmentLetter){
				echo '<ul>';
				$boo = true;
				foreach ($offer->appointmentLetter as $letter) {
						if($letter->staffInvolved){
						$name =  $letter->staffInvolved->staff->staff_title . ' ' .$letter->staffInvolved->staff->user->fullname; 
						$link = '';
						if($access){
						    $link = ' <a href="'. Url::to(['default/timetable', 's' => $offer->semester_id, 'staff' => $letter->staffInvolved->staff_id, 'c' => $controller, 'm' => $method, 'offer' => $offer->id]) .'" class="btn btn-warning btn-xs"> <i class="fa fa-edit"></i> Update<a/>';
						}
						if($letter->staffInvolved->timetable_file){
							$boo = $boo == false ? false : true;
							echo'<li><a href="'.Url::to(['/course-files/staff/download-file/', 'attr' => 'timetable', 'id' => $letter->staffInvolved->id]).'" target="_blank" >'.strtoupper($name).'  '.Common::pTick().'</a> '.$link.'</li>';
						}else{
							$boo = false;
							echo'<li>'.strtoupper($name).'  '.Common::pTick(false).' '. $link .'</li>';
						}
						
						
						}
						
				}
				echo '</ul>';
			}else{
				$boo = false;
				echo'<ul><li>'.Common::pTick(false).'</li></ul>';
			}
				
		echo '</td>
                <td> '.Common::pTick($boo).'</td>';
              ?>
      </tr>
    </thead>
  </table>

</div>