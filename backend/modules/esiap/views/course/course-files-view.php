
<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\modules\courseFiles\models\Common;
use backend\modules\courseFiles\views\admin\Show;
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
  <div class="box-title"><b><?=$offer ? $offer->course->course_code . ' ' . $offer->course->course_name : '';?></b></div>
</div>

<div class="box-body">
<?php if($offer){?>
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
    
       $item = $model->itemPlan;

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
					<li><a href="'.Url::to(['/esiap/course/fk2', 'course'=> $offer->course_id, 'version' => $version]).'" target="_blank">FK02 - MAKLUMAT KURSUS</a></li>';
					
					$type_link = $offer->courseVersion->version_type_id == 1 ? 'tbl4' : 'tbl4-pdf';
					echo '<li><a href="'.Url::to(['/esiap/course/' . $type_link, 'course'=> $offer->course_id, 'version' => $version, 'team' => $offer->id]).'" target="_blank">TABLE 4</a></li>
					</ul>
					';
				if($version2 > 0){
					echo '<div class="grup"><i>Group 2</i></div>';
					echo '<ul>
					<li><a href="'.Url::to(['/esiap/course/fk2', 'course'=> $offer->course_id, 'version' => $version2]).'" target="_blank">FK02 - MAKLUMAT KURSUS</a></li>';
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
				  echo '<li>' . Html::a(strtoupper($files->file_name), ['/course-files/coordinator-rubrics-file/download-file', 'attr' => 'path','id'=> $files->id],['target' => '_blank']);
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
          
          
          $item = $model->itemDo;
          
          
          echo '<tr><td>6</td>
                <td>'.$item[4]->item.'<i><br/>'.$item[4]->item_bi.'</i></td>
                <td>';
          
          
          
          
          
          echo Show::showCoor($offer, 'coordinatorAssessmentMaterialFiles', '/course-files/coordinator-assessment-material-file', 'cont_material');
          
          
          
          echo '<tr><td>7</td>
                <td>'.$item[5]->item.'<i><br/>'.$item[5]->item_bi.'</i></td>
                <td>';
          
          echo Show::showCoor($offer, 'coordinatorAssessmentScriptFiles', '/course-files/coordinator-assessment-script-file', 'cont_script');
          
          
          echo '<tr><td>8</td>
                <td>'.$item[6]->item.'<i><br/>'.$item[6]->item_bi.'</i></td>
                <td>';
          
          echo Show::showCoor($offer, 'coordinatorSummativeAssessmentFiles', '/course-files/coordinator-summative-assessment-file', 'sum_assess');
          
          
          
          
          echo '<tr><td>9</td>
                <td>'.$item[7]->item.'<i><br/>'.$item[7]->item_bi.'</i></td>
                <td>';
          if($offer->na_script_final == 1){
              echo '<ul>
				<li><a href="'.Url::to('@web/doc/na.pdf').'" target="_blank">N/A</a> '.Common::ptick().'</li>
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
          
          
          
          /////
          
          $item = $model->itemCheck;
          $boo = true;
          
          
          echo '<tr><td>10</td>
                <td>'.$item[3]->item.'<i><br/>'.$item[3]->item_bi.'</i></td>
                <td>';
          if($version == 0){
              echo 'The coordinator needs to select course version.';
          }else{
              if($version2 > 0){
                  echo '<div class="grup"><i>Group 1</i></div>';
                  echo '<ul>
					<li><a href="'.Url::to(['/esiap/course/fk3', 'course'=> $offer->course_id, 'version' => $version, 'offer' => $offer->id ,'xana' => 1, 'group' => 1]).'" target="_blank">FK03 - PENJAJARAN KONSTRUKTIF</a><br />
					<i>(CLO achievement result)</i>
					</li>
					</ul>
				';
              }else{
                  echo '<ul>
					<li><a href="'.Url::to(['/esiap/course/fk3', 'course'=> $offer->course_id, 'version' => $version, 'offer' => $offer->id ,'xana' => 1]).'" target="_blank">FK03 - PENJAJARAN KONSTRUKTIF</a><br />
					<i>(CLO achievement result)</i>
					</li>
					</ul>
					';
              }
              
              if($version2 > 0){
                  echo '<div class="grup"><i>Group 2</i></div>';
                  echo '<ul>
					<li><a href="'.Url::to(['/esiap/course/fk3', 'course'=> $offer->course_id, 'version' => $version, 'offer' => $offer->id ,'xana' => 1, 'group' => 2]).'" target="_blank">FK03 - PENJAJARAN KONSTRUKTIF</a><br />
					<i>(CLO achievement result)</i>
					</li>
					</ul>
					';
              }
          }
          
          echo '</td>
                <td>' . Common::pTick($boo);
          
          
          
          
          echo '</td>';
          
          
          
          
          $item = $model->itemAct;

          
          echo '<tr><td>11</td>
                <td>'.$item[0]->item.'<i><br/>'.$item[0]->item_bi.'</i></td>
                <td>';
          
          if($version == 0){
              echo 'Coordinator need to select course version.';
          }else{
              if($offer->na_cqi == 1){
                  echo '<ul>
						<li><a href="'.Url::to(['/esiap/course/fk3', 'course'=> $offer->course_id, 'version' => $version, 'offer' => $offer->id, 'cqi' => 2,'xana' => 1]).'" target="_blank">FK03 - PENJAJARAN KONSTRUKTIF (N/A)</a><br />
					<i>(Course Improvement)</i>
					</li>
					</ul>
					';
              }else{
                  echo '<ul>
					<li><a href="'.Url::to(['/esiap/course/fk3', 'course'=> $offer->course_id, 'version' => $version, 'offer' => $offer->id, 'cqi' => 1 ,'xana' => 1]).'" target="_blank">FK03 - PENJAJARAN KONSTRUKTIF</a><br />
					<i>(Course Improvement)</i>
					</li>
					</ul>
					';
              }
              
          }
          
          echo '</td>
                <td>';
          if($offer->prg_cqi == 1){
              echo Common::pTick();
          }else{
              echo Common::pTick(false);
          }
          
          
          echo '</td>';
          
          
          
          
          
          ?>

      </tr>
    </thead>
  </table>
<?php } else{echo  'Data not found';}?>
</div>