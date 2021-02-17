<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
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
        <th>Progress</th>
      </tr>
    
        
        <tr>
        <?php 
    
        $item = $model->itemCheck;
        $offer =  $modelOffer;

        echo '<tr><td>'.$item[0]->id.'</td>
                <td>'.$item[0]->item.'<i><br/>'.$item[0]->item_bi.'</i></td>
                <td>';
				
				if($offer->coordinatorResultFinalFiles)
			  {
				$i=1;
				echo '<ul>';
				foreach ($offer->coordinatorResultFinalFiles as $file) {
				  echo '<li>' . Html::a(strtoupper($file->file_name), ['coordinator-result-final-file/download-file', 'attr' => 'path','id'=> $file->id],['target' => '_blank']);
				  echo '</li>';
				  $i++;
				}
				echo '</ul>';
			  }
				
				echo '</td>
                <td>';
     
                     
                 
          echo '</td>';

        echo '<tr><td>'.$item[1]->id.'</td>
                <td>'.$item[1]->item.'<i><br/>'.$item[1]->item_bi.'</i></td>
                <td>';
				
			if($offer->appointmentLetter){
				echo '<ul>';
				foreach ($offer->appointmentLetter as $letter) {
					if($letter->status == 10){
						if($letter->staffInvolved){
							$name =  $letter->staffInvolved->staff->staff_title . ' ' .$letter->staffInvolved->staff->user->fullname; 
								if($letter->steva_file){
									echo'<li><a href="'.Url::to(['appointment/download-file', 'attr' => 'steva', 'id' => $letter->id]).'" target="_blank" >'.strtoupper($name).'</a></li>';
								}else{
									echo'<li>'.strtoupper($name).'</li>';
								}
						
						
						}
						
					}
					
				}
				echo '</ul>';
			}
				
				echo '</td>
                <td>';
         
                      
                      

          echo '</td>';
        
        
        echo '<tr><td>'.$item[2]->id.'</td>
                <td>'.$item[2]->item.'<i><br/>'.$item[2]->item_bi.'</i></td>
                <td><ul>';
				
				echo '<li><a href="'.Url::to(['/course-files/default/clo-summary-pdf', 'id'=> $offer->id]).'" target="_blank">CLO SUMMARY</a></li>';
                foreach ($offer->lectures as $lecture) {  
					echo '<li><a href="'.Url::to(['/course-files/default/clo-analysis-pdf', 'id'=> $lecture->id]).'" target="_blank">'.$lecture->lec_name .' - CLO ANALYSIS</a></li>';
				}
				
		echo '</ul></td>
                <td>';
      
                  
          echo '</td>';


        echo '<tr><td>'.$item[3]->id.'</td>
                <td>'.$item[3]->item.'<i><br/>'.$item[3]->item_bi.'</i></td>
                <td>';
				  if($offer->coordinatorAnalysisCloFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorAnalysisCloFiles as $files) {
                          echo Html::a("File ".$i, ['coordinator-analysis-clo-file/download', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
                          echo '<br/>';
                          $i++;
                        }
                      }
				//$offer->countAnalysisCloFiles
				
			echo '</td>
                <td>';
        
                      
                    
               
          echo '</td>';
        
        ?>
      </tr>
    </thead>
   
  </table>
</div>
