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
				
			echo showCoor($offer, 'coordinatorAssessmentMaterialFiles', 'coordinator-assessment-material-file');
				
				echo '</td>
                <td>';
    
                      
                
          echo '</td>';

          echo '<tr><td>'.$item[5]->id.'</td>
                <td>'.$item[5]->item.'<i><br/>'.$item[5]->item_bi.'</i></td>
                <td>';
				
				echo showCoor($offer, 'coordinatorAssessmentScriptFiles', 'coordinator-assessment-script-file');
				

				
			echo '</td>
                <td>';
  
                     
                
          echo '</td>';

          echo '<tr><td>'.$item[6]->id.'</td>
                <td>'.$item[6]->item.'<i><br/>'.$item[6]->item_bi.'</i></td>
                <td>';
				
		echo showCoor($offer, 'coordinatorSummativeAssessmentFiles', 'coordinator-summative-assessment-file');
				
				
			echo '</td>
                <td>';

                      
       
          echo '</td>';

          echo '<tr><td>'.$item[7]->id.'</td>
                <td>'.$item[7]->item.'<i><br/>'.$item[7]->item_bi.'</i></td>
                <td>
				
				<ul>
			<li>THE THREE (3) BEST ANSWER SCRIPTS
				<ul>';
	
			echo scriptLink($offer, 'best');
			
					/*
					<li>SCRIPT 2</li>
					<li>SCRIPT 3</li> */
			echo '</ul>
			</li>
			
			<li>THE THREE (3) MODERATE ANSWER SCRIPTS
				<ul>';
				
				echo scriptLink($offer, 'mod');
				
			echo '</ul>
			
			</li>
			
			<li>THE THREE (3) LOWEST ANSWER SCRIPTS
				<ul>';
				
				echo scriptLink($offer, 'low');
				
			echo '</ul>
			</li>
			

				</ul>

</td>
                <td>';
           
                     
                 
          echo '</td>';

          echo '<tr><td>'.$item[8]->id.'</td>
                <td>'.$item[8]->item.'<i><br/>'.$item[8]->item_bi.'</i></td>
                <td>';
				
		echo  showExempt($offer, 'lectureExemptFiles', 'tutorialExemptFiles');

		echo '</td>
                <td>';



                        
          echo '</td>';
        ?>
    
      </tr>
    </thead>
   
  </table>
</div>


<?php 

function scriptLink($offer, $type){
	$html = '';
	for($s=1;$s<=3;$s++){
		$sc = 'script'.$type. $s;
		$col = $sc . '_file';
		if($offer->$col){
			$html .= '<li><a href="' . Url::to(['/course-files/coordinator-upload/download-file', 'attr' => $sc, 'id' => $offer->id]) . '" target="_blank">SCRIPT '.$s.'</a></li>';
		}
		
	}
	return $html;
}

function showCoor($offer, $method, $link){
	$html = '';
	if($offer->$method){
		$i=1;
		$html .=  '<ul>';
		foreach ($offer->$method as $files) {
		  $html .=  '<li>' . Html::a(strtoupper($files->file_name), [$link . '/download-file', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
		  $html .=  '</li>';
		  $i++;
		}
		$html .=  '</ul>';
	  }
	return $html;
}

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

function showExempt($offer, $lec_method, $tut_method){
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
			if($file->path_file){
				$html .=  '<li>' . Html::a($file->matric_no . '-' . date('d/m/Y', strtotime($file->ex_date)) , ['lecture-exempt-file/download-file', 'attr' => 'path','id'=> $file->id],['target' => '_blank']) . '</li>';
			}
			

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
			  foreach ($tutorial->$tut_method as $file) {
				$html .=  '<li>' . Html::a($file->matric_no . '-' . date('d/m/Y', strtotime($file->ex_date)) , ['tutorial-cancel-file/download-file', 'attr' => 'path','id'=> $file->id],['target' => '_blank']) . '</li>';
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