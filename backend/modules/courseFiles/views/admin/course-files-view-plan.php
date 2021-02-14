
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
	   $material = $offer->material_version;
          
          echo '<tr><td>'.$item[0]->id.'</td>
                <td>'.$item[0]->item.'<i><br/>'.$item[0]->item_bi.'</i></td>
                <td>';
			if($version == 0){
				echo 'Coordinator need to select course version.';
			}else{
				echo '<a href="'.Url::to(['/esiap/course/fk1', 'course'=> $offer->course_id, 'version' => $version]).'" target="_blank">FK01 - PRO FORMA KURSUS</a>';
			}
				 
				
			echo '</td>
                <td></td>';
       
          echo '<tr><td>'.$item[1]->id.'</td>
                <td>'.$item[1]->item.'<i><br/>'.$item[1]->item_bi.'</i></td>
                <td>';
				if($version == 0){
				echo 'Coordinator need to select course version.';
			}else{
				echo '<a href="'.Url::to(['/esiap/course/fk2', 'course'=> $offer->course_id, 'version' => $version]).'" target="_blank">FK02 - MAKLUMAT KURSUS</a>';
			}
				
				
			echo '</td>
                <td></td>';

          echo '<tr><td>'.$item[2]->id.'</td>
                <td>'.$item[2]->item.'<i><br/>'.$item[2]->item_bi.'</i></td>
                <td>';
				if($version == 0){
				echo 'Coordinator need to select course version.';
			}else{
				echo '<a href="'.Url::to(['/esiap/course/fk3', 'course'=> $offer->course_id, 'version' => $version]).'" target="_blank">FK03 - PENJAJARAN KONSTRUKTIF</a>';
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
				  echo '<li>' . Html::a($files->file_name, ['coordinator-rubrics-file/download-file', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
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
				
				if($material == 0){
				echo 'Coordinator need to select material version.';
			}else{
				//echo '<a href="'.Url::to(['/esiap/course/fk2', 'course'=> $offer->course_id, 'version' => $version]).'" target="_blank">FK02 - MAKLUMAT KURSUS</a>';
			}
				
			echo '</td>
                <td>';
          echo '</td>';

          echo '<tr><td>'.$item[5]->id.'</td>
                <td>'.$item[5]->item.'<i><br/>'.$item[5]->item_bi.'</i></td>
                <td></td>
                <td>';
                  Modal::begin([
                      'header' => '<h5>'.$item[5]->item.'</h5>',
                      'toggleButton' => ['label' => '<span class="glyphicon glyphicon-th-list"></span> View Files', 'class'=>'btn btn-sm btn-warning'],
                  ]);

                  echo '<table class="table">
                        <tr>
                        <th>Lecturers</th>
                        <th>Files</th>
                        </tr>
                        ';
                          if($offer->appointmentLetter)
                          {
                            $i=1;
                            foreach ($offer->appointmentLetter as $letter) {  
                            $i++;
                        echo '<tr>
                        <td>';
						if($letter->staffInvolved){
							echo $letter
								->staffInvolved
								->staff
								->staff_title . ' ' .
								$letter
								->staffInvolved
								->staff
								->user
								->fullname; 
						}
                                          
                        echo'</td>
                        <td>';

                               echo'<a href="'.Url::to(['/teaching-load/appointment-letter/pdf/', 'id' => $letter->id]).'" target="_blank" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-download-alt"></span></a>';
                               }
                            } 

                        echo'</td></tr></table><br/>';
                      
                      
                  Modal::end();
          echo'</td>';

          echo '<tr><td>'.$item[6]->id.'</td>
                <td>'.$item[6]->item.'<i><br/>'.$item[6]->item_bi.'</i></td>
                <td></td>
                <td></td>';
              ?>
      </tr>
    </thead>
  </table>

</div>