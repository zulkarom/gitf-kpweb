<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\modules\courseFiles\models\Common;
?>


<div class="box-header">
  <div class="box-title"><b>Peringkat Tindakan/ Review Level
    <br/><div class="box-title">(ACT)</b></div>
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
    
        $item = $model->itemAct;
        $offer =  $modelOffer;
		$version = $offer->course_version;
        
        echo '<tr><td>'.$item[0]->id.'</td>
                <td>'.$item[0]->item.'<i><br/>'.$item[0]->item_bi.'</i></td>
                <td>';
			
             if($version == 0){
				echo 'Coordinator need to select course version.';
			}else{
				if($offer->na_cqi == 1){
					echo '<ul>
						<li><a href="'.Url::to('@web/doc/na.pdf').'" target="_blank">N/A</a></li>
					</ul>
					';
				}else{
					echo '<ul>
					<li><a href="'.Url::to(['/esiap/course/fk3', 'course'=> $offer->course_id, 'version' => $version, 'offer' => $offer->id, 'cqi' => 1]).'" target="_blank">FK03 - PENJAJARAN KONSTRUKTIF</a><br />
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
</div>