
<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
?>


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
        <th>Progress</th>
      </tr>
    
        
        <tr>
        <?php 
    
       $item = $model->itemPlan;
       $offer =  $modelOffer;
	   $version = $offer->course_version;
	   $material = $offer->material;
          
          echo '<tr><td>'.$item[0]->id.'</td>
                <td>'.$item[0]->item.'<i><br/>'.$item[0]->item_bi.'</i></td>
                <td>';
			if($version == 0){
				echo 'Coordinator need to select course version.';
			}else{
				echo '<ul>
				<li><a href="'.Url::to(['/esiap/course/fk1', 'course'=> $offer->course_id, 'version' => $version]).'" target="_blank">FK01 - PRO FORMA KURSUS</a></li>
				</ul>
				';
			}
				 
				
			echo '</td>
                <td></td>';
       
          echo '<tr><td>'.$item[1]->id.'</td>
                <td>'.$item[1]->item.'<i><br/>'.$item[1]->item_bi.'</i></td>
                <td>';
				if($version == 0){
				echo 'Coordinator need to select course version.';
			}else{
				echo '<ul>
					<li><a href="'.Url::to(['/esiap/course/fk2', 'course'=> $offer->course_id, 'version' => $version]).'" target="_blank">FK02 - MAKLUMAT KURSUS</a></li>
					</ul>
					';
			}
				
				
			echo '</td>
                <td></td>';

          echo '<tr><td>'.$item[2]->id.'</td>
                <td>'.$item[2]->item.'<i><br/>'.$item[2]->item_bi.'</i></td>
                <td>';
				if($version == 0){
				echo 'Coordinator need to select course version.';
			}else{
				echo '<ul>
					<li><a href="'.Url::to(['/esiap/course/fk3', 'course'=> $offer->course_id, 'version' => $version]).'" target="_blank">FK03 - PENJAJARAN KONSTRUKTIF</a></li>
					</ul>
					';
			}
				
			echo '</td>
                <td>';
				
				 
				
				
		echo '</td>';

          echo '<tr><td>'.$item[3]->id.'</td>
                <td>'.$item[3]->item.'<i><br/>'.$item[3]->item_bi.'</i></td>
                <td>';
				
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
			  }
				
				echo '</td>
                <td>';

                      
                     

          echo'</td>';

          echo '<tr><td>'.$item[4]->id.'</td>
                <td>'.$item[4]->item.'<i><br/>'.$item[4]->item_bi.'</i></td>
                <td>';
				
				if($offer->material_version == 0){
				echo 'Coordinator need to select material version.';
			}else{
				if($material->items){
					echo '<ul>';
				foreach ($material->items as $file) {
				  echo '<li>' . Html::a(strtoupper($file->item_name), ['/course-files/material/download-file', 'attr' => 'item','id'=> $file->id],['target' => '_blank']);
				  echo '</li>';
				  $i++;
				}
				echo '</ul>';
				}
			}
				
			echo '</td>
                <td>';
          echo '</td>';

          echo '<tr><td>'.$item[5]->id.'</td>
                <td>'.$item[5]->item.'<i><br/>'.$item[5]->item_bi.'</i></td>
                <td>';
				
			if($offer->appointmentLetter){
				echo '<ul>';
				foreach ($offer->appointmentLetter as $letter) {
					if($letter->status == 10){
						if($letter->staffInvolved){
						$name =  $letter->staffInvolved->staff->staff_title . ' ' .$letter->staffInvolved->staff->user->fullname; 
						echo'<li><a href="'.Url::to(['/teaching-load/appointment-letter/pdf/', 'id' => $letter->id]).'" target="_blank" >'.strtoupper($name).'</a></li>';
						}
						
					}
					
				}
				echo '</ul>';
			}
				
		echo '</td>
                <td>';



                      
                      
          echo'</td>';

          echo '<tr><td>'.$item[6]->id.'</td>
                <td>'.$item[6]->item.'<i><br/>'.$item[6]->item_bi.'</i></td>
                <td>';
				
				if($offer->appointmentLetter){
				echo '<ul>';
				foreach ($offer->appointmentLetter as $letter) {
						if($letter->staffInvolved){
						
						if($letter->staffInvolved->timetable_file){
							$name =  $letter->staffInvolved->staff->staff_title . ' ' .$letter->staffInvolved->staff->user->fullname; 
						echo'<li><a href="'.Url::to(['/course-files/staff/download-file/', 'attr' => 'timetable', 'id' => $letter->staffInvolved->id]).'" target="_blank" >'.strtoupper($name).'</a></li>';
						}
						
						
						}
						
				}
				echo '</ul>';
			}
				
		echo '</td>
                <td></td>';
              ?>
      </tr>
    </thead>
  </table>

</div>