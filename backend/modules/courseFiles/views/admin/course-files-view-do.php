<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
?>


<div class="box-header">
  <div class="box-title"><b>Peringkat Pelaksanaan/ Implementation Level
    <br/><div class="box-title">(DO)</b></div>
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
		
	$item = $model->itemDo;
        $offer =  $modelOffer;
    

        //list student
          echo '<tr><td>'.$item[0]->id.'</td>
                <td>'.$item[0]->item.'<i><br/>'.$item[0]->item_bi.'</i></td>
                <td>';
				
		if($offer->lectures){
			$i=1;
			echo '<ul>';
			foreach ($offer->lectures as $lecture) {  
				echo '<li><a href="'.Url::to(['/course-files/default/lecture-student-list-pdf', 'id'=> $lecture->id]).'" target="_blank">'.$lecture->lec_name .' - LIST OF STUDENTS</a></li>';
			}
			echo '</ul>';
		}
				
		echo '</td>
                <td></td>';


          echo '<tr><td>'.$item[1]->id.'</td>
                <td>'.$item[1]->item.'<i><br/>'.$item[1]->item_bi.'</i></td>
                <td>';
			if($offer->lectures){
			$i=1;
			echo '<ul>';
			foreach ($offer->lectures as $lecture) {  
				echo '<li><a href="'.Url::to(['/course-files/default/attendance-summary-pdf', 'id'=> $lecture->id]).'" target="_blank">'.$lecture->lec_name .' - CLASS ATTENDANCE</a></li>';
			}
			echo '</ul>';
		}
			
		echo '</td>
                <td></td>';

          echo '<tr><td>'.$item[2]->id.'</td>
                <td>'.$item[2]->item.'<i><br/>'.$item[2]->item_bi.'</i></td>
                <td>';
				

                            
            echo  showLecTut($offer, 'lectureCancelFiles', 'tutorialCancelFiles');


				
			echo '</td>
                <td>';

              

                        
          echo '</td>';

          echo '<tr><td>'.$item[3]->id.'</td>
                <td>'.$item[3]->item.'<i><br/>'.$item[3]->item_bi.'</i></td>
                <td>';
				
			 echo  showLecTut($offer, 'lectureReceiptFiles', 'tutorialReceiptFiles');
                           
				
			
		echo '</td>
                <td>';
                

                        
          echo '</td>';

          echo '<tr><td>'.$item[4]->id.'</td>
                <td>'.$item[4]->item.'<i><br/>'.$item[4]->item_bi.'</i></td>
                <td>';
				$offer =  $modelOffer;
                      if($offer->coordinatorAssessmentMaterialFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorAssessmentMaterialFiles as $files) {
                          echo Html::a("File ".$i, ['coordinator-assessment-material-file/download-file', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
                          echo '<br/>';
                          $i++;
                        }
                      }
				//$offer->countAssessmentMaterialFiles
				
				echo '</td>
                <td>';
    
                      
                
          echo '</td>';

          echo '<tr><td>'.$item[5]->id.'</td>
                <td>'.$item[5]->item.'<i><br/>'.$item[5]->item_bi.'</i></td>
                <td>';
				
				 $offer =  $modelOffer;
                      if($offer->coordinatorAssessmentScriptFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorAssessmentScriptFiles as $files) {
                          echo Html::a("File ".$i, ['coordinator-assessment-script-file/download-file', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
                          echo '<br/>';
                          $i++;
                        }
                      }
				
			echo '</td>
                <td>';
  
                     
                
          echo '</td>';

          echo '<tr><td>'.$item[6]->id.'</td>
                <td>'.$item[6]->item.'<i><br/>'.$item[6]->item_bi.'</i></td>
                <td>';
				$offer =  $modelOffer;
                      if($offer->coordinatorSummativeAssessmentFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorSummativeAssessmentFiles as $files) {
                          echo Html::a("File ".$i, ['coordinator-summative-assessment-file/download-file', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
                          echo '<br/>';
                          $i++;
                        }
                      }
				//$offer->countSummativeAssessmentFiles
				
			echo '</td>
                <td>';

                      
       
          echo '</td>';

          echo '<tr><td>'.$item[7]->id.'</td>
                <td>'.$item[7]->item.'<i><br/>'.$item[7]->item_bi.'</i></td>
                <td>'.$offer->countAnswerScriptFiles.'</td>
                <td>';
           
                     /*  $offer =  $modelOffer;
                      if($offer->coordinatorAnswerScriptFiles)
                      {
                        $i=1;
                        foreach ($offer->coordinatorAnswerScriptFiles as $files) {
                          echo Html::a("File ".$i, ['coordinator-answer-script-file/download-file', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
                          echo '<br/>';
                          $i++;
                        }
                      } */
                 
          echo '</td>';

          echo '<tr><td>'.$item[8]->id.'</td>
                <td>'.$item[8]->item.'<i><br/>'.$item[8]->item_bi.'</i></td>
                <td>';
				
			
						
						echo  showLecTut($offer, 'lectureExemptFiles', 'tutorialExemptFiles');
                              
              
				
		echo '</td>
                <td>';



                        
          echo '</td>';
        ?>
    
      </tr>
    </thead>
   
  </table>
</div>


<?php 

function showLecTut($offer, $lec_method, $tut_method){
	$html = '';
	if($offer->lectures){
	  $i=1;
	  $html .=  '<ul>';
	  foreach ($offer->lectures as $lectures) {
		$html .=  '<li>' . $lectures->lec_name;
		$j=1;
		if($lectures->$lec_method){
			$html .=  '<ul>';
		  foreach ($lectures->$lec_method as $file) {
		  
			$html .=  '<li>' . Html::a("File ".$j, ['lecture-cancel-file/download-file', 'attr' => 'path','id'=> $file->id],['target' => '_blank']) . '</li>';

			$j++;
		  }
		  $html .=  '</ul>';
		} 
		$html .=  '</li>';
		$i++;
	  }
	  $html .=  '</ul>';
	}


	if($offer->lectures){
		$html .=  '<ul>';
	  $i=1;
	  foreach ($offer->lectures as $lecture) {
		if($lecture->tutorials){
		  foreach ($lecture->tutorials as $tutorial) {
	  $html .=  '<li>' . $lecture->lec_name . $tutorial->tutorial_name;
		$j=1;
			if($tutorial->$tut_method){
			$html .=  '<ul>';
			  foreach ($tutorial->$tut_method as $files) {
				$html .=  '<li>' . Html::a("File ".$j, ['tutorial-cancel-file/download-file', 'attr' => 'path','id'=> $files->id],['target' => '_blank']) . '</li>';
				$j++;
			  }
			  $html .=  '</ul>';
			}
			$i++;
			$html .=  '</li>';
		  }
		} 
	  }
	$html .=  '</ul>';
	}
	
	return $html;
}


?>