<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\modules\courseFiles\views\admin\Show;
use backend\modules\courseFiles\models\Common;
?>


<div class="box-header">
  <div class="box-title"><b>Peringkat Semak/ Evaluation Level
     <br/><div class="box-title">(CHECK)</b></div>
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
    
        $item = $model->itemCheck;
        $offer =  $modelOffer;
	   $version = $offer->course_version;
	   $version2 = $offer->course_version2;

        echo '<tr><td>'.$item[0]->id.'</td>
                <td>'.$item[0]->item.'<i><br/>'.$item[0]->item_bi.'</i></td>
                <td>';
			echo Show::showCoor($offer, 'coordinatorResultFinalFiles', 'coordinator-result-final-file', 'result_final');
				
			

        echo '<tr><td>'.$item[1]->id.'</td>
                <td>'.$item[1]->item.'<i><br/>'.$item[1]->item_bi.'</i></td>
                <td>';
			$boo = true;
			if($offer->appointmentLetter){
				echo '<ul>';
				foreach ($offer->appointmentLetter as $letter) {
						if($letter->staffInvolved && $letter->tutorial_only == 0){
							$name =  $letter->staffInvolved->staff->staff_title . ' ' .$letter->staffInvolved->staff->user->fullname; 
								if($letter->steva_file){
									$boo = $boo == false ? false : true;
									echo'<li><a href="'.Url::to(['appointment/download-file', 'attr' => 'steva', 'id' => $letter->id]).'" target="_blank" >'.strtoupper($name).' '. Common::pTick().'</a></li>';
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
         
                      
                      

          echo '</td>';
        
        
        echo '<tr><td>'.$item[2]->id.'</td>
                <td>'.$item[2]->item.'<i><br/>'.$item[2]->item_bi.'</i></td>
                <td>';
				
				if($version2 > 0){
					echo '<div class="grup"><i>Group 1</i></div>';
				}
		
		echo '<ul>';
				
				
				$boo = true;
				$clo_html = '';
			if($offer->lectures){
                foreach ($offer->lectures as $lecture) {
					if($lecture->prg_stu_assess == 1){
						$boo = $boo == false ? false : true;
						$clo_html .= '<li><a href="'.Url::to(['/course-files/default/clo-analysis-pdf', 'id'=> $lecture->id]).'" target="_blank">'.$lecture->lec_name .' - CLO ANALYSIS '.Common::pTick().'</a></li>';
					}else{
						$boo = false;
						$clo_html .= '<li>'.$lecture->lec_name .' - CLO ANALYSIS ' .Common::pTick(false). '</li>';
					}
					
				}
				
				
				echo '<li><a href="'.Url::to(['/course-files/default/clo-summary-pdf', 'id'=> $offer->id]).'" target="_blank">CLO SUMMARY '.Common::pTick($boo).'</a></li>';
				echo $clo_html;
				
			}else{
				$boo = false;
				echo'<li>'.Common::pTick(false).'</li>';
			}
				
				
		echo '</ul>';
		
		if($version2 > 0){
					echo '<div class="grup"><i>Group 2</i></div>';
				}
		
		echo '</td>
                <td>' . Common::pTick($boo);
      
                  
          echo '</td>';


        echo '<tr><td>'.$item[3]->id.'</td>
                <td>'.$item[3]->item.'<i><br/>'.$item[3]->item_bi.'</i></td>
                <td>';
				  if($version == 0){
				echo 'The coordinator needs to select course version.';
			}else{
				echo '<ul>
				<li><a href="'.Url::to(['/esiap/course/fk3', 'course'=> $offer->course_id, 'version' => $version, 'offer' => $offer->id ,'xana' => 1]).'" target="_blank">FK03 - PENJAJARAN KONSTRUKTIF</a><br />
				<i>(CLO achievement result)</i>
				</li>
				</ul>
				';
			}
				
			echo '</td>
                <td>' . Common::pTick($boo);
        
                      
                    
               
          echo '</td>';
        
        ?>
      </tr>
    </thead>
   
  </table>
</div>
