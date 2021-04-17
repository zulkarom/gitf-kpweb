<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\modules\courseFiles\models\Common;
use backend\modules\courseFiles\views\admin\Show;
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
        <th>Check</th>
      </tr>
    
        
        <tr>
        <?php 
		
	$item = $model->itemDo;
        $offer =  $modelOffer;
    

        //list student
          echo '<tr><td>'.$item[0]->id.'</td>
                <td>'.$item[0]->item.'<i><br/>'.$item[0]->item_bi.'</i></td>
                <td>';
		$boo = false;	
		if($offer->lectures){
			$i=1;
			echo '<ul>';
			$boo = true;
			foreach ($offer->lectures as $lecture) {  
			
				if($lecture->prg_stu_list == 1){
					$boo = $boo == false ? false : true;
					echo '<li><a href="'.Url::to(['/course-files/default/lecture-student-list-pdf', 'id'=> $lecture->id]).'" target="_blank">'.$lecture->lec_name .' - LIST OF STUDENTS   '.Common::pTick().'</a></li>';
				}else{
					$boo = false;
					echo '<li>'.$lecture->lec_name .' - LIST OF STUDENTS   '.Common::pTick(false).'</li>';
				}
				
			}
			echo '</ul>';
		}else{
				$boo = false;
				echo'<ul><li>'.Common::pTick(false).'</li></ul>';
			}
				
		echo '</td>
                <td>'.Common::pTick($boo).'</td>';


          echo '<tr><td>'.$item[1]->id.'</td>
                <td>'.$item[1]->item.'<i><br/>'.$item[1]->item_bi.'</i></td>
                <td>';
			if($offer->lectures){
			$i=1;
			echo '<ul>';
			$boo = true;
			foreach ($offer->lectures as $lecture) {  
				if($lecture->prg_stu_attend == 1){
					$boo = $boo == false ? false : true;
					echo '<li><a href="'.Url::to(['/course-files/default/attendance-summary-pdf', 'id'=> $lecture->id]).'" target="_blank">'.$lecture->lec_name .' - CLASS ATTENDANCE  '.Common::pTick().'</a></li>';
				}else{
					$boo = false;
					echo '<li>'.$lecture->lec_name .' - CLASS ATTENDANCE '.Common::pTick(false).'</li>';
				}
				
			}
			echo '</ul>';
		}else{
				$boo = false;
				echo'<ul><li>'.Common::pTick(false).'</li></ul>';
			}
			
		echo '</td>
                <td>'.Common::pTick($boo).'</td>';

          echo '<tr><td>'.$item[2]->id.'</td>
                <td>'.$item[2]->item.'<i><br/>'.$item[2]->item_bi.'</i></td>
                <td>';
				

                            
            echo  Show::showLecTut($offer, 'lectureCancelFiles', 'tutorialCancelFiles', 'cancel', 'class_cancel');


				
			

          echo '<tr><td>'.$item[3]->id.'</td>
                <td>'.$item[3]->item.'<i><br/>'.$item[3]->item_bi.'</i></td>
                <td>';
				
			 echo  Show::showLecTut($offer, 'lectureReceiptFiles', 'tutorialReceiptFiles', 'receipt', 'receipt_assess');
                           
				
	

          echo '<tr><td>'.$item[4]->id.'</td>
                <td>'.$item[4]->item.'<i><br/>'.$item[4]->item_bi.'</i></td>
                <td>';
				
			echo Show::showCoor($offer, 'coordinatorAssessmentMaterialFiles', 'coordinator-assessment-material-file', 'cont_material');
				
			

          echo '<tr><td>'.$item[5]->id.'</td>
                <td>'.$item[5]->item.'<i><br/>'.$item[5]->item_bi.'</i></td>
                <td>';
				
				echo Show::showCoor($offer, 'coordinatorAssessmentScriptFiles', 'coordinator-assessment-script-file', 'cont_script');
	

          echo '<tr><td>'.$item[6]->id.'</td>
                <td>'.$item[6]->item.'<i><br/>'.$item[6]->item_bi.'</i></td>
                <td>';
				
		echo Show::showCoor($offer, 'coordinatorSummativeAssessmentFiles', 'coordinator-summative-assessment-file', 'sum_assess');
				
				
			

          echo '<tr><td>'.$item[7]->id.'</td>
                <td>'.$item[7]->item.'<i><br/>'.$item[7]->item_bi.'</i></td>
                <td>';
		if($offer->na_script_final == 1){
		echo '<ul>
				<li>N/A '.Common::ptick().'</li>
			</ul>
			';
	}else{
		echo '<ul>
			<li>THE THREE (3) BEST ANSWER SCRIPTS
				<ul>';
	
			echo Show::scriptLink($offer, 'best');
			
					/*
					<li>SCRIPT 2</li>
					<li>SCRIPT 3</li> */
			echo '</ul>
			</li>
			
			<li>THE THREE (3) MODERATE ANSWER SCRIPTS
				<ul>';
				
				echo Show::scriptLink($offer, 'mod');
				
			echo '</ul>
			
			</li>
			
			<li>THE THREE (3) LOWEST ANSWER SCRIPTS
				<ul>';
				
				echo Show::scriptLink($offer, 'low');
				
			echo '</ul>
			</li>
			

				</ul>';
	}
		
				
		echo '

</td>
                <td>';
           
             if($offer->prg_sum_script == 1){
				 echo Common::ptick();
			 }else{
				 echo Common::ptick(false);
			 }
                 
          echo '</td>';

          echo '<tr><td>'.$item[8]->id.'</td>
                <td>'.$item[8]->item.'<i><br/>'.$item[8]->item_bi.'</i></td>
                <td>';
				
		echo  Show::showLecTut($offer, 'lectureExemptFiles', 'tutorialExemptFiles', 'exempt', 'class_exempt');

		
        ?>
    
      </tr>
    </thead>
   
  </table>
</div>

