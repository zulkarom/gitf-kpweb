<?php 

use backend\modules\sae\models\Answer;

$dirAsset = Yii::$app->assetManager->getPublishedUrl('@backend/assets/adminlte');
$this->title = 'View Participant';
$this->params['breadcrumbs'][] = ['label' => 'Participants', 'url' => ['/sae/answer/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
<div class="col-md-6">
<div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-info">
                <h3 class="widget-user-username"><?php echo $user->can_name;?></h3>
                <h5 class="widget-user-desc"><?php echo $user->username;?></h5>
                <?=$answer->statusLabel?>
              </div>
  
              
            </div>
</div>


</div>



<div class="card">
	<div class="card-body">

	<br />


		<div class="row">
		

			<div class="col-md-12">
				<table class="table">
				<thead>
				<tr>
				<?php
				$rowstring="";
				foreach($gcat as $grow){
					echo "<th>".$grow->gcat_text ."</th>";
					$result_cat = Answer::getAnswersByCat($user->id,$grow->id);
					$stringdata ="<table class='table'>
					<tr><td><strong>Q</strong></td>
					<td><strong>A</strong></td>
					</tr>";
					$jum = 0;
					foreach($result_cat as $rowcat){
						$stringdata .="<tr>";
						$stringdata .="<td>".$rowcat->quest ."</td>";
						if($rowcat->answer == 1){
							$ans ="<span class='fa fa-check' style='color:green'></span>";
							$jum +=1;
						}else if($rowcat->answer == 0){
							$ans ="<span class='fa fa-times' style='color:red'></span>";
						}else{
							$ans ="NA";
						}
						$stringdata .="<td>".$ans ."</td>";
						$stringdata .="</tr>";
					}
					$stringdata .="<tr><td><strong>Total</strong></td><td>".$jum."</td></tr></table>";
					$rowstring .= "<td>".$stringdata."</td>";
				}
				?>

				</tr>
				<thead>
				<tr>

				<?php echo $rowstring; ?>

				</tr>
				<tbody>
				</tbody>
				</table>

			</div>

			
		</div>
		
		



	</div>
</div>


<div class="box">
<div class="box-header">
  <h3 class="box-title">
    BUSINESS IDEA
  </h3>
</div>
<div class="box-body">

<?=$answer->biz_idea?>

</div></div>


